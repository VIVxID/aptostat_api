<?php

namespace aptostatApi\model;

class Report
{
    private $test = "ASSRAPE";
    
    public function getTest()
    {
        return $this->test;
    }
}
/*
// Init propel
Propel::init("/var/www/build/conf/aptostat-conf.php");
set_include_path("/var/www/build/classes" . PATH_SEPARATOR . get_include_path());

//Get reports that are not part of any incidents, along with all relevant information.
    $reportNonInc = ReportQuery::create()
        ->join('Report.Service')
        ->withColumn('Service.Name', 'ServiceName')
        ->join('Report.Source')
        ->withColumn('Source.Name', 'SourceName')
        ->join('Report.ReportStatus')
        ->join('ReportStatus.Flag')
        ->withColumn('Flag.Name', 'FlagName')
        ->where('Report.IdReport NOT IN (select i.IdReport from IncidentReport as i, Report as r where r.IdReport = i.IdReport)')
        ->find();

//Get reports that are part of an incident, along with all relevant information.
    $reportInc = ReportQuery::create()
        ->join('Report.Service')
        ->withColumn('Service.Name', 'ServiceName')
        ->join('Report.Source')
        ->withColumn('Source.Name', 'SourceName')
        ->join('Report.ReportStatus')
        ->join('ReportStatus.Flag')
        ->withColumn('Flag.Name', 'FlagName')
        ->join('Report.IncidentReport')
        ->join('IncidentReport.Incident')
        ->withColumn('Incident.IdIncident', 'IdIncident')
        ->join('Incident.Message')
        ->where('Message.Timestamp IN (SELECT MAX(Timestamp) FROM Message WHERE Incident.IdIncident = Message.IdIncident)')
        ->withColumn('Message.Text', 'MessageText')
        ->withColumn('Message.Timestamp', 'MessageDate')
        ->withColumn('Message.Author', 'Author')
        ->withColumn('Message.IdFlag', 'StatusId')
        ->find();

$out = array();

    if ($reportInc != NULL) { //Check if query is empty.

        //Loop through all reports linked to incidents.
        foreach ($reportInc as $report) {

            //Format data about reports and add it to the output.
            $out['report']['incidents'][$report->getIdIncident()]['reports'][] = array(
                'idReport' => $report->getIdReport(),
                'timestamp' => $report->getTimestamp(),
                'errorMessage' => $report->getErrorMessage(),
                'checkType' => $report->getCheckType(),
                'sourceName' => $report->getSourceName(),
                'serviceName' => $report->getServiceName(),
                'flag' => $report->getFlagName()
            );

            $status = FlagQuery::create()->findOneByIdFlag($report->getStatusId());

            //Format data about messages and add it to the output.
            $out['report']['incidents']['incident' . $report->getIdIncident()]['lastMessage'] = array(
                'messageText' => $report->getMessageText(),
                'messageDate' => $report->getMessageDate(),
                'messageAuthor' => $report->getAuthor(),
                'status' => $status->getName()
            );

        }
    }

    if ($reportNonInc != NULL) { // Check if query is empty.

        //Loop through all reports not linked to incidents.
        foreach ($reportNonInc as $report) {

            //Format data about the reports and add it to the output.
            $out['report']['groups'][$report->getServiceName()][] = array(
                'idReport' => $report->getIdReport(),
                'timestamp' => $report->getTimestamp(),
                'errorMessage' => $report->getErrorMessage(),
                'checkType' => $report->getCheckType(),
                'source' => $report->getSourceName(),
                'flag' => $report->getFlagName(),
            );
        }

        // Set status to OK
        $code = 200;
    } else {
        // No reports was found
        $out = array(
            'error' => array(
                'errorCode' => 404,
                'errorMessage' => 'No reports were found',
            ),
        );
	    $code = 404;
    }
