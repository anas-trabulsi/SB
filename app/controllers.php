<?php

$app->get('/', function () use ($app) {
	return $app['twig']->render('home.html');
})
->bind("home");