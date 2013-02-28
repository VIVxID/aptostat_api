<?php

// Bootstrap
require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application;

// Set debug
$app['debug'] = true;

// Add controllers
$app->get('/', function() use ($app) {
        return 'Indexer!';
});

$app->get('/report', function() use ($app) {
	// TODO: require noe som kjører kode for getReportList eller noe sånt.
	// Req en Action som benytter seg av Report klasse. Use Request og respond
        return '';
});

$app->get('/report/{reportId}', function($reportId) use ($app) {
        return 'Report ' . $reportId;
});

$app->get('/incident', function() use ($app) {
        return 'IncidentList';
});

$app->get('/incident/{incidentId}', function($incidentId) use ($app) {
             return 'Incident ' . $incidentId;
});

// Run the app
$app->run();
