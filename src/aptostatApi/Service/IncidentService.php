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
        $reports = \IncidentReportQuery::create()
            ->withReportLastStatus()
            ->find();

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
            ->withNonInternalIncidentFields()
            ->findOne();

        if (!$report) {
            $report = \IncidentQuery::create()
                ->filterByIdincident($id)
                ->withAllIncidentFields()
                ->findOne();
        }

        if ($report == null) {
            throw new \Exception(sprintf('No incident found with id %s', $id), 404);
        }

        // Fetch history
        $history = \MessageQuery::create()
            ->filterByIdincident($id)
            ->orderByTimestamp()
            ->find();

        // Fetch reports for listing out which ID's the incident is coupled with
        // and their last status
        $reports = \IncidentReportQuery::create()
            ->withReportLastStatus()
            ->find();

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

        $success = false;

        if ($this->modifyReports($incidentId, $paramBag)) {
            $success = true;
        }

        if ($this->modifyTitle($incidentId, $paramBag)) {
            $success = true;
        }

        if ($success) {
            return array('message' => 'The modification was successful');
        } else {
            throw new \Exception('No modification was done, check your syntax', 400);
        }

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
                'hidden' => (boolean) $incident->getHidden(),
                'connectedReports' => $this->getConnectedReports($incident->getIdIncident(), $reports),
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
            'connectedReports' => $this->getConnectedReports($incident->getIdIncident(), $reports),
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

    private function getConnectedReports($incidentId, $reports)
    {
        $connectedReportsAsArray = array();

        foreach ($reports as $report) {
            if ($incidentId == $report->getIdIncident()) {
                $connectedReportsAsArray[$report->getIdReport()] = $report->getLastReportFlag();
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

    private function extractModifyReportsParam($reports)
    {
        if (!isset($reports)) {
            throw new \Exception('No reports has been included. Consult the documentation', 400);
        }

        if (!$this->reportsExists($reports)) {
            throw new \Exception('Some or all of the included reports do not exist.', 404);
        }

        return $reports;
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

    private function modifyReports($incidentId, $paramBag)
    {
        if (is_null($paramBag->request->get('reportAction'))) {
            return false;
        }

        $reportAction = $paramBag->request->get('reportAction');

        if ($reportAction == 'addReports') {
            $reports = $this->extractModifyReportsParam($paramBag->request->get('reports'));
            $this->addReportsToIncident($incidentId, $reports);
            return true;
        }

        if ($reportAction == 'removeReports') {
            $reports = $this->extractModifyReportsParam($paramBag->request->get('reports'));
            $this->removeReportsFromIncident($incidentId, $reports);
            return true;
        }

        throw new \Exception(sprintf('No valid reportAction has been passed, %s given',$reportAction), 400);
    }

    private function modifyTitle($incidentId, $paramBag)
    {
        if (is_null($paramBag->request->get('title'))) {
            return false;
        }

        $title = $paramBag->request->get('title');

        $incident = \IncidentQuery::create()->findOneByIdincident($incidentId);
        $incident->setTitle($title);
        $incident->save();

        return true;
    }
}