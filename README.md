[![Latest Stable Version](https://poser.pugx.org/evilfreelancer/pihole-api-php/v/stable)](https://packagist.org/packages/evilfreelancer/pihole-api-php)
[![Build Status](https://travis-ci.org/EvilFreelancer/pihole-api-php.svg?branch=master)](https://travis-ci.org/EvilFreelancer/pihole-api-php)
[![Total Downloads](https://poser.pugx.org/evilfreelancer/pihole-api-php/downloads)](https://packagist.org/packages/evilfreelancer/pihole-api-php)
[![License](https://poser.pugx.org/evilfreelancer/pihole-api-php/license)](https://packagist.org/packages/evilfreelancer/pihole-api-php)
[![Code Climate](https://codeclimate.com/github/EvilFreelancer/pihole-api-php/badges/gpa.svg)](https://codeclimate.com/github/EvilFreelancer/pihole-api-php)
[![Code Coverage](https://scrutinizer-ci.com/g/EvilFreelancer/pihole-api-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/EvilFreelancer/pihole-api-php/?branch=master)
[![Scrutinizer CQ](https://scrutinizer-ci.com/g/evilfreelancer/pihole-api-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/evilfreelancer/pihole-api-php/)

# Pi-Hole API PHP client

    composer require evilfreelancer/pihole-api-php

## How to use

```php
$config = new \PiHole\Config([
    'webpassword' => '6b600e5555af97b26ed51a5910a0b310d9da8e22a7aaf97ab0137bb4880ec55e',
    'base_url'    => 'http://192.168.1.10/admin/api.php'
]);

$client = new \PiHole\Client($config);

// Get all stats
$statistics = $client->statistics()->exec();
print_r($statistics);

// Get version of PiHole
$version = $client->version()->exec();
print_r($version);

// Enable ADBlocking on PiHole
$enable = $client->enable()->exec();
print_r($enable);

// Disable ADBlocking on PiHole
$disable = $client->disable()->exec();
print_r($disable);

// Logout from PiHole
$logout = $client->logout()->exec();
print_r($logout);
```

## List of available configuration parameters

| Parameter         | Type   | Default | Description |
|-------------------|--------|---------|-------------|
| webpassword       | string |         | (required) Hash of password |
| base_url          | string |         | (required) Url with path to admin.php |
| proxy             | string |         | HTTP proxy connection string |
| json_force_object | bool   | true    | Will enable flag JSON_FORCE_OBJECT of json_encode |
| timeout           | int    | 10      | Max timeout for answer from RouterOS |
| attempts          | int    | 10      | Count of attempts to establish TCP session |
| delay             | int    | 1       | Delay between attempts in seconds |
| debug             | bool   | true    | Enable full debug of all HTTP queries |

# Links

* https://pi-hole.net
