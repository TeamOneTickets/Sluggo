<?php

error_reporting(-1);

$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('Sluggo\Test', __DIR__);

require_once 'PHPUnit/Framework/Assert/Functions.php';
