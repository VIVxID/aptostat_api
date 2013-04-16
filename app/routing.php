<?php

use Symfony\Component\HttpFoundation\Request;

// Fetch http package and
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

include __DIR__ . '/../src/aptostatApi/controller/reportController.php';
include  __DIR__ . '/../src/aptostatApi/controller/incidentController.php';

$app->match('/api', function() use ($app) {
        $out = array('statusDesc' => 'Read documentation for proper use of the API');
        return $app->json($out, 200);
});

// Include liveController
include '../src/aptostatApi/controller/liveController.php';

// Include uptimeController
include '../src/aptostatApi/controller/uptimeController.php';

// Api
$app->match('/api/', function() use ($app) {
	$out = array('statusDesc' => 'Read documentation for proper use of the API');
	return $app->json($out, 200);

});

// End user front-end
$app->match('/', function() use ($app) {
    $out = array('statusDesc' => 'Read documentation for proper use of the API');
    return $app->json($out, 200);
});
