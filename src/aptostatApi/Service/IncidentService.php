<?php


namespace aptostatApi\Service;

class IncidentService
{
    /**
     * @param $paramBag
     * @return array
     * @throws \Exception
     */
    public function getList($paramBag)
    {
        $limit = $paramBag->query->get('limit');
        $offset = $paramBag->query->get('offset');

        $list = \IncidentQuery::create()
            ->withAllIncidentFields()
            ->limit($limit)
            ->offset($offset)
            ->find();

        if ($list->isEmpty()) {
            throw new \Exception('We could not find any incidents', 404);
        }

        // Fetch reports for listing out which ID's the incident is coupled with
        $reports = \IncidentReportQuery::create()->find();

        return $this->formatListResult($list, $reports);
    }

    /**
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function getIncidentById($id)
    {
        if (!preg_match('/^\d+$/',$id)) {
            throw new \Exception(sprintf('Id should be a number, %s given', $id), 400);
        }

        $report = \IncidentQuery::create()
            ->filterByIdincident($id)
            ->withAllIncidentFields()
            ->findOne();

        if ($report == null) {
            throw new \Exception(sprintf('No incident found with id %s', $id), 404);
        }

        // Fetch history
        $history = \MessageQuery::create()
            ->filterByIdincident($id)
            ->orderByTimestamp()
            ->find();

        // Fetch reports for listing out which ID's the incident is coupled with
        $reports = \IncidentReportQuery::create()->find();

        return $this->formatSingleResult($report, $history, $reports);
    }

    /**
     * @param $paramBag
     * @return array
     * @throws \Exception
     */
    public function create($paramBag)
    {
        $param = $this->extractCreateIncidentParameters($paramBag);

        $connection = \Propel::getConnection(\IncidentPeer::DATABASE_NAME);
        $connection->beginTransaction();

        try {
            $incident = new \Incident();
            $incident->setIncidentParameters($param);
            $incident->save();

            $message = new \Message();
            $message->setMessageParameters($incident->getPrimaryKey(), $param);
            $message->save();

            $this->connectReportsWithIncident($incident->getPrimaryKey(), $param['reports']);

            $connection->commit();
            return $this->getIncidentById($incident->getPrimaryKey());
        } catch (\Exception $e){
            $connection->rollBack();
            throw new \Exception('Could not process your request. Check your syntax', 400);
        }
    }

    /**
     * @param $incidentId
     * @param $paramBag
     * @return array
     * @throws \Exception
     */
    public function modifyById($incidentId, $paramBag)
    {
        if (!preg_match('/^\d+$/',$incidentId)) {
            throw new \Exception(sprintf('Id should be a number, %s given', $incidentId), 400);
        }

        $incident = \IncidentQuery::create()->findByIdincident($incidentId);
        if ($incident->isEmpty()) {
            throw new \Exception(sprintf('Incident with id %s does not exist', $incidentId), 404);
        }

        $param = $paramBag->request->all();

        if (!isset($param['action'])) {
            throw new \Exception('No action has been set. Consult the documentation', 400);
        }

        $action = $param['action'];

        if ($action == 'addReports') {
            $reports = $this->extractModifyReportsParam($param);
            $this->addReportsToIncident($incidentId, $reports);
            return array('message' => 'The reports was successfully added');
        }

        if ($action == 'removeReports') {
            $reports = $this->extractModifyReportsParam($param);
            $this->removeReportsFromIncident($incidentId, $reports);
            return array('message' => 'The reports was successfully removed');
        }

        if ($action == 'addMessage') {
            $messageParam = $this->extractAddMessageParam($param);
            $this->addMessageToIncident($incidentId, $messageParam);
            return array('message' => 'A new message was successfully added');
        }

        throw new \Exception(sprintf('No valid action has been passed, %s given',$param['action']), 400);
    }

