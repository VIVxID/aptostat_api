<?php

$app->get('/api/live',function () use ($app) {
        $livefeed = new aptostatApi\model\Live;
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

