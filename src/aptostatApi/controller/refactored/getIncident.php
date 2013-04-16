<?php

// Init propel
require_once '/var/www/vendor/propel/propel1/runtime/lib/Propel.php';
Propel::init("/var/www/build/conf/aptostat-conf.php");
set_include_path("/var/www/build/classes" . PATH_SEPARATOR . get_include_path());

// Check if an incidentId is a number and only a number
if (preg_match('/^\d+$/', $incidentId)) {

        // Fetch data
        $incident = IncidentQuery::create()
            ->filterByIdIncident($incidentId)
            ->useMessageQuery()
                ->filterByIdIncident($incidentId)
                ->orderByTimestamp('desc')
                ->limit(1)
            ->endUse()
            ->withColumn('Message.Text', 'LastMessageText')
            ->withColumn('Message.Timestamp', 'LastMessageDate')
            ->join('Message.Flag')
            ->withColumn('Flag.Name', 'LastFlag')
            ->findOne();

        // Fetch the all messages connected this spesific incident
        $messages = MessageQuery::create()
            ->filterByIdIncident($incidentId)
            ->join('Message.Flag')
            ->withColumn('Flag.Name', 'FlagName')
            ->find();

        // Fetch the all reports connected this spesific incident
        $reports = IncidentReportQuery::create()
            ->filterByIdIncident($incidentId)
            ->join('IncidentReport.Report')
            ->withColumn('Report.CheckType', 'CheckType')
            ->withColumn('Report.ErrorMessage', 'ErrorMessage')
            ->withColumn('Report.Timestamp', 'Timestamp')
            ->join('Report.Source')
            ->withColumn('Source.Name', 'SourceName')
            ->join('Report.Service')
            ->withColumn('Service.Name', 'ServiceName')
            ->join('Report.ReportStatus')
            ->where('ReportStatus.Timestamp IN (SELECT MAX(Timestamp) FROM ReportStatus WHERE Report.IdReport = ReportStatus.IdReport)')
            ->join('ReportStatus.Flag')
            ->withColumn('Flag.Name', 'FlagName')
            ->find();

    if ($incident != NULL) { // Check if query actually returned anything
        // Format the data
        $out = array(
            'incident' => array(
                'idIncident' => $incident->getIdIncident(),
                'startDate' => $incident->getTimestamp(),
                'lastMessage' => $incident->getLastMessageText(),
                'lastMessageDate' => $incident->getLastMessageDate(),
                'lastFlag' => $incident->getLastFlag(),
            ),
        );
        
        // Include the reports that is connected to the incident
        foreach ($reports as $report) {
            $out['incident']['connectedReports'][] = array(
                'idReport' => $report->getIdReport(),
                'sourceName' => $report->getSourceName(),
                'serviceName' => $report->getServiceName(),
                'checkType' => $report->getCheckType(),
                'errorMessage' => $report->getErrorMessage(),
                'status' => $report->getFlagName(),
                'timestamp' => $report->getTimestamp()
            );
        }
        
        // Include the messages that is connected to this incident
        foreach ($messages as $message) {
            if ($message->getVisible()) {
                $out['incident']['connectedMessages']['public'][] = array(
                    'idMessage' => $message->getIdMessage(),
                    'messageDate' => $message->getTimestamp(),
                    'author' => $message->getAuthor(),
                    'messageText' => $message->getText(),
                    'status' => $message->getFlagName()
                );
            } else {
                $out['incident']['connectedMessages']['internal'][] = array(
                    'idMessage' => $message->getIdMessage(),
                    'messageDate' => $message->getTimestamp(),
                    'author' => $message->getAuthor(),
                    'messageText' => $message->getText(),
                    'status' => $message->getFlagName()
                );
            }
        }

        // Set status to OK
        $code = 200;
    } else {
        // Incident was not found on requested id
        $out = array(
            'error' => array(
                'errorCode' => 404,
                'errorMessage' => 'Incident with id ' . $incidentId . ' was not found',
            ),
        );
	$code = 404;
    }
} else {
    // incidentId is not a number, return error
    $out = array(
        'error' => array(
            'errorCode' => 400,
            'errorMessage' => 'Incident id requested is not a valid id',
        ),
    );
    $code = 400;
}

