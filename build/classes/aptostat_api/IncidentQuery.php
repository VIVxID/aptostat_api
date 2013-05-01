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

    public function withInternalIncidentFields()
    {
        return $this
            ->withLatestInternalMessageFields();
    }

    private function withLatestMessageFields()
    {
        return $this
            ->join('Incident.Message')
            ->withColumn('Message.IdMessage', 'LatestMessageId')
            ->withColumn('Message.Author', 'LatestMessageAuthor')
            ->withColumn('Message.Timestamp', 'LatestMessageTimestamp')
            ->withColumn('Message.Text', 'LatestMessageText')
            ->withColumn('Message.Flag', 'LatestMessageFlag')
            ->withColumn('Message.Hidden', 'Hidden')
            ->where(
                'Message.Timestamp IN (SELECT MAX(Timestamp)
                FROM Message
                WHERE Incident.IdIncident = Message.IdIncident AND (Message.Flag != "INTERNAL" AND Message.Flag != "IGNORED"))'
            );
    }

    private function withLatestInternalMessageFields()
    {
        return $this
            ->join('Incident.Message')
            ->withColumn('Message.IdMessage', 'LatestMessageId')
            ->withColumn('Message.Author', 'LatestMessageAuthor')
            ->withColumn('Message.Timestamp', 'LatestMessageTimestamp')
            ->withColumn('Message.Text', 'LatestMessageText')
            ->withColumn('Message.Flag', 'LatestMessageFlag')
            ->withColumn('Message.Hidden', 'Hidden')
            ->where(
                'Message.Timestamp IN (SELECT MAX(Timestamp)
                FROM Message
                WHERE Incident.IdIncident = Message.IdIncident)'
            );
    }
}
