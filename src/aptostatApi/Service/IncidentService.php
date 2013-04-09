<?php


namespace aptostatApi\Service;


class IncidentService
{
    /**
     * @param $limit
     * @param $offset
     * @return array
     * @throws \Exception
     */
    public function getList($limit, $offset)
    {
        $list = \IncidentQuery::create()
            ->withAllIncidentFields()
            ->limit($limit)
            ->offset($offset)
            ->find();

        if ($list->isEmpty()) {
            throw new \Exception('We could not find any incidents', 404);
        }

        return $this->formatListResult($list);
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
            throw new \Exception(sprintf('No incident found with id %s', $id), 400);
        }

        // Fetch history
        $history = \MessageQuery::create()
            ->filterByIdincident($id)
            ->orderByTimestamp()
            ->find();

        return $this->formatSingleResult($report, $history);
    }

    public function modify($id, $paramBag)
    {

    }

    /**
     * @param $list
     * @return array
     */
    private function formatListResult($list)
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
            );
        }

        return $formattedList;
    }

    /**
     * @param $incident
     * @param $history
     * @return array
     */
    private function formatSingleResult($incident, $history)
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
}