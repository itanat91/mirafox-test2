<?php

define('ROOT', dirname(__FILE__));

$config = require_once(ROOT . '/config/db.php');

require_once(ROOT . '/components/Autoloader.php');
$autoloader = new \app\components\Autoloader();
$autoloader->register();

$link = new PDO($config['dsn'], $config['username'], $config['password']);

