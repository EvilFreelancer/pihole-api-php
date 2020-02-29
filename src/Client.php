<?php

namespace PiHole;

use PiHole\Interfaces\QueryInterface;

/**
 * Single entry point for all classes
 *
 * @package PiHole
 */
class Client implements QueryInterface
{
    use HttpTrait;

    /**
     * Type of query
     *
     * @var string
     */
    protected $type = 'get';

    /**
     * Endpoint of query
     *
     * @var array
     */
    protected $endpoint = [];

    /**
     * If auth is required
     *
     * @var bool
     */
    protected $auth = false;

    /**
     * Parameters of query
     *
     * @var mixed
     */
    protected $params;

    /**
     * @var array
     */
    protected static $variables = [];

    /**
     * Client constructor.
     *
     * @param \PiHole\Config $config
     */
    public function __construct(Config $config)
    {
        // Save config into local variable
        $this->config = $config;

        // Store the client object
        $this->client = new \GuzzleHttp\Client($config->guzzle());
    }

    /**
     * Get detailed statistic of system
     *
     * @return \PiHole\Interfaces\QueryInterface
     */
    public function statistics(): QueryInterface
    {
        return $this;
    }

    /**
     * Get version of Pi Hole
     *
     * @return \PiHole\Interfaces\QueryInterface
     * @link ?version
     */
    public function version(): QueryInterface
    {
        $this->endpoint = ['version' => null];
        return $this;
    }

    /**
     * Enable pihole (should be authorized)
     *
     * @return \PiHole\Interfaces\QueryInterface
     * @link ?enable&auth=webpassword
     */
    public function enable(): QueryInterface
    {
        $this->endpoint = ['enable' => null];
        return $this;
    }

    /**
     * Disable pihole (should be authorized)
     *
     * @return \PiHole\Interfaces\QueryInterface
     * @link ?disable&auth=webpassword
     */
    public function disable(): QueryInterface
    {
        $this->endpoint = ['disable' => null];
        return $this;
    }

    /**
     * Logout from pihole (should be authorized)
     *
     * @return \PiHole\Interfaces\QueryInterface
     * @link ?logout&auth=webpassword
     */
    public function logout(): QueryInterface
    {
        $this->endpoint = ['logout' => null];
        return $this;
    }
}
