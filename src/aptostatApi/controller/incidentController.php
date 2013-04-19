<?php

use aptostatApi\Service\ErrorService;

// GET: api/incident - Return a list of incidents
$app->get('/api/incident', function(Request $paramBag) use ($app) {
    $incidentService = new aptostatApi\Service\IncidentService();

    try {
        $incidentList = $incidentService->getList($paramBag);
        return $app->json($incidentList);
    } catch (Exception $e) {
        return $app->json(ErrorService::errorResponse($e), $e->getCode());
    }
});

// GET: api/incident/{incidentId} - Return a specific incident
$app->get('/api/incident/{incidentId}', function($incidentId) use ($app) {
    $incidentService = new aptostatApi\Service\IncidentService();

    try {
        $incident = $incidentService->getIncidentById($incidentId);
        return $app->json($incident);
    } catch (Exception $e) {
        return $app->json(ErrorService::errorResponse($e), $e->getCode());
    }
});

// GET: api/incident/{incidentId}/report - Return a list of all connected reports to this specific incident
$app->get('/api/incident/{incidentId}/report', function($incidentId) use ($app) {
    $reportService = new aptostatApi\Service\ReportService();

    try {
        $reportList = $reportService->getListByIncidentId($incidentId);
        return $app->json($reportList);
    } catch (Exception $e) {
        return $app->json(ErrorService::errorResponse($e), $e->getCode());
    }
});

// POST: api/incident - Create a new incident
$app->post('/api/incident', function(Request $paramBag) use ($app) {
    $incidentService = new aptostatApi\Service\IncidentService();

    try {
        return $app->json($incidentService->create($paramBag));
    } catch (Exception $e) {
        return $app->json(ErrorService::errorResponse($e), $e->getCode());
    }
});

// PUT: api/incident/{incidentId} - Modify incident
$app->put('/api/incident/{incidentId}', function(Request $paramBag, $incidentId) use ($app) {
    $incidentService = new aptostatApi\Service\IncidentService();

    try {
        return $app->json($incidentService->modifyById($incidentId, $paramBag));
    } catch (Exception $e) {
        return $app->json(ErrorService::errorResponse($e), $e->getCode());
    }
});

// POST: api/incident/{incidentId}/message - Create new message
$app->post('api/incident/{incidentId}/message', function(Request $paramBag, $incidentId) use ($app) {
    $messageService = new aptostatApi\Service\MessageService();

    try {
        return $app->json($messageService->addMessage($incidentId, $paramBag));
    } catch (Exception $e) {
        return $app->json(ErrorService::errorResponse($e), $e->getCode());
    }
});

// PUT: api/incident/{incidentId}/message/{messageId} - Modify existing message
$app->put('api/incident/{incidentId}/message/{messageId}', function(Request $paramBag, $messageId) use ($app) {
    $messageService = new aptostatApi\Service\MessageService();

    try {
        return $app->json($messageService->editMessageById($messageId, $paramBag));
    } catch (Exception $e) {
        return $app->json(ErrorService::errorResponse($e), $e->getCode());
    }
});
