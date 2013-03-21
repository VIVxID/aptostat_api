<?php

// Initiate propel
Propel::init(__DIR__ . '/../../../build/conf/aptostat_api-conf.php');
set_include_path(__DIR__ . '/../../../build/classes' . PATH_SEPARATOR . get_include_path());

// Load classes
use Symfony\Component\HttpFoundation\Request;

// GET: /report - Return a list of reports
$app->get('/api/report', function() use ($app) {
    $reportService = new aptostatApi\Service\ReportService();
    $reports = $reportService->getList();

    return $app->json($reports);
});

// GET: /report/{id} - Return a spesific report
$app->get('/api/report/{reportId}', function($reportId) use ($app) {
    $reportService = new aptostatApi\Service\ReportService();

    try {
        $report = $reportService->getReportById($reportId);
        return $app->json(array('report' => $report));
    } catch (\InvalidArgumentException $e) {
        return $app->json(array(
                'errorCode' => $e->getCode(),
                'errorDesc' => $e->getMessage()
            ), $e->getCode());
    } catch (\aptostatApi\Service\Exception\NotFoundException $e) {
        return $app->json(array(
                'errorCode' => $e->getCode(),
                'errorDesc' => $e->getMessage()
            ), $e->getCode());
    }
});

// PUT: /report/{reportId} - Modify report
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
                'errorDesc' => 'The id provided is not a number'
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
