<?php



/**
 * This class defines the structure of the 'Incident' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.aptostat_api.map
 */
class IncidentTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'aptostat_api.map.IncidentTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('Incident');
        $this->setPhpName('Incident');
        $this->setClassname('Incident');
        $this->setPackage('aptostat_api');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('IdIncident', 'Idincident', 'INTEGER', true, null, null);
        $this->addColumn('Timestamp', 'Timestamp', 'TIMESTAMP', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Message', 'Message', RelationMap::ONE_TO_MANY, array('IdIncident' => 'IdIncident', ), null, null, 'Messages');
        $this->addRelation('IncidentReport', 'IncidentReport', RelationMap::ONE_TO_MANY, array('IdIncident' => 'IdIncident', ), 'CASCADE', null, 'IncidentReports');
        $this->addRelation('Report', 'Report', RelationMap::MANY_TO_MANY, array(), 'CASCADE', null, 'Reports');
    } // buildRelations()

} // IncidentTableMap
