<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
require_once __DIR__ . "/models/Dog.php";
require_once __DIR__ . "/../data/data.php";

$app->get('/', function () use ($app) {
	return $app['twig']->render('home.html');
})
->bind("home");

$app->get('/dogs', function () use ($app) {
	$dogs = array();
	foreach (Dog::getAllDogs() as $oneDog){
		$dogs[] = $oneDog->toArray();
	}
	return $app['twig']->render('dogs.html', ['dogs' => $dogs]);
})
->bind("dogs-browse");
