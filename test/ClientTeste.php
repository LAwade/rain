<?php

require __DIR__ . '/../config/config.php';
require __DIR__ . '/../config/helpers.php';
require __DIR__ . '/../vendor/autoload.php';

use app\models\Client;

$client = new Client();

echo "\n\n--------------------------------------------------------------------------\n\n";

 print_r($client->findAll());

?>