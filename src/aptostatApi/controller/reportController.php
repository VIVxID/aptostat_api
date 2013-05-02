<?php

use Symfony\Component\HttpFoundation\Request;
use aptostatApi\Service\ErrorService;

// GET: /report - Return a list of reports
$app->get('/api/report', function(Request $paramBag) use ($app) {
    $reportService = new aptostatApi\Service\ReportService();

    try {
        return $app->json($reportService->getList($paramBag));
    } catch (Exception $e) {
        return $app->json(ErrorService::errorResponse($e), 500);
    }
});

// GET: api/report/{id} - Return a specific report
$app->get('/api/report/{reportId}', function($reportId) use ($app) {
    $reportService = new aptostatApi\Service\ReportService();

    try {
        return $app->json($reportService->getReportById($reportId));
    } catch (Exception $e) {
        return $app->json(ErrorService::errorResponse($e), 500);
    }
});

// PUT: /report/{reportId} - Modify report
$app->put('/api/report/{reportId}', function(Request $paramBag, $reportId) use ($app) {
    $reportService = new aptostatApi\Service\ReportService();

    try {
        return $app->json($reportService->modifyById($reportId, $paramBag));
    } catch (Exception $e) {
        return $app->json(ErrorService::errorResponse($e), 500);
    }
});
