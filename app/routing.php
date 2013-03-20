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
include __DIR__ . '/../src/aptostatApi/controller/reportController.php';

// Incident
include  __DIR__ . '/../src/AptostatApi/controller/incidentController.php';

// Api
$app->match('/api/', function() use ($app) {
        $out = array('statusDesc' => 'Read documentation for proper use of the API');
        return $app->json($out, 200);
});

// End user front-end
$app->match('/', function() use ($app) {
	return "Index";
});
