<?php



/**
 * Skeleton subclass for representing a row from the 'Message' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.aptostat_api
 */
class Message extends BaseMessage
{
    /**
     * @param $incidentId
     * @param $param
     */
    public function setMessageParameters($incidentId, $param)
    {
        $this->setIdincident($incidentId);
        $this->setAuthor($param['author']);
        $this->setFlag($param['flag']);
        $this->setText($param['text']);
        $this->setHidden($param['hidden']);
        $this->setTimestamp(time());
    }
}
