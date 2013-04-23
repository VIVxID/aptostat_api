<?php

use Symfony\Component\HttpFoundation\Request;
use aptostatApi\Service\ErrorService;

// GET: /message - Return a list of reports
$app->get('/api/message', function(Request $paramBag) use ($app) {
    $messageService = new aptostatApi\Service\MessageService();

    try {
        return $app->json($messageService->getList($paramBag));
    } catch (Exception $e) {
        return $app->json(ErrorService::errorResponse($e), $e->getCode());
    }
});

// PUT: api/incident/message/{messageId} - Modify existing message
$app->put('api/incident/message/{messageId}', function(Request $paramBag, $messageId) use ($app) {
    $messageService = new aptostatApi\Service\MessageService();

    try {
        return $app->json($messageService->editMessageById($messageId, $paramBag));
    } catch (Exception $e) {
        return $app->json(ErrorService::errorResponse($e), $e->getCode());
    }
});