<?php
require_once __DIR__ . '/../vendor/autoload.php';

$config = new \PiHole\Config();
$config
    ->set('webpassword', '6b600e5555af97b26ed51a5910a0b310d9da8e22a7aaf97ab0137bb4880ec55e')
    ->set('base_url', 'http://192.168.1.10/admin/api.php');

$client = new \PiHole\Client($config);
$result = $client->statistics()->exec();
print_r($result);
