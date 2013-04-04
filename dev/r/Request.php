<?php

require_once __DIR__ . '/../vendor/autoload.php';
//use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application;

// Debug
$app['debug']=true;

$app->get('/report', function() use ($app) {
	return 'getReportList';
});

$app->get('/report/{id}', function($id) use ($app) {
	return 'getReport ' . $id;
});

$app->run();

//$req = Request::createFromGlobals();
//echo var_dump($req);

