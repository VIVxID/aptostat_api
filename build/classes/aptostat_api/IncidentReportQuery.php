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
    public function partOfAnIncident()
    {
        return $this
            ->join('IncidentReport.Report')
            ->withColumn('Report.Timestamp', 'Timestamp')
            ->withColumn('Report.Checktype', 'CheckType')
            ->withColumn('Report.ErrorMessage', 'ErrorMessage')
            ->join('Report.Service')
            ->withColumn('Service.Name', 'ServiceName')
            ->join('Report.Source')
            ->withColumn('Source.Name', 'SourceName')
            ->join('Report.ReportStatus')
            ->where('ReportStatus.Timestamp IN (SELECT MAX(Timestamp)
                    FROM ReportStatus
                    WHERE Report.IdReport = ReportStatus.IdReport)'
            )
            ->join('ReportStatus.Flag')
            ->withColumn('Flag.Name', 'FlagName')
            ->join('IncidentReport.Incident')
            ->withColumn('Incident.IdIncident', 'IdIncident')
            ->join('Incident.Message')
            ->where('Message.Timestamp IN (SELECT MAX(Timestamp)
                    FROM Message
                    WHERE Incident.IdIncident = Message.IdIncident)'
            )
            ->withColumn('Message.Text', 'MessageText')
            ->withColumn('Message.Timestamp', 'MessageDate')
            ->withColumn('Message.Author', 'Author')
            ->withColumn('Message.IdFlag', 'IdFlag');
    }
}
