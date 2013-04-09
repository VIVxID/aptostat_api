<?php

namespace aptostatApi\model;

class Incident
{
    private $idIncident;
    private $timestamp;
    private $lastMessage;
    private $lastMessageDate;
    private $lastFlag;
    private $connectedReports = array();
    private $connectedMessages = array();
    
    public function query($id)
    {
        // Check if id is a number
        if (!preg_match('/^\d+$/',$id)) {
            return 400; // Bad request
        }
        
        // Run queries
        // Fetch incident
        $query = \IncidentQuery::create()
            ->filterByIdIncident($id)
            ->useMessageQuery()
                ->filterByIdIncident($id)
                ->orderByTimestamp('desc')
                ->limit(1)
            ->endUse()
            ->withColumn('Message.Author', 'LastMessageAuthor')
            ->withColumn('Message.Text', 'LastMessageText')
            ->withColumn('Message.Timestamp', 'LastMessageDate')
            ->join('Message.Flag')
            ->withColumn('Flag.Name', 'LastFlag')
            ->findOne();

        // Fetch the all reports connected this specific incident
        $queryReports = \IncidentReportQuery::create()
            ->filterByIdIncident($id)
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
            
        // Fetch the all messages connected this spesific incident
        $queryMessages = \MessageQuery::create()
            ->filterByIdIncident($id)
            ->join('Message.Flag')
            ->withColumn('Flag.Name', 'FlagName')
            ->find();
        
        // Check if query returned any results
        if ($query == null) {
            return 404; // Not found
        }
        
        // Store information
        $this->idIncident = $query->getIdIncident();
        $this->timestamp = $query->getTimestamp();
        $this->lastMessageAuthor = $query->getLastMessageAuthor();
        $this->lastMessage = $query->getLastMessageText();
        $this->lastMessageDate = $query->getLastMessageDate();
        $this->lastFlag = $query->getLastFlag();
        
        // Store connected reports if they exist
        if ($queryReports != null) {
            foreach ($queryReports as $report) {
                $this->connectedReports[$report->getServiceName()][] = array(
                    'idReport' => $report->getIdReport(),
                    'sourceName' => $report->getSourceName(),
                    'checkType' => $report->getCheckType(),
                    'errorMessage' => $report->getErrorMessage(),
                    'status' => $report->getFlagName(),
                    'timestamp' => $report->getTimestamp()
                );
            }
        }
        
        // Store connected messages if they exist
        if ($queryMessages != null) {
            foreach ($queryMessages as $message) {
                if ($message->getVisible()) {
                    $this->connectedMessages['public'][] = array(
                        'idMessage' => $message->getIdMessage(),
                        'messageDate' => $message->getTimestamp(),
                        'author' => $message->getAuthor(),
                        'messageText' => $message->getText(),
                        'status' => $message->getFlagName()
                    );
                } else {
                    $this->connectedMessages['internal'][] = array(
                        'idMessage' => $message->getIdMessage(),
                        'messageDate' => $message->getTimestamp(),
                        'author' => $message->getAuthor(),
                        'messageText' => $message->getText(),
                        'status' => $message->getFlagName()
                    );
                }
            }
        }
        
        return 200; // Ok
    }
    
    public function get()
    {
        // Format the information into an array
        $out['incident'] = array(
            'idIncident' => $this->idIncident,
            'timestamp' => $this->timestamp,
            'lastMessage' => $this->lastMessage,
            'lastMessageAuthor' => $this->lastMessageAuthor,
            'lastMessageDate' => $this->lastMessageDate,
            'lastFlag' => $this->lastFlag
            );
        
        // Attach connected reports
        $out['incident']['connectedReports'] = $this->connectedReports;
        
        // Attach connected messages
        $out['incident']['connectedMessages'] = $this->connectedMessages;
        
        return $out;
    }
    
    public function create($author, $text, $flag, $reports, $visibility = null)
    {
        // Validate paramters
        if (
            is_null($author) or strlen($author) > 20 or
            is_null($text) or strlen($text) > 255 or
            is_null($flag) or !preg_match('/^[1-6]{1}$/', $flag) or
            is_null($reports)
            ) {
            return 400; // Bad request
        }
        
        // Create incident
        $incident = new \Incident();
        $incident->setTimestamp(time());
        $incident->save();

        $message = new \Message();
        $message->setTimestamp(time());
        $message->setIdFlag($flag);
        $message->setAuthor($author);
        $message->setText($text);
        $message->setVisible($visibility);
        $message->setIdIncident($incident->getIdIncident());
        $message->save();
        
        $out['incident '.$incident->getIdIncident()]['message'] = array(
            'author' => $author,
            'message' => $text,
            'timestamp' => $incident->getTimestamp(),
            'visible' => $visibility,
            'flag' => $flag
        );
        
        if (is_array($reports)) {
                foreach ($reports as $report) {
                    $link = new \IncidentReport();
                    $link->setIdIncident($incident->getIdIncident());
                    $link->setIdReport($report);
                    $link->save();
                    
                    $out['incident '.$incident->getIdIncident()]['reports'][] = $report;
                }
            } else {
                $link = new \IncidentReport();
                $link->setIdIncident($incident->getIdIncident());
                $link->setIdReport($reports);
                $link->save();

                $out['incident '.$incident->getIdIncident()]['report'][] = $reports;
            }

        return $out;
    }
    
