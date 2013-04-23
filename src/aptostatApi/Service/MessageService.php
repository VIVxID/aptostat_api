<?php


namespace aptostatApi\Service;

class MessageService
{
    public function getList($paramBag)
    {
        $limit = $paramBag->query->get('limit');
        $offset = $paramBag->query->get('offset');
        $showHidden = $paramBag->query->get('showHidden');

        $list = \MessageQuery::create()
            ->orderByTimestamp('desc')
            ->showHidden($showHidden)
            ->limit($limit)
            ->offset($offset)
            ->find();

        if ($list->isEmpty()) {
            throw new \Exception('We could not find any messages', 404);
        }

        return $this->formatListResult($list);
    }

    public function addMessage($incidentId, $paramBag)
    {
        if (!preg_match('/^\d+$/',$incidentId)) {
            throw new \Exception(sprintf('Id should be a number, %s given', $incidentId), 400);
        }

        $incident = \IncidentQuery::create()->findByIdincident($incidentId);
        if ($incident->isEmpty()) {
            throw new \Exception(sprintf('Incident with id %s does not exist', $incidentId), 404);
        }

        $messageParam = $this->extractParam($paramBag->request->all());
        $this->saveNewMessageToDb($incidentId, $messageParam);
        return array('message' => 'A new message was successfully added');
    }

    public function editMessageById($messageId, $paramBag)
    {
        if (!preg_match('/^\d+$/',$messageId)) {
            throw new \Exception(sprintf('Id should be a number, %s given', $messageId), 400);
        }

        $message = \MessageQuery::create()->findByIdmessage($messageId);
        if ($message->isEmpty()) {
            throw new \Exception(sprintf('Message with id %s does not exist', $messageId), 404);
        }

        $messageParam = $this->extractParam($paramBag->request->all());
        $this->modifyMessageInDb($messageId, $messageParam);
        return array('message' => 'The message was successfully modified');
    }

    /**
     * @param $param
     * @return array
     * @throws \Exception
     */
    private function extractParam($param)
    {
        if (isset($param['author'])) {
            $filteredParamBag['author'] = $param['author'];
        }

        if (isset($param['flag'])) {
            $allowedFlags = \aptostatApi\model\Flag::getFlags();
            if (!in_array(strtoupper($param['flag']), $allowedFlags)) {
                throw new \Exception('Invalid flag has been passed. Check it', 400);
            }
            $filteredParamBag['flag'] = $param['flag'];
        }

        if (isset($param['messageText'])) {
            $filteredParamBag['messageText'] = $param['messageText'];
        }

        if (isset($param['hidden'])) {
            $filteredParamBag['hidden'] = $param['hidden'];
        }

        if (!isset($filteredParamBag)) {
            throw new \Exception('No valid parameters has been passed', 400);
        }

        return $filteredParamBag;
    }

    private function saveNewMessageToDb($incidentId, $messageParam)
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

    private function modifyMessageInDb($messageId, $messageParam)
    {
        $message = \MessageQuery::create()->findOneByIdmessage($messageId);

        if (array_key_exists('author', $messageParam)) {
            $message->setAuthor($messageParam['author']);
        }

        if (array_key_exists('flag', $messageParam)) {
            $message->setFlag($messageParam['flag']);
        }

        if (array_key_exists('messageText', $messageParam)) {
            $message->setText($messageParam['messageText']);
        }

        if (array_key_exists('hidden', $messageParam)) {
            $message->setHidden($messageParam['hidden']);
        }

        $message->save();
    }

    private function formatListResult($list)
    {
        foreach ($list as $message) {
            $formattedList['message'][] = array(
                'id' => $message->getIdMessage(),
                'connectedToIncident' => $message->getIdIncident(),
                'flag' => $message->getFlag(),
                'timestamp' => $message->getTimestamp(),
                'author' => $message->getAuthor(),
                'messageText' => $message->getText(),
                'hidden' => $message->getHidden(),
            );
        }

        return $formattedList;
    }
}