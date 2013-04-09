<?php

// Initiate propel
Propel::init(__DIR__ . '/../../../build/conf/aptostat_api-conf.php');
set_include_path(__DIR__ . '/../../../build/classes' . PATH_SEPARATOR . get_include_path());

// Load classes
use Symfony\Component\HttpFoundation\Request;
use aptostatApi\Service\ErrorService;

// GET: /report - Return a list of reports
$app->get('/api/report', function(Request $paramBag) use ($app) {
    $reportService = new aptostatApi\Service\ReportService();
    $limit = $paramBag->query->get('limit');
    $offset = $paramBag->query->get('offset');

    try {
        $reportList = $reportService->getList($limit, $offset);
        return $app->json($reportList);
    } catch (Exception $e) {
        return $app->json(ErrorService::errorResponse($e), $e->getCode());
    }
});

// GET: /report/{id} - Return a specific report
$app->get('/api/report/{reportId}', function($reportId) use ($app) {
    $reportService = new aptostatApi\Service\ReportService();

    try {
        $report = $reportService->getReportById($reportId);
        return $app->json($report);
    } catch (Exception $e) {
        return $app->json(ErrorService::errorResponse($e), $e->getCode());
    }
});

// PUT: /report/{reportId} - Modify report
$app->put('/api/report/{reportId}', function(Request $paramBag, $reportId) use ($app) {
    $reportService = new aptostatApi\Service\ReportService();

    try {
        $reportService->modify($reportId, $paramBag);
        return $app->json(array('message' => 'The modification was successful'));
    } catch (Exception $e) {
        return $app->json(ErrorService::errorResponse($e), $e->getCode());
    }
});
