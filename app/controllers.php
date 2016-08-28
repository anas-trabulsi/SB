<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
require_once __DIR__ . "/models/Dog.php";
require_once __DIR__ . "/../data/data.php";
$app['debug'] = true;
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

$app->get('/dogs/action/{action}/{id}', function ($id, $action) use ($app) {
	$dog = Dog::loadById($id);
	if (!$dog){
		$app->abort(404, "This dog does not exist");
	}
	else{
		if (!$dog->hasAction($action)){
			$app->abort(404, "Action does not exist for this dog");
		}
		else{
			$errorMessage = "";
			try{
				$result = $dog->executeAction($action);
			}
			catch (Exception $e){
				$result = false;
				$errorMessage = $e->getMessage();
			}
			return $app['twig']->render('action.html', ['result' => $result, 'errorMessage' => $errorMessage]);
		}
	}
})
->bind("dogs-action");

$app->get('/dogs/details/{id}', function ($id) use ($app) {
	$dog = Dog::loadById($id);
	if (!$dog){
		$app->abort(404, "This dog does not exist");
	}
	else{
		return $app['twig']->render($dog->viewDetailsFile(), ['dog' => $dog->toArray()]);
	}
})
->bind("dogs-details");
