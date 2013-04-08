<?php



/**
 * This class defines the structure of the 'Message' table.
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
class MessageTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'aptostat_api.map.MessageTableMap';

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
        $this->setName('Message');
        $this->setPhpName('Message');
        $this->setClassname('Message');
        $this->setPackage('aptostat_api');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('IdMessage', 'Idmessage', 'INTEGER', true, null, null);
        $this->addForeignKey('IdIncident', 'Idincident', 'INTEGER', 'Incident', 'IdIncident', true, null, null);
        $this->addColumn('Flag', 'Flag', 'VARCHAR', true, 255, null);
        $this->addColumn('Timestamp', 'Timestamp', 'TIMESTAMP', true, null, null);
        $this->addColumn('Text', 'Text', 'VARCHAR', true, 255, null);
        $this->addColumn('Author', 'Author', 'VARCHAR', true, 30, null);
        $this->addColumn('Hidden', 'Hidden', 'BOOLEAN', true, 1, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Incident', 'Incident', RelationMap::MANY_TO_ONE, array('IdIncident' => 'IdIncident', ), null, null);
    } // buildRelations()

} // MessageTableMap