    /**
     * @param $list
     * @param $reports
     * @return array
     */
    private function formatListResult($list, $reports)
    {
        $formattedList = array();

        foreach ($list as $incident) {
            $formattedList['incidents'][] = array(
                'id' => $incident->getIdIncident(),
                'title' => $incident->getTitle(),
                'createdTimestamp' => $incident->getTimestamp(),
                'lastMessageId' => $incident->getLatestMessageId(),
                'lastMessageAuthor' => $incident->getLatestMessageAuthor(),
                'lastMessageTimestamp' => $incident->getLatestMessageTimestamp(),
                'lastMessageText' => $incident->getLatestMessageText(),
                'lastStatus' => $incident->getLatestMessageFlag(),
                'currentHidden' => (boolean) $incident->getHidden(),
                'connectedReports' => $this->getConnectedReportsId($incident->getIdIncident(), $reports),
            );
        }

        return $formattedList;
    }

    /**
     * @param $incident
     * @param $history
     * @param $reports
     * @return mixed
     */
    private function formatSingleResult($incident, $history, $reports)
    {
        $singleResultAsArray['incidents'] = array(
            'id' => $incident->getIdIncident(),
            'title' => $incident->getTitle(),
            'createdTimestamp' => $incident->getTimestamp(),
            'lastMessageId' => $incident->getLatestMessageId(),
            'lastMessageAuthor' => $incident->getLatestMessageAuthor(),
            'lastMessageTimestamp' => $incident->getLatestMessageTimestamp(),
            'lastMessageText' => $incident->getLatestMessageText(),
            'lastStatus' => $incident->getLatestMessageFlag(),
            'hidden' => (boolean) $incident->getHidden(),
            'connectedReports' => $this->getConnectedReportsId($incident->getIdIncident(), $reports),
        );

        foreach ($history as $update) {
            $singleResultAsArray['incidents']['messageHistory'][] = array(
                'id' => $update->getIdMessage(),
                'messageAuthor' => $update->getAuthor(),
                'messageTimestamp' => $update->getTimestamp(),
                'messageText' =>$update->getText(),
                'messageStatus' => $update->getFlag(),
                'hidden' =>$update->getHidden(),
            );
        }

        return $singleResultAsArray;
    }

    private function getConnectedReportsId($incidentId, $reports)
    {
        $connectedReportsAsArray = array();

        foreach ($reports as $report) {
            if ($incidentId == $report->getIdIncident()) {
                $connectedReportsAsArray[] = $report->getIdReport();
            }
        }

        return $connectedReportsAsArray;
    }

    private function extractCreateIncidentParameters($paramBag)
    {
        $param['title'] = $paramBag->request->get('title');
        $param['author'] = $paramBag->request->get('author');
        $param['flag'] = $paramBag->request->get('flag');
        $param['text'] = $paramBag->request->get('messageText');
        $param['reports'] = $paramBag->request->get('reports');
        $param['hidden'] = $paramBag->request->get('hidden');

        if ($param['hidden'] == null) {
            $param['hidden'] = false;
        }

        $allowedFlags = \aptostatApi\model\Flag::getFlags();
        if (!in_array(strtoupper($param['flag']), $allowedFlags)) {
            throw new \Exception(sprintf('The value of the flag is not valid, %s given', $param['flag']), 400);
        }

        return $param;
    }

    private function connectReportsWithIncident($incidentId, $reports)
    {
        if (is_array($reports)) {
            foreach ($reports as $report) {
                $incidentReport = new \IncidentReport;
                $incidentReport->setIncidentReportParameters($incidentId, $report);
                $incidentReport->save();
            }
        } else {
            $incidentReport = new \IncidentReport;
            $incidentReport->setIncidentReportParameters($incidentId, $reports);
            $incidentReport->save();
        }
    }

