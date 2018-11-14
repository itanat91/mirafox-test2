<?php

define('ROOT', dirname(__FILE__));

$config = require_once(ROOT . '/config/db.php');

require_once(ROOT . '/components/Autoloader.php');
$autoloader = new \app\components\Autoloader();
$autoloader->register();

try {
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($config['dsn'], $config['username'], $config['password'], $opt);
} catch (PDOException $e) {
    die('Something went wrong');
}


