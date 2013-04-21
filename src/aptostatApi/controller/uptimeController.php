<?php

$app->get('/api/uptime',function () use ($app) {
    $liveService = new aptostatApi\Service\UptimeService();

    try {
        $uptimeData = $liveService->getUptimeData();
        return $app->json($uptimeData, 200);
    } catch (Exception $e) {
        return $app->json(\aptostatApi\Service\ErrorService::errorResponse($e), $e->getCode());
    }
});

