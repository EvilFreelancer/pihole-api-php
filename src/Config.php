<?php

namespace PiHole;

class Config
{
    /**
     * List of allowed parameters
     */
    public const ALLOWED = [
        'webpassword',
        'json_force_object',
        'proxy',
        'base_url',
        'user_agent',
        'timeout',
        'tries',
        'seconds',
        'debug',
        'track_redirects',
    ];

    /**
     * List of minimal required parameters
     */
    public const REQUIRED = [
        'user_agent',
        'base_url',
        'timeout',
        'webpassword',
    ];

    /**
     * List of configured parameters
     *
     * @var array
     */
    private $_parameters;

    /**
     * Config constructor.
     *
     * @param array $parameters List of parameters which can be set on object creation stage
     *
     * @throws \ErrorException
     */
    public function __construct(array $parameters = [])
    {
        // Set default parameters of client
        $this->_parameters = [
            // Errors must be disabled by default, because we need to get error codes
            // @link http://docs.guzzlephp.org/en/stable/request-options.html#http-errors
            'http_errors'       => false,

            // Wrapper settings
            'tries'             => 2,  // Count of tries
            'seconds'           => 10, // Waiting time per each try

            // Optional parameters
            'debug'             => false,
            'track_redirects'   => false,

            // Main parameters
            'json_force_object' => false,
            'timeout'           => 20,
            'user_agent'        => 'Pi-Hole PHP Client',
        ];

        // Overwrite parameters by client input
        foreach ($parameters as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * Magic setter parameter by name
     *
     * @param string               $name  Name of parameter
     * @param string|bool|int|null $value Value of parameter
     */
    public function __set(string $name, $value)
    {
        $this->set($name, $value);
    }

    /**
     * Check if parameter if available
     *
     * @param string $name Name of parameter
     *
     * @return bool
     */
    public function __isset($name): bool
    {
        return isset($this->_parameters[$name]);
    }

    /**
     * Get parameter via magic call
     *
     * @param string $name Name of parameter
     *
     * @return bool|int|string|null
     * @throws \InvalidArgumentException
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Remove parameter from array
     *
     * @param string $name Name of parameter
     */
    public function __unset($name)
    {
        unset($this->_parameters[$name]);
    }

    /**
     * Set parameter by name
     *
     * @param string               $name  Name of parameter
     * @param string|bool|int|null $value Value of parameter
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function set(string $name, $value): self
    {
        if (!\in_array($name, self::ALLOWED, false)) {
            throw new \InvalidArgumentException("Parameter \"$name\" is not in available list [" . implode(',', self::ALLOWED) . ']');
        }

        // Add parameters into array
        $this->_parameters[$name] = $value;
        return $this;
    }

    /**
     * Get available parameter by name
     *
     * @param string $name Name of parameter
     *
     * @return bool|int|string|null
     * @throws \InvalidArgumentException
     */
    public function get(string $name)
    {
        if (!isset($this->_parameters[$name])) {
            throw new \InvalidArgumentException("Parameter \"$name\" is not in set");
        }

        return $this->_parameters[$name];
    }

    /**
     * Get all available parameters
     *
     * @return array
     */
    public function all(): array
    {
        return $this->_parameters;
    }

    /**
     * Generate query by parameters
     *
     * @param array $url
     * @param bool  $auth
     *
     * @return string
     */
    public function getBaseUrl(array $url = [], bool $auth = false): string
    {
        if ($auth) {
            $url['auth'] = $this->get('webpassword');
        }

        if ($this->get('json_force_object')) {
            $url['jsonForceObject'] = null;
        }

        return $this->get('base_url') . '?' . http_build_query($url);
    }

    /**
     * Return all ready for Guzzle parameters
     *
     * @return array
     */
    public function guzzle(): array
    {
        $options = [
            'timeout'         => $this->get('timeout'),
            'track_redirects' => $this->get('track_redirects'),
            'debug'           => $this->get('debug'),
            'headers'         => [
                'User-Agent' => $this->get('user_agent'),
            ]
        ];

        // Proxy is optional
        if (isset($this->proxy)) {
            $options['proxy'] = $this->proxy;
        }

        return $options;
    }
}
