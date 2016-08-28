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

$app->get('/dogs/feed/{id}', function ($id) use ($app) {
	$dog = Dog::loadById($id);
	if (!$dog){
		$app->abort(404, "This dog does not exist");
	}
	else{
		$dog->feed();
		return $app['twig']->render('feed.html', ['result' => true]);
	}
})
->bind("dogs-feed");

$app->get('/dogs/details/{id}', function ($id) use ($app) {
	$dog = Dog::loadById($id);
	if (!$dog){
		$app->abort(404, "This dog does not exist");
	}
	else{
		return $app['twig']->render($dog->viewDetailsFile(), ['result' => true, 'dog' => $dog->toArray()]);
	}
})
->bind("dogs-details");
