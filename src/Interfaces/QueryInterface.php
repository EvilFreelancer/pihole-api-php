<?php

namespace PiHole\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface QueryInterface
{
    /**
     * Execute request and return response
     *
     * @return null|object Array with data or NULL if error
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ErrorException
     * @throws \PiHole\Exceptions\EmptyResults
     */
    public function exec();

    /**
     * Execute query and return RAW response from remote API
     *
     * @return null|\Psr\Http\Message\ResponseInterface RAW response or NULL if error
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ErrorException
     * @throws \PiHole\Exceptions\EmptyResults
     */
    public function raw(): ?ResponseInterface;
}
