<?php

namespace PiHole;

use BadMethodCallException;
use ErrorException;
use GuzzleHttp\Exception\ClientException;
use PiHole\Interfaces\QueryInterface;

/**
 * Single entry point for all classes
 *
 * @package PiHole
 */
class Client implements QueryInterface
{
    use HttpTrait, CoreTrait;

    /**
     * @var string
     */
    protected $namespace = __NAMESPACE__ . '\\Endpoints';

    /**
     * Type of query
     *
     * @var string
     */
    protected $type;

    /**
     * Endpoint of query
     *
     * @var string
     */
    protected $endpoint;

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
}
