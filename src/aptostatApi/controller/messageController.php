<?php

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