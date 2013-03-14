<?php

// Initialize propel
require_once '/Users/Nox/www/vendor/propel/propel1/runtime/lib/Propel.php';
Propel::init('/Users/Nox/www/build/conf/aptostat-conf.php');
set_include_path('/Users/Nox/www/build/classes' . PATH_SEPARATOR . get_include_path());

// GET: report - Return a list of reports
$app->get('/api/report', function() use ($app) {
    $ass = new aptostatApi\model\Report;
    $ar = array('gud' => $ass->getTest());
    return $app->json($ar, 418);
});

// GET: report/{id} - Return a spesific report
$app->get('/api/report/{reportId}', function($reportId) use ($app) {
        $ass = new aptostatApi\model\Report;
        $ar = array('jesuuuuuussssssss' => $ass->getTest(), 'ID' => $reportId);
        return $app->json($ar, 418);
});
