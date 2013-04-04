<?php

// Silex bootloader
require_once __DIR__ . '/../vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application;

// Debug
$app['debug']=true;

$app->get('/report', function() use ($app) {
        return 'get;
});

$app->get('/report/{id}', function($id) use ($app) {
        return 'get' . $id;
});

//$req = Request::createFromGlobals();
//echo var_dump($req);
