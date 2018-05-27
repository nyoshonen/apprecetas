<?php

if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

require __DIR__.'/../vendor/autoload.php';

// app
$settings = require __DIR__.'/settings.php';
$app = new \Slim\App($settings);

// dependencies
require __DIR__.'/dependencies.php';

// routes
require __DIR__.'/routes.php';
