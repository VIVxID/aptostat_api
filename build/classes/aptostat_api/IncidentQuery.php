<?php



/**
 * Skeleton subclass for performing query and update operations on the 'Incident' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.aptostat_api
 */
class IncidentQuery extends BaseIncidentQuery
{
    public function withAllIncidentFields()
    {
        return $this
            ->withLatestMessageFields();
    }

    private function withLatestMessageFields()
    {
        return $this
            ->join('Incident.Message')
            ->withColumn('Message.IdMessage', 'LatestMessageId')
            ->withColumn('Message.Author', 'LatestMessageAuthor')
            ->withColumn('Message.Text', 'LatestMessageText')
            ->withColumn('Message.Flag', 'LatestMessageFlag')
            ->where(
                'Message.Timestamp IN (SELECT IFNULL(
                (SELECT MAX(Timestamp)
                FROM Message
                WHERE Incident.IdIncident = Message.IdIncident AND (Message.Flag != "INTERNAL" AND Message.Flag != "IGNORED")),
                (SELECT MAX(Timestamp)
                FROM Message
                WHERE Incident.IdIncident = Message.IdIncident)
                ) FROM Message)');
    }
}
