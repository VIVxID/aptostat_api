<?php



/**
 * Skeleton subclass for performing query and update operations on the 'IncidentReport' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.aptostat_api
 */
class IncidentReportQuery extends BaseIncidentReportQuery
{
    public function withReportLastStatus()
    {
        return $this
            ->joinWith('IncidentReport.Report')
            ->joinWith('Report.ReportStatus')
            ->where('ReportStatus.Timestamp IN (SELECT MAX(Timestamp) FROM ReportStatus WHERE Report.IdReport = ReportStatus.IdReport)')
            ->withColumn('ReportStatus.Flag', 'LastReportFlag');
    }
}
