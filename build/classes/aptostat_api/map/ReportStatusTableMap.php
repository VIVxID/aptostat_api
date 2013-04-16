<?php



/**
 * This class defines the structure of the 'ReportStatus' table.
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
class ReportStatusTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'aptostat_api.map.ReportStatusTableMap';

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
        $this->setName('ReportStatus');
        $this->setPhpName('ReportStatus');
        $this->setClassname('ReportStatus');
        $this->setPackage('aptostat_api');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('IdReport', 'Idreport', 'INTEGER' , 'Report', 'IdReport', true, null, null);
        $this->addPrimaryKey('Timestamp', 'Timestamp', 'TIMESTAMP', true, null, null);
        $this->addColumn('Flag', 'Flag', 'VARCHAR', true, 255, null);
        // validators
        $this->addValidator('Flag', 'validValues', 'propel.validator.ValidValuesValidator', 'WARNING|CRITICAL|INTERNAL|IGNORED|RESPONDING|RESOLVED', 'Invalid flag given, please give a valid flag');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Report', 'Report', RelationMap::MANY_TO_ONE, array('IdReport' => 'IdReport', ), null, null);
    } // buildRelations()

} // ReportStatusTableMap
