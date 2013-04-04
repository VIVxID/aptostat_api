<?php

// Check if an reportId is a number and only a number
if (preg_match('/^\d+$/', $reportId)) {

    $out = array();

    // Initialize and fetch data
    $report = ReportQuery::create()
        ->filterByIdReport($reportId)
        ->join('Report.ReportStatus')
        ->where('ReportStatus.Timestamp IN (SELECT MAX(Timestamp) FROM ReportStatus WHERE Report.IdReport = ReportStatus.IdReport)')
        ->withColumn('ReportStatus.Timestamp', 'FlagTime')
        ->join('ReportStatus.Flag')
        ->withColumn('Flag.Name', 'FlagName')
        ->join('Report.Service')
        ->withColumn('Service.Name', 'ServiceName')
        ->join('Report.Source')
        ->withColumn('Source.Name', 'SourceName')
        ->findOne();

    $status = ReportStatusQuery::create()
        ->filterByIdReport($reportId)
        ->join('ReportStatus.Flag')
        ->withColumn('Flag.Name', 'FlagName')
        ->find();

    if ($report != NULL) { // Check if query actually returned anything
        // Format the data
        $out['report'] = array(
                'idReport' => $report->getIdReport(),
                'timestamp' => $report->getTimestamp(),
                'errorMessage' => $report->getErrorMessage(),
                'checkType' => $report->getCheckType(),
                'sourceName' => $report->getSourceName(),
                'hostName' => $report->getServiceName(),
                'status' => $report->getFlagName(),
                'lastUpdate' => $report->getFlagTime()
        );

    foreach ($status as $state) {

        $out['report']['updates'][] = array(
                'status' => $state->getFlagName(),
                'timestamp' => $state->getTimestamp()
        );
    }

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

