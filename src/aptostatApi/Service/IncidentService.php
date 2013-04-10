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

    public function modify($id, $paramBag)
    {

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
                'createdTimestamp' => $incident->getTimestamp(),
                'lastestMessageId' => $incident->getLatestMessageId(),
                'lastestMessageAuthor' => $incident->getLatestMessageAuthor(),
                'lastestMessageTimestamp' => $incident->getLatestMessageTimestamp(),
                'lastestMessageText' => $incident->getLatestMessageText(),
                'lastestStatus' => $incident->getLatestMessageFlag(),
                'hidden' => (boolean) $incident->getHidden(),
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
            'createdTimestamp' => $incident->getTimestamp(),
            'lastestMessageId' => $incident->getLatestMessageId(),
            'lastestMessageAuthor' => $incident->getLatestMessageAuthor(),
            'lastestMessageTimestamp' => $incident->getLatestMessageTimestamp(),
            'lastestMessageText' => $incident->getLatestMessageText(),
            'lastestStatus' => $incident->getLatestMessageFlag(),
            'hidden' => (boolean) $incident->getHidden(),
            'connectedReports' => $this->getConnectedReportsId($incident->getIdIncident(), $reports),
        );

        foreach ($history as $update) {
            $singleResultAsArray['incidents']['statusHistory'][] = array(
                'id' => $update->getIdMessage(),
                'status' => $update->getFlag(),
                'updateTimestamp' => $update->getTimestamp()
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
}