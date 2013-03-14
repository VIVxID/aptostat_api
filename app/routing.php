<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

// Fetch http package and parameters
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

// Include report controller
include '../src/aptostatApi/controller/reportController.php';

// Incident
include '../src/AptostatApi/controller/incidentController.php';

// Api
$app->match('/api/', function() use ($app) {
        $out = array('statusDesc' => 'Read documentation for proper use of the API');
        return $app->json($out, 200);
});

// End user front-end
$app->match('/', function() use ($app) {
    try {
        $es = 0/0;
        return $es;
    } catch (Exception $e) {
        $app['monolog']->addError('HAODSLASLD');
        return "fail";
    }
});