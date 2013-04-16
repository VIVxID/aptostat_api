<?php



/**
 * Skeleton subclass for representing a row from the 'IncidentReport' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.aptostat_api
 */
class IncidentReport extends BaseIncidentReport
{
    public function setIncidentReportParameters($incidentId, $reportId)
    {
        $this->setIdincident($incidentId);
        $this->setIdreport($reportId);
    }
}
