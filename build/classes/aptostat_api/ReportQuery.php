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
    /**
     * @return ReportQuery
     */
    public function withAllReportFields()
    {
        return $this
            ->join('Report.Service')
            ->withColumn('Service.Name', 'ServiceName')
            ->withLatestFlag();
    }

    /**
     * @return ReportQuery
     */
    public function withLatestFlag()
    {
        return $this
            ->join('Report.ReportStatus')
            ->withColumn('ReportStatus.Flag', 'Flag')
            ->withColumn('ReportStatus.Timestamp', 'FlagTime')
            ->where(
            'ReportStatus.Timestamp IN (SELECT MAX(Timestamp)
            FROM ReportStatus
            WHERE Report.IdReport = ReportStatus.IdReport)'
        );
    }

    public function filterByReportsThatIsConnectedToAnIncident($id)
    {
        return $this
            ->useIncidentReportQuery()
                ->filterByIdincident($id)
            ->endUse();
    }
}