    private function extractModifyReportsParam($param)
    {
        if (!isset($param['reports'])) {
            throw new \Exception('No reports has been included. Consult the documentation', 400);
        }

        if (!$this->reportsExists($param['reports'])) {
            throw new \Exception('Some or all of the included reports do not exist.', 404);
        }

        return $param['reports'];
    }

    /**
     * @param $param
     * @return array
     * @throws \Exception
     */
    private function extractAddMessageParam($param)
    {
        if (!isset($param['author'])) {
            throw new \Exception('No author has been passed', 400);
        }

        if (isset($param['flag'])) {
            $allowedFlags = \aptostatApi\model\Flag::getFlags();
            if (!in_array(strtoupper($param['flag']), $allowedFlags)) {
                throw new \Exception('Invalid flag has been passed. Check it', 400);
            }
        } else {
            throw new \Exception('No flag has been passed', 400);
        }

        if (!isset($param['messageText'])) {
            throw new \Exception('No messageText has been passed', 400);
        }

        if (!isset($param['hidden'])) {
            $param['hidden'] = false;
        }

        return array(
            'author' => $param['author'],
            'flag' => $param['flag'],
            'messageText' => $param['messageText'],
            'hidden' => $param['hidden'],
        );
    }

    /**
     * @param $reports
     * @return bool
     */
    private function reportsExists($reports)
    {
        if (is_array($reports)) {
            foreach ($reports as $report) {
                $reportQuery = \ReportQuery::create()->findByIdreport($report);

                if ($reportQuery->isEmpty()) {
                    return false;
                }
            }
            return true;
        } else {
            $reportQuery = \ReportQuery::create()->findByIdreport($reports);

            if ($reportQuery->isEmpty()) {
                return false;
            }
            return true;
        }
    }

    /**
     * @param $incidentId
     * @param $reports
     * @throws \Exception
     */
    private function addReportsToIncident($incidentId, $reports)
    {
        $connection = \Propel::getConnection(\IncidentReportPeer::DATABASE_NAME);
        $connection->beginTransaction();

        try {
            if (is_array($reports)) {
                foreach ($reports as $report) {
                    $reportIncident = new \IncidentReport();
                    $reportIncident->setIdincident($incidentId);
                    $reportIncident->setIdreport($report);
                    $reportIncident->save();
                }
            } else {
                $reportIncident = new \IncidentReport();
                $reportIncident->setIdincident($incidentId);
                $reportIncident->setIdreport($reports);
                $reportIncident->save();
            }

            $connection->commit();
        } catch (\Exception $e){
            $connection->rollBack();
            throw new \Exception('You tried to add a report that already has been added', 409);
        }
    }

    /**
     * @param $incidentId
     * @param $reports
     * @throws \Exception
     */
    private function removeReportsFromIncident($incidentId, $reports)
    {
        $connection = \Propel::getConnection(\IncidentReportPeer::DATABASE_NAME);
        $connection->beginTransaction();
        try {
            if (is_array($reports)) {
                foreach ($reports as $report) {
                    $reportIncident = \IncidentReportQuery::create()
                        ->filterByIdIncident($incidentId)
                        ->filterByIdreport($report)
                        ->findOne();

                    $reportIncident->delete();
                }
            } else {
                $reportIncident = \IncidentReportQuery::create()
                    ->filterByIdincident($incidentId)
                    ->filterByIdreport($reports)
                    ->findOne();

                $reportIncident->delete();
            }

            $connection->commit();
        } catch (\Exception $e){
            $connection->rollBack();
            throw new \Exception('You tried to remove reports from an incident that does not exist in the incident', 409);
        }
    }

    private function addMessageToIncident($incidentId, $messageParam)
    {
        $message = new \Message();

        $message->setIdincident($incidentId);
        $message->setAuthor($messageParam['author']);
        $message->setFlag($messageParam['flag']);
        $message->setTimestamp(time());
        $message->setText($messageParam['messageText']);
        $message->setHidden($messageParam['hidden']);

        $message->save();
    }
}