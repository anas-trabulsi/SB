<?php

require_once __DIR__ . '/../vendor/autoload.php';

$filename = __DIR__ . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
	//This is php built-in webserver. It is used only in the development environment
	//When requesting a CSS, JS, or image file, we need to escape it to allow the delivery
	return false;
}

$app = require __DIR__.'/../app/app.php';
require __DIR__.'/../app/controllers.php';
$app->run();