    public function addReport($id, $reports)
    {
        // Check if id is a number
        if (!preg_match('/^\d+$/',$id)) {
            return 400; // Bad request
        }
        
        // Check if the incident exists
        $check = \IncidentQuery::create()->findPK($id);
        if ($check == null) {
            return 404;
        }
        
        // Check if reports has been included
        if (is_null($reports)) {
            return 400; // Bad request
        }
        
        // Check if the reports included actually exists
        if (is_array($reports)) {
            $check = \ReportQuery::create()->findPKs($reports);
            if ($check == null) {
                return 404;
            }
        } else {
            $check = \ReportQuery::create()->findPK($reports);
            if ($check == null) {
                return 404;
            }
        }
        
        // Check if the reports has been added before
        $check = \IncidentReportQuery::create()
            ->filterByIdReport($reports)
            ->findOne();

        if (!is_null($check)) {
            return 409; // Conflict
        }
        
        // Determine if the included report(s) is an array or not
        // and insert the connection into the database
        if (is_array($reports)) {
            foreach ($reports as $report) {
                //Set parameters
                $addReport = new \IncidentReport();
                $addReport->setIdReport($report);
                $addReport->setIdIncident($id);

                //Save to database
                $addReport->save();

                //Return the added reports
                $out[] = $report;
            }
        } else {
            //Set parameters
            $addReport = new \IncidentReport();
            $addReport->setIdReport($reports);
            $addReport->setIdIncident($id);

            //Save to database
            $addReport->save();

            //Return the added report
            $out = $reports;
        }
        return $out;
    }
    
    public function removeReport($id, $reports)
    {
        // Check if id is a number
        if (!preg_match('/^\d+$/',$id)) {
            return 400; // Bad request
        }
        
        // Check if the incident exists
        $check = \IncidentQuery::create()->findPK($id);
        if ($check == null) {
            return 404;
        }
        
        // Check if reports has been included
        if (is_null($reports)) {
            return 400; // Bad request
        }
        
        // Check if the reports included actually exists
        if (is_array($reports)) {
            $check = \IncidentReportQuery::create()->findPKs($reports);
            $check = \IncidentReportQuery::create()
                ->filterByIdReport($reports)
                ->find();
            
            if ($check->count() != count($reports)) {
                return 404;
            }
        } else {
            $check = \IncidentReportQuery::create()
                ->filterByIdReport($reports)
                ->findOne();
                
            if ($check == null) {
                return 404;
            }
        }
        
        // Determine if the included report(s) is an array or not
        // and remove the connection from the database
        if (is_array($reports)) {
            foreach ($reports as $report) {
                // Find the connected report
                $removeReport = \IncidentReportQuery::create()
                    ->filterByIdReport($report);
                
                // Remove the connection
                $removeReport->delete();

                // Return the removed reports
                $out[] = $report;
            }
        } else {
            // Find the connected report
            $removeReport = \IncidentReportQuery::create()
                ->filterByIdReport($reports);
            
            // Remove the connection
            $removeReport->delete();

            //Return the added report
            $out = $reports;
        }
        return $out;
    }    
    
    public function addMessage($id, $author, $text, $flag, $visibility = null)
    {   
        // Check if id is a number
        if (!preg_match('/^\d+$/',$id)) {
            return 400; // Bad request
        }
        
        // Check if the incident exists
        $check = \IncidentQuery::create()->findPK($id);
        if ($check == null) {
            return 404;
        }
        
        // Validate parameters
        if (
            is_null($author) or strlen($author) > 20 or
            is_null($text) or strlen($text) > 255 or
            is_null($flag) or !preg_match('/^[1-6]{1}$/', $flag)
            ) {
            return 400; // Bad request
        }
        
        $addMessage = new \Message();
        $addMessage->setIdIncident($id);
        $addMessage->setText($text);
        $addMessage->setAuthor($author);
        $addMessage->setVisible($visibility);
        $addMessage->setTimestamp(time());
        $addMessage->setIdFlag($flag);

        //Save to database.
        $addMessage->save();

        //Return the added message.
        $out = array(
                    "message" => $text,
                    "author" => $author,
                    "visibility" => $visibility,
                    "flag" => $flag
                    );
                    
        return $out;
    }
}
