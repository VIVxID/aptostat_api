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
include  __DIR__ . '/../src/aptostatApi/controller/messageController.php';
include __DIR__ . '/../src/aptostatApi/controller/liveController.php';
include __DIR__ . '/../src/aptostatApi/controller/uptimeController.php';
include __DIR__ . '/../src/aptostatApi/controller/killswitchController.php';

// Api
$app->match('/api/', function() use ($app) {
	$out = array('statusDesc' => 'Read documentation for proper use of the API');
	return $app->json($out, 400);

});

// End user front-end
$app->match('/', function() use ($app) {
    $out = array('statusDesc' => 'Read documentation for proper use of the API');
    return $app->json($out, 400);
});