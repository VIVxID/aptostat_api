<?php

namespace aptostatApi\model;

class Report
{
    private $idReport;
    private $timestamp;
    private $errorMessage;
    private $checkType;
    private $source;
    private $service;
    private $hostname;
    private $status;
    private $lastUpdate;
    private $updates = array();
    private $reportList = array();
    
    public function query($id)
    {
        // Check if id is a number
        if (!preg_match('/^\d+$/',$id)) {
            return 400; // Bad request
        }
        
        // Run queries
        $query = \ReportQuery::create()
            ->filterByIdReport($id)
            ->join('Report.ReportStatus')
            ->where(
                    'ReportStatus.Timestamp IN (SELECT MAX(Timestamp)
                    FROM ReportStatus
                    WHERE Report.IdReport = ReportStatus.IdReport)'
                    )
            ->withColumn('ReportStatus.Timestamp', 'FlagTime')
            ->join('ReportStatus.Flag')
            ->withColumn('Flag.Name', 'FlagName')
            ->join('Report.Service')
            ->withColumn('Service.Name', 'ServiceName')
            ->join('Report.Source')
            ->withColumn('Source.Name', 'SourceName')
            ->findOne();

        $statusQuery = \ReportStatusQuery::create()
            ->filterByIdReport($id)
            ->join('ReportStatus.Flag')
            ->withColumn('Flag.Name', 'FlagName')
            ->find();

        // Check if query return any results
        if ($query == null) {
            return 404; // Not found
        }

        // Store report information
        $this->idReport = $query->getIdReport();
        $this->timestamp = $query->getTimestamp();
        $this->errorMessage = $query->getErrorMessage();
        $this->checkType = $query->getCheckType();
        $this->source = $query->getSourceName();
        $this->service = $query->getServiceName();
        $this->status = $query->getFlagName();
        $this->lastUpdate = $query->getFlagTime();

        // Store status updates history
        foreach ($statusQuery as $state) {
            $this->updates[] = array(
                'status' => $state->getFlagName(),
                'timestamp' => $state->getTimestamp()
            );
        }

