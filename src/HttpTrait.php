<?php

namespace PiHole;

use ErrorException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use PiHole\Exceptions\EmptyResults;

/**
 * @author  Paul Rock <paul@drteam.rocks>
 * @link    https://drteam.rocks
 * @license MIT
 * @package PiHole
 */
trait HttpTrait
{
    /**
     * Initial state of some variables
     *
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * Object of main config
     *
     * @var \PiHole\Config
     */
    protected $config;

    /**
     * Request executor with timeout and repeat tries
     *
     * @param string     $type     Request method
     * @param array      $params   List of parameters
     * @param array|null $endpoint endpoint url
     * @param bool       $auth
     *
     * @return null|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ErrorException
     */
    private function repeatRequest(string $type, array $endpoint = null, array $params = null, bool $auth = false): ?ResponseInterface
    {
        $type = strtoupper($type);

        for ($i = 1; $i < $this->config->get('tries'); $i++) {

            if ($params === null) {
                // Execute the request to server
                $result = $this->client->request($type, $this->config->getBaseUrl($endpoint, $auth));
            } else {
                // Execute the request to server
                $result = $this->client->request($type, $this->config->getBaseUrl($endpoint, $auth), [RequestOptions::FORM_PARAMS => $params]);
            }

            // Check the code status
            $code   = $result->getStatusCode();
            $reason = $result->getReasonPhrase();

            // If success response from server
            if ($code === 200 || $code === 201) {
                return $result;
            }

            // If not "too many requests", then probably some bug on remote or our side
            if ($code !== 429) {
                throw new ErrorException($code . ' ' . $reason);
            }

            // Waiting in seconds
            sleep($this->config->get('seconds'));
        }

        // Return false if loop is done but no answer from server
        return null;
    }

    /**
     * Execute request and return response
     *
     * @return null|object Array with data or NULL if error
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ErrorException
     * @throws \PiHole\Exceptions\EmptyResults
     */
    public function exec()
    {
        return $this->doRequest($this->type, $this->endpoint, $this->params, false, $this->auth);
    }

    /**
     * Execute query and return RAW response from remote API
     *
     * @return null|\Psr\Http\Message\ResponseInterface RAW response or NULL if error
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ErrorException
     * @throws \PiHole\Exceptions\EmptyResults
     */
    public function raw(): ?ResponseInterface
    {
        return $this->doRequest($this->type, $this->endpoint, $this->params, true, $this->auth);
    }

    /**
     * Make the request and analyze the result
     *
     * @param string $type     Request method
     * @param array  $endpoint Api request endpoint
     * @param array  $params   List of parameters
     * @param bool   $raw      Return data in raw format
     * @param bool   $auth
     *
     * @return null|object|ResponseInterface Array with data, RAW response or NULL if error
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ErrorException
     * @throws \PiHole\Exceptions\EmptyResults
     */
    private function doRequest(string $type, array $endpoint = null, array $params = null, bool $raw = false, bool $auth = false)
    {
        // Null by default
        $response = null;

        // Execute the request to server
        $result = $this->repeatRequest($type, $endpoint, $params, $auth);

        if (null === $result) {
            throw new EmptyResults('Empty results returned from Pi-Hole API');
        }

        // Return RAW result if required
        return $raw ? $result : json_decode($result->getBody(), false);
    }

}
