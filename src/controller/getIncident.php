<?php

// Init propel
require_once '/var/www/vendor/propel/propel1/runtime/lib/Propel.php';
Propel::init("/var/www/build/conf/aptostat-conf.php");
set_include_path("/var/www/build/classes" . PATH_SEPARATOR . get_include_path());

// Check if an reportId is a number and only a number
if (preg_match('/^\d+$/', $reportId)) {
    $out['reportId'] = $reportId;

    // Check if report has been coupled with an incident
    $q = IncidentReportQuery::create()
        ->filterbyIdReport($reportId)
        ->findOne();
    
    if ($q == NULL) {
        $coupledId = false;
    } else {
        $coupledId = $q->getIdIncident();
    }

    // Initialize and fetch data
    $report = ReportQuery::create()
        ->filterByIdReport($reportId)
        ->join('Report.Groups')
        ->withColumn('Groups.IdGroup', 'IdGroup')
        ->join('Groups.Flag')
        ->withColumn('Flag.Name', 'Flag')
        ->join('Report.Service')
        ->withColumn('Service.Name', 'ServiceName')
        ->join('Report.Source')
        ->withColumn('Source.Name', 'SourceName')
        ->findOne();

    if ($report != NULL) { // Check if query actually returned anything
        // Format the data
        $out = array(
            'report' => array(
                'idReport' => $report->getIdReport(),
                'timestamp' => $report->getTimestamp(),
                'errorMessage' => $report->getErrorMessage(),
                'checkType' => $report->getCheckType(),
                'sourceName' => $report->getSourceName(),
                'serviceName' => $report->getServiceName(),
                'idGroup' => $report->getIdGroup(),
                'flag' => $report->getFlag(),
                'coupledWithIncident' => $coupledId,
            ),
        );

        // Set status to OK
        $code = 200;
    } else {
        // Report was not found on requested id
        $out = array(
            'error' => array(
                'errorCode' => 404,
                'errorMessage' => 'Report with id ' . $reportId . ' was not found',
            ),
        );
	$code = 404;
    }
} else {
    // reportId is not a number, return error
    $out = array(
        'error' => array(
            'errorCode' => 400,
            'errorMessage' => 'Report id requested is not a valid id',
        ),
    );
    $code = 400;
}