        return 200; // Ok
    }

    public function get()
    {
        // Format the information into an array
        $out['report'] = array(
            'idReport' => $this->idReport,
            'timestamp' => $this->timestamp,
            'errorMessage' => $this->errorMessage,
            'checkType' => $this->checkType,
            'sourceName' => $this->source,
            'hostName' => $this->service,
            'status' => $this->status,
            'lastUpdate' => $this->lastUpdate
            );
        
        // Attach status updates history
        $out['report']['updates'] = $this->updates;
        
        return $out;
    }

    public function queryList()
    {
        // Run queries
        // Get reports that are not part of any incidents
        $queryNonInc = \ReportQuery::create()
            ->join('Report.Service')
            ->withColumn('Service.Name', 'ServiceName')
            ->join('Report.Source')
            ->withColumn('Source.Name', 'SourceName')
            ->join('Report.ReportStatus')
            ->where(
                'ReportStatus.Timestamp IN (SELECT MAX(Timestamp)
                FROM ReportStatus
                WHERE Report.IdReport = ReportStatus.IdReport)'
                )
            ->join('ReportStatus.Flag')
            ->withColumn('Flag.Name', 'FlagName')
            ->where(
                    'Report.IdReport NOT IN (select i.IdReport
                        FROM IncidentReport as i, Report as r
                        WHERE r.IdReport = i.IdReport)'
                        )
            ->find();

        // Get reports that are part of an incident, along with all relevant information.
        $queryInc = \IncidentReportQuery::create()
            ->join('IncidentReport.Report')
            ->withColumn('Report.Timestamp', 'Timestamp')
            ->withColumn('Report.Checktype', 'CheckType')
            ->withColumn('Report.ErrorMessage', 'ErrorMessage')
            ->join('Report.Service')
            ->withColumn('Service.Name', 'ServiceName')
            ->join('Report.Source')
            ->withColumn('Source.Name', 'SourceName')
            ->join('Report.ReportStatus')
            ->where('ReportStatus.Timestamp IN (SELECT MAX(Timestamp)
                    FROM ReportStatus
                    WHERE Report.IdReport = ReportStatus.IdReport)'
                    )
            ->join('ReportStatus.Flag')
            ->withColumn('Flag.Name', 'FlagName')
            ->join('IncidentReport.Incident')
            ->withColumn('Incident.IdIncident', 'IdIncident')
            ->withColumn('Incident.Title', 'IncidentTitle')
            ->withColumn('Incident.Timestamp', 'IncidentTimestamp')
            ->join('Incident.Message')
            ->where('Message.Timestamp IN (SELECT MAX(Timestamp)
                    FROM Message
                    WHERE Incident.IdIncident = Message.IdIncident)'
                    )
            ->withColumn('Message.Text', 'MessageText')
            ->withColumn('Message.Timestamp', 'MessageDate')
            ->withColumn('Message.Author', 'Author')
            ->withColumn('Message.IdFlag', 'IdFlag')
            ->find();

        // Check if queries returned any results
        if ($queryNonInc == null and $queryInc == null) {
            return 404; // Not found
        }

        // Get list of flag types and format the list
        $queryFlag = \FlagQuery::create()
            ->find();

        foreach ($queryFlag as $flag) {
            $flags[$flag->getIdFlag()] = $flag->getName();
        }

        // Format the result - Reports connected to an incident
        foreach ($queryInc as $report) {
            $out['report']['incidents'][$report->getIdIncident()]['reports'][] = array(
                'idReport' => $report->getIdReport(),
                'timestamp' => $report->getTimestamp(),
                'errorMessage' => $report->getErrorMessage(),
                'checkType' => $report->getCheckType(),
                'sourceName' => $report->getSourceName(),
                'serviceName' => $report->getServiceName(),
                'flag' => $report->getFlagName()
                );

        //Format data about messages and add it to the output.
            $out['report']['incidents'][$report->getIdIncident()]['lastMessage'] = array(
                'messageText' => $report->getMessageText(),
                'messageDate' => $report->getMessageDate(),
                'messageAuthor' => $report->getAuthor(),
                'status' => $flags[$report->getIdFlag()]
            );

        //Include title and timestamp of the incident
            $out['report']['incidents'][$report->getIdIncident()]['incidentTitle'] = $report->getIncidentTitle();
            $out['report']['incidents'][$report->getIdIncident()]['incidentTimestamp'] = $report->getIncidentTimestamp();
        }

        // Format the result - Reports not connected to an incident
        if ($queryNonInc != null) {
            foreach ($queryNonInc as $report) {
                $out['report']['groups'][$report->getServiceName()][] = array(
                    'idReport' => $report->getIdReport(),
                    'timestamp' => $report->getTimestamp(),
                    'errorMessage' => $report->getErrorMessage(),
                    'checkType' => $report->getCheckType(),
                    'source' => $report->getSourceName(),
                    'flag' => $report->getFlagName(),
                );
            }
        }
        
        // Store the result
        $this->reportList = $out;
        
        return 200; // Ok
    }

    public function getList()
    {
        return $this->reportList;
    }
    
    public function modifyFlag($id, $flagId)
    {
        // Check if ids are numbers
        if (!preg_match('/^\d+$/',$id) or !preg_match('/^\d+$/',$flagId)) {
            return 400; // Bad request
        }
        
        // Check if report exists
        $check = \ReportQuery::create()->findPK($id);
        if ($check == null) {
            return 404;
        }
        
        // Prepare statement
        $query = new \ReportStatus();
        $query->setIdReport($id);
        $query->setTimestamp(time());
        $query->setIdFlag($flagId);
        
        // Execute statement
        $query->save();
        
        return 200; // Ok
    }
}
