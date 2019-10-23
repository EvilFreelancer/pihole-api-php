<?php

namespace PiHole;

use PiHole\Interfaces\QueryInterface;

trait CoreTrait
{
    /**
     * @return \PiHole\Interfaces\QueryInterface
     */
    public function statistics(): self
    {
        // Set HTTP params
        $this->type     = 'get';
        $this->endpoint = [];
        return $this;
    }

    /**
     * stats
     *
     * @return array
     */
    public function version(): array
    {

    }

    /**
     * enable pihole
     * should be authorized
     */
    public function enable()
    {
        // ?enable&auth=webpassword
    }

    /**
     * disable pihole
     * should be authorized
     */
    public function disable()
    {
        // ?disable&auth=webpassword
    }

    /**
     * disable pihole
     * should be authorized
     */
    public function logout()
    {
        // ?logout&auth=webpassword
    }

    /**
     * disable pihole
     * should be authorized
     */
    public function jsonForceObject()
    {
        // ?jsonForceObject
    }

}
