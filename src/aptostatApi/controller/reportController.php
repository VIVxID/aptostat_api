<?php

// Initiate propel
require_once '/var/www/vendor/propel/propel1/runtime/lib/Propel.php';
Propel::init("/var/www/build/conf/aptostat-conf.php");
set_include_path("/var/www/build/classes" . PATH_SEPARATOR . get_include_path());

// Load classes
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

// GET: api/report - Return a list of reports
$app->get('/api/report', function() use ($app) {
    $report = new aptostatApi\model\Report;
    $status = $report->queryList();

    switch ($status) {
        case 200:
            return $app->json($report->getList(), 200);
            break;
        case 404:
            return $app->json(array(
                'errorCode' => 404,
                'errorDesc' => 'No reports found'
                ), 404);
            break;
        default:
            return $app->json(array(
                'errorCode' => 500,
                'errorDesc' => 'Internal server error'
                ), 500);
            break;
    }
});

// GET: api/report/{id} - Return a spesific report
$app->get('/api/report/{reportId}', function($reportId) use ($app) {
    $report = new aptostatApi\model\Report;
    $status = $report->query($reportId);

    switch ($status) {
        case 200:
            return $app->json($report->get(), 200);
            break;
        case 400:
            return $app->json(array(
                'errorCode' => 400,
                'errorDesc' => 'Id requested is not a number'
                ), 400);
            break;
        case 404:
            return $app->json(array(
                'errorCode' => 404,
                'errorDesc' => 'Report with that ID not found'
                ), 404);
            break;
        default:
            return $app->json(array(
                'errorCode' => 500,
                'errorDesc' => 'Internal server error'
                ), 500);
            break;
    }
});

// PUT: api/report/{reportId} - Modify report
$app->put('/api/report/{reportId}', function(Request $request, $reportId) use ($app) {
    $report = new aptostatApi\model\Report;
    $flag = $request->request->get('flag');

    switch ($report->modifyFlag($reportId, $flag)) {
        case 200:
            return $app->json(array(
                'message' => 'Report ' . $reportId . ' has been successfully modified'
                ), 200);
            break;
        case 400:
            return $app->json(array(
                'errorCode' => 400,
                'errorDesc' => 'The id is not a number'
                ), 400);
            break;
        case 404:
            return $app->json(array(
                'errorCode' => 404,
                'errorDesc' => 'Report with that ID not found'
                ), 404);
            break;
        default:
            return $app->json(array(
               'errorCode' => 500,
               'errorDesc' => 'Internal server error'
               ), 500);
            break;
    }
});
