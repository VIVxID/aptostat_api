<?php


namespace aptostatApi\Service;


class ReportService
{
    /**
     * @param $limit
     * @param $offset
     * @return array
     * @throws \Exception
     */
    public function getList($paramBag)
    {
        $limit = $paramBag->query->get('limit');
        $offset = $paramBag->query->get('offset');
        $showHidden = $paramBag->query->get('showHidden');

        $list = \ReportQuery::create()
            ->withAllReportFields()
            ->orderByTimestamp('desc')
            ->showHidden($showHidden)
            ->limit($limit)
            ->offset($offset)
            ->find();

        if ($list->isEmpty()) {
            throw new \Exception('We could not find any reports', 404);
        }

        return $this->formatListResult($list);
    }

    /**
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function getListByIncidentId($id)
    {
        $list = \ReportQuery::create()
            ->filterByReportsThatIsConnectedToAnIncident($id)
            ->withAllReportFields()
            ->orderByTimestamp('desc')
            ->find();

        if ($list->isEmpty()) {
            throw new \Exception(sprintf('We could not find any reports connected to incident with id %s', $id), 404);
        }

        return $this->formatListResult($list);
    }

    /**
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function getReportByIncidentId($id)
    {
        if (!preg_match('/^\d+$/',$id)) {
           throw new \Exception(sprintf('Id should be a number, %s given', $id), 400);
        }

        $report = \ReportQuery::create()
            ->filterByIdreport($id)
            ->withAllReportFields()
            ->findOne();

        if ($report == null) {
            throw new \Exception(sprintf('No report found with id %s', $id), 400);
        }

        // Fetch history
        $history = \ReportStatusQuery::create()
            ->filterByIdReport($id)
            ->orderByTimestamp()
            ->find();

        return $this->formatSingleResult($report, $history);
    }

    /**
     * @param $reportId
     * @param $paramBag
     * @throws \Exception
     */
    public function modify($reportId, $paramBag)
    {
        $param = $paramBag->request->all();

        // Fetch the parameters that are allowed
        foreach ($param as $key => $value) {
            if (method_exists($this,'modify' . $key)) {
                $actions[$key] = $value;
            }
        }

        if (!isset($actions)) {
            throw new \Exception('Could not process your request. Check your syntax', 400);
        }

        foreach ($actions as $action => $value) {
            $methodName = 'modify' . ucfirst($action);
            $this->$methodName($reportId, $value); // $this->modifySomething($value)
        }
    }

    /**
     * @param $list
     * @return array
     */
    private function formatListResult($list)
    {
        $formattedList = array();

        foreach ($list as $report) {
            $formattedList['reports'][] = array(
                'id' => $report->getIdReport(),
                'createdTimestamp' => $report->getTimestamp(),
                'lastUpdatedTimestamp' => $report->getFlagTime(),
                'host' => $report->getServiceName(),
                'errorMessage' => $report->getErrorMessage(),
                'checkType' => $report->getCheckType(),
                'source' => $report->getSource(),
                'flag' => $report->getFlag(),
                'hidden' => $report->getHidden(),
            );
        }

        return $formattedList;
    }

    /**
     * @param $report
     * @param $history
     * @return array
     */
    private function formatSingleResult($report, $history)
    {
        $singleResultAsArray['reports'] = array(
            'id' => $report->getIdReport(),
            'createdTimestamp' => $report->getTimestamp(),
            'lastUpdatedTimestamp' => $report->getFlagTime(),
            'host' => $report->getServiceName(),
            'errorMessage' => $report->getErrorMessage(),
            'checkType' => $report->getCheckType(),
            'source' => $report->getSource(),
            'flag' => $report->getFlag(),
            'hidden' => $report->getHidden(),
        );

        foreach ($history as $update) {
            $singleResultAsArray['reports']['statusHistory'][] = array(
                'status' => $update->getFlag(),
                'updateTimestamp' => $update->getTimestamp()
            );
        }

        return $singleResultAsArray;
    }

    /**
     * @param $id
     * @param $flag
     * @throws \Exception
     */
    private function modifyFlag($id, $flag)
    {
        $allowedFlags = \aptostatApi\model\Flag::getFlags();

        if (!in_array(strtoupper($flag), $allowedFlags)) {
            throw new \Exception(sprintf('The value of the flag is not valid, %s given', $flag), 400);
        }

        $query = new \ReportStatus();

        $query->setIdreport($id);
        $query->setFlag(strtoupper($flag));
        $query->setTimestamp(time());

        $query->save();
    }

    /**
     * @param $id
     * @param $hidden
     */
    private function modifyHidden($id, $hidden)
    {
        $report = \ReportQuery::create()->findOneByIdreport($id);

        $report->setHidden($hidden);

        $report->save();
    }
}
