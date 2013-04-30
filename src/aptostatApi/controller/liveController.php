<?php

$app->get('/api/live',function () use ($app) {
    $liveService = new aptostatApi\Service\LiveService();

    try {
        $realTimeData = $liveService->getRealTimeData();
        return $app->json($realTimeData, 200);
    } catch (Exception $e) {
        return $app->json(\aptostatApi\Service\ErrorService::errorResponse($e), $e->getCode());
    }
});

