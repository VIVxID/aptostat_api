<?php



/**
 * Skeleton subclass for representing a row from the 'Report' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.aptostat_api
 */
class Report extends BaseReport
{
    public function toPrettyArray()
    {
        return array(
            'idReport' => $this->getIdreport(),
            'timestamp' => $this->getTimestamp(),
            'errorMessage' => $this->getErrormessage(),
            'checkType' => $this->getChecktype(),
            'sourceName' => $this->getSourceName(),
            'hostName' => $this->getServiceName(),
            'status' => $this->getFlagName(),
            'lastUpdate' => $this->getFlagTime()
        );
    }
}
