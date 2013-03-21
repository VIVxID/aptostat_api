<?php



/**
 * This class defines the structure of the 'IncidentReport' table.
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
class IncidentReportTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'aptostat_api.map.IncidentReportTableMap';

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
        $this->setName('IncidentReport');
        $this->setPhpName('IncidentReport');
        $this->setClassname('IncidentReport');
        $this->setPackage('aptostat_api');
        $this->setUseIdGenerator(false);
        $this->setIsCrossRef(true);
        // columns
        $this->addForeignPrimaryKey('IdIncident', 'Idincident', 'INTEGER' , 'Incident', 'IdIncident', true, null, null);
        $this->addForeignPrimaryKey('IdReport', 'Idreport', 'INTEGER' , 'Report', 'IdReport', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Report', 'Report', RelationMap::MANY_TO_ONE, array('IdReport' => 'IdReport', ), 'CASCADE', null);
        $this->addRelation('Incident', 'Incident', RelationMap::MANY_TO_ONE, array('IdIncident' => 'IdIncident', ), 'CASCADE', null);
    } // buildRelations()

} // IncidentReportTableMap
