<?php



/**
 * This class defines the structure of the 'Service' table.
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
class ServiceTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'aptostat_api.map.ServiceTableMap';

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
        $this->setName('Service');
        $this->setPhpName('Service');
        $this->setClassname('Service');
        $this->setPackage('aptostat_api');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('IdService', 'Idservice', 'INTEGER', true, null, null);
        $this->addColumn('Name', 'Name', 'VARCHAR', true, 50, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Report', 'Report', RelationMap::ONE_TO_MANY, array('IdService' => 'IdService', ), null, null, 'Reports');
    } // buildRelations()

} // ServiceTableMap
