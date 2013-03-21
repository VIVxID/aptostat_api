<?php



/**
 * Skeleton subclass for performing query and update operations on the 'Report' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.aptostat_api
 */
class ReportQuery extends BaseReportQuery
{
    public function notPartOfAnyIncidents()
    {
        return $this
            ->withStandardFields()
            ->withLatestStatusReport()
            ->filterOutWithIncidentReports()
            ->join('Report.ReportStatus');
    }

    /**
     * @param $id
     * @return ReportQuery
     */
    public function withNewestReportStatus($id)
    {
        return $this
            ->filterByIdReport($id)
            ->withStandardFields()
            ->withLatestStatusReport()
            ->join('Report.ReportStatus')
            ->withColumn('ReportStatus.Timestamp', 'FlagTime');
    }

    /**
     * @return ReportQuery
     */
    public function withStandardFields()
    {
        return $this
            ->join('Report.Service')
            ->withColumn('Service.Name', 'ServiceName')
            ->join('Report.Source')
            ->withColumn('Source.Name', 'SourceName')
            ->join('ReportStatus.Flag')
            ->withColumn('Flag.Name', 'FlagName');
    }

    /**
     * @return ReportQuery
     */
    public function withLatestStatusReport()
    {
        return $this->where(
            'ReportStatus.Timestamp IN (SELECT MAX(Timestamp)
            FROM ReportStatus
            WHERE Report.IdReport = ReportStatus.IdReport)'
        );
    }

    /**
     * @return ReportQuery
     */
    public function filterOutWithIncidentReports()
    {
        return $this->where(
            'Report.IdReport NOT IN (select i.IdReport
            FROM IncidentReport as i, Report as r
            WHERE r.IdReport = i.IdReport)'
        );
    }
}
