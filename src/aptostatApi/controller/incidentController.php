<?php

$app->get('/api/incident', function() use ($app) {
        include '../src/controller/listIncident.php';
        return $app->json($out, $code);
});

$app->get('/api/incident/{incidentId}', function($incidentId) use ($app) {
        include '../src/controller/getIncident.php';
        return $app->json($out, $code);
});

$app->post('/api/incident', function(Request $request) use ($app) {
        include '../src/controller/postIncident.php';
        return $app->json($out, $code);
});

$app->put('/api/incident/{incidentId}', function(Request $request, $incidentId) use ($app) {
        include '../src/controller/putIncident.php';
        return $app->json($out, $code);
});