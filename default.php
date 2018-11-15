<?php
define('ROOT', dirname(__FILE__));
define('QUESTIONS_NUM', 40);

$config = require_once(ROOT . '/config/db.php');

require_once(ROOT . '/components/Autoloader.php');
$autoloader = new \app\components\Autoloader();
$autoloader->register();

$db = \app\components\DB::getInstance($config);
$conn = $db->getConnection();