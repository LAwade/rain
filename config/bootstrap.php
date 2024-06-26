<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => CONF_DB_DRIVER,
    'host' => CONF_DB_HOST,
    'port' => CONF_DB_PORT,
    'database' => CONF_DB_BASE,
    'username' => CONF_DB_USER,
    'password' => CONF_DB_PASSWD,
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();
