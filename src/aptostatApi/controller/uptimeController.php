<?php

$app->get('/api/uptime',function () use ($app) {
        $livefeed = new aptostatApi\model\Uptime;
        $status = $livefeed->query();

        switch ($status) {
            case '200':
                return $app->json($livefeed->get(), 200);
                break;
            default:
                return $app->json(array(
                   'errorCode' => 500,
                   'errorDesc' => 'Internal server error'
                   ), 500);
            break;
        }
});

