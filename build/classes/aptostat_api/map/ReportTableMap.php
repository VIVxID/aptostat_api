<?php



/**
 * This class defines the structure of the 'Report' table.
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
class ReportTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'aptostat_api.map.ReportTableMap';

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
        $this->setName('Report');
        $this->setPhpName('Report');
        $this->setClassname('Report');
        $this->setPackage('aptostat_api');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('IdReport', 'Idreport', 'INTEGER', true, null, null);
        $this->addColumn('Timestamp', 'Timestamp', 'TIMESTAMP', true, null, null);
        $this->addColumn('ErrorMessage', 'Errormessage', 'VARCHAR', true, 255, null);
        $this->addColumn('CheckType', 'Checktype', 'VARCHAR', true, 40, null);
        $this->addColumn('Source', 'Source', 'VARCHAR', true, 255, null);
        $this->addForeignKey('IdService', 'Idservice', 'INTEGER', 'Service', 'IdService', true, null, null);
        $this->addColumn('Hidden', 'Hidden', 'BOOLEAN', true, 1, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Service', 'Service', RelationMap::MANY_TO_ONE, array('IdService' => 'IdService', ), null, null);
        $this->addRelation('ReportStatus', 'ReportStatus', RelationMap::ONE_TO_MANY, array('IdReport' => 'IdReport', ), null, null, 'ReportStatuss');
        $this->addRelation('IncidentReport', 'IncidentReport', RelationMap::ONE_TO_MANY, array('IdReport' => 'IdReport', ), 'CASCADE', null, 'IncidentReports');
        $this->addRelation('Incident', 'Incident', RelationMap::MANY_TO_MANY, array(), 'CASCADE', null, 'Incidents');
    } // buildRelations()

} // ReportTableMap
