<?php


namespace aptostatApi\Service;


class ReportService
{
    public function getReportById($id)
    {
        // Check if id is a number
        if (!preg_match('/^\d+$/',$id)) {
            throw new \InvalidArgumentException(sprintf('Id should be a number, %s given', $id), 400);
        }

        // Run queries
        /** @var $report \Report */
        $report = \ReportQuery::create()
            ->withNewestReportStatus($id)
            ->findOne();

        $statusQuery = \ReportStatusQuery::create()
            ->filterByIdReport($id)
            ->join('ReportStatus.Flag')
            ->withColumn('Flag.Name', 'FlagName')
            ->find();

        // Check if query return any results
        if ($report == null) {
            throw new Exception\NotFoundException('No report found with id ' . $id);
        }

        $reportAsArray = $report->toPrettyArray();

        // Store status updates history
        foreach ($statusQuery as $state) {
            $reportAsArray['updates'][] = array(
                'status' => $state->getFlagName(),
                'timestamp' => $state->getTimestamp()
            );
        }

        return $reportAsArray;
    }

    public function getList()
    {
        $queryNonInc = \ReportQuery::create()
            ->notPartOfAnyIncidents()
            ->find();

        $queryInc = \IncidentReportQuery::create()
            ->partOfAnIncident()
            ->find();

        return $this->formatResult($queryInc, $queryNonInc);
    }

    private function formatResult($queryInc, $queryNonInc)
    {
        if ($queryNonInc == null && $queryInc == null) {
            return array();
        }

        $out = array();

        // Format the result - Reports connected to an incident
        /** @var $report \Report */
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
                'status' => $report->getFlagName()
            );
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

        return $out;
    }
}
