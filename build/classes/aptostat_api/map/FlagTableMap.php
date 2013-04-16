<?php



/**
 * This class defines the structure of the 'Flag' table.
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
class FlagTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'aptostat_api.map.FlagTableMap';

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
        $this->setName('Flag');
        $this->setPhpName('Flag');
        $this->setClassname('Flag');
        $this->setPackage('aptostat_api');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('IdFlag', 'Idflag', 'VARCHAR', true, 20, null);
        $this->addColumn('Name', 'Name', 'VARCHAR', true, 20, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Message', 'Message', RelationMap::ONE_TO_MANY, array('IdFlag' => 'IdFlag', ), null, null, 'Messages');
        $this->addRelation('ReportStatus', 'ReportStatus', RelationMap::ONE_TO_MANY, array('IdFlag' => 'IdFlag', ), null, null, 'ReportStatuss');
    } // buildRelations()

} // FlagTableMap
