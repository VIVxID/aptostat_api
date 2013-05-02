<?php

use Symfony\Component\HttpFoundation\Request;
use aptostatApi\Service\ErrorService;

$app->get('/api/killswitch',function () use ($app) {
    try {
        $killswitchService = new aptostatApi\Service\KillswitchService();

        return $app->json($killswitchService->getSwitchStatus(), 200);
    } catch (Exception $e) {
        $app['monolog']->addCritical('System could not be shut down. Have you remembered to set the right permissions for the lock-file?');
        return $app->json(\aptostatApi\Service\ErrorService::errorResponse($e), 500);
    }
});

$app->put('/api/killswitch',function (Request $paramBag) use ($app) {
    try {
        $killswitchService = new aptostatApi\Service\KillswitchService();
        $switchAction = $paramBag->request->get('action');

        if ($switchAction == 'on') {
            return $app->json($killswitchService->killSystem(), 200);
        }

        if ($switchAction == 'off') {
            return $app->json($killswitchService->reviveSystem(), 200);
        }

        return $app->json('No valid parameters was passed', 400);
    } catch (Exception $e) {
        $app['monolog']->addCritical('System could not be shut down. Have you remembered to set the right permissions for the lock-file?');
        return $app->json(\aptostatApi\Service\ErrorService::errorResponse($e), 500);
    }
});
