<?php


/**
 * Base class that represents a row from the 'Incident' table.
 *
 *
 *
 * @package    propel.generator.aptostat_api.om
 */
abstract class BaseIncident extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'IncidentPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        IncidentPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the idincident field.
     * @var        int
     */
    protected $idincident;

    /**
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the timestamp field.
     * @var        string
     */
    protected $timestamp;

    /**
     * @var        PropelObjectCollection|Message[] Collection to store aggregation of Message objects.
     */
    protected $collMessages;
    protected $collMessagesPartial;

    /**
     * @var        PropelObjectCollection|IncidentReport[] Collection to store aggregation of IncidentReport objects.
     */
    protected $collIncidentReports;
    protected $collIncidentReportsPartial;

    /**
     * @var        PropelObjectCollection|Report[] Collection to store aggregation of Report objects.
     */
    protected $collReports;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $reportsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $messagesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $incidentReportsScheduledForDeletion = null;

    /**
     * Get the [idincident] column value.
     *
     * @return int
     */
    public function getIdincident()
    {
        return $this->idincident;
    }

    /**
     * Get the [title] column value.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [optionally formatted] temporal [timestamp] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getTimestamp($format = 'Y-m-d H:i:s')
    {
        if ($this->timestamp === null) {
            return null;
        }

        if ($this->timestamp === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->timestamp);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->timestamp, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Set the value of [idincident] column.
     *
     * @param int $v new value
     * @return Incident The current object (for fluent API support)
     */
    public function setIdincident($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->idincident !== $v) {
            $this->idincident = $v;
            $this->modifiedColumns[] = IncidentPeer::IDINCIDENT;
        }


        return $this;
    } // setIdincident()

    /**
     * Set the value of [title] column.
     *
     * @param string $v new value
     * @return Incident The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[] = IncidentPeer::TITLE;
        }


        return $this;
    } // setTitle()

    /**
     * Sets the value of [timestamp] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Incident The current object (for fluent API support)
     */
    public function setTimestamp($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->timestamp !== null || $dt !== null) {
            $currentDateAsString = ($this->timestamp !== null && $tmpDt = new DateTime($this->timestamp)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->timestamp = $newDateAsString;
                $this->modifiedColumns[] = IncidentPeer::TIMESTAMP;
            }
        } // if either are not null


        return $this;
    } // setTimestamp()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->idincident = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->title = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->timestamp = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 3; // 3 = IncidentPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Incident object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(IncidentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = IncidentPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collMessages = null;

            $this->collIncidentReports = null;

            $this->collReports = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(IncidentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = IncidentQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(IncidentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                IncidentPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->reportsScheduledForDeletion !== null) {
                if (!$this->reportsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk = $this->getPrimaryKey();
                    foreach ($this->reportsScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($remotePk, $pk);
                    }
                    IncidentReportQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->reportsScheduledForDeletion = null;
                }

                foreach ($this->getReports() as $report) {
                    if ($report->isModified()) {
                        $report->save($con);
                    }
                }
            } elseif ($this->collReports) {
                foreach ($this->collReports as $report) {
                    if ($report->isModified()) {
                        $report->save($con);
                    }
                }
            }

            if ($this->messagesScheduledForDeletion !== null) {
                if (!$this->messagesScheduledForDeletion->isEmpty()) {
                    MessageQuery::create()
                        ->filterByPrimaryKeys($this->messagesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->messagesScheduledForDeletion = null;
                }
            }

            if ($this->collMessages !== null) {
                foreach ($this->collMessages as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->incidentReportsScheduledForDeletion !== null) {
                if (!$this->incidentReportsScheduledForDeletion->isEmpty()) {
                    IncidentReportQuery::create()
                        ->filterByPrimaryKeys($this->incidentReportsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->incidentReportsScheduledForDeletion = null;
                }
            }

            if ($this->collIncidentReports !== null) {
                foreach ($this->collIncidentReports as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = IncidentPeer::IDINCIDENT;
        if (null !== $this->idincident) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . IncidentPeer::IDINCIDENT . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(IncidentPeer::IDINCIDENT)) {
            $modifiedColumns[':p' . $index++]  = '`IdIncident`';
        }
        if ($this->isColumnModified(IncidentPeer::TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`Title`';
        }
        if ($this->isColumnModified(IncidentPeer::TIMESTAMP)) {
            $modifiedColumns[':p' . $index++]  = '`Timestamp`';
        }

        $sql = sprintf(
            'INSERT INTO `Incident` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`IdIncident`':
                        $stmt->bindValue($identifier, $this->idincident, PDO::PARAM_INT);
                        break;
                    case '`Title`':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case '`Timestamp`':
                        $stmt->bindValue($identifier, $this->timestamp, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setIdincident($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggreagated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            if (($retval = IncidentPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collMessages !== null) {
                    foreach ($this->collMessages as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collIncidentReports !== null) {
                    foreach ($this->collIncidentReports as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = IncidentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getIdincident();
                break;
            case 1:
                return $this->getTitle();
                break;
            case 2:
                return $this->getTimestamp();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Incident'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Incident'][$this->getPrimaryKey()] = true;
        $keys = IncidentPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdincident(),
            $keys[1] => $this->getTitle(),
            $keys[2] => $this->getTimestamp(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->collMessages) {
                $result['Messages'] = $this->collMessages->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collIncidentReports) {
                $result['IncidentReports'] = $this->collIncidentReports->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = IncidentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdincident($value);
                break;
            case 1:
                $this->setTitle($value);
                break;
            case 2:
                $this->setTimestamp($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = IncidentPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdincident($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setTitle($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setTimestamp($arr[$keys[2]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(IncidentPeer::DATABASE_NAME);

        if ($this->isColumnModified(IncidentPeer::IDINCIDENT)) $criteria->add(IncidentPeer::IDINCIDENT, $this->idincident);
        if ($this->isColumnModified(IncidentPeer::TITLE)) $criteria->add(IncidentPeer::TITLE, $this->title);
        if ($this->isColumnModified(IncidentPeer::TIMESTAMP)) $criteria->add(IncidentPeer::TIMESTAMP, $this->timestamp);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(IncidentPeer::DATABASE_NAME);
        $criteria->add(IncidentPeer::IDINCIDENT, $this->idincident);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdincident();
    }

    /**
     * Generic method to set the primary key (idincident column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdincident($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdincident();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Incident (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTitle($this->getTitle());
        $copyObj->setTimestamp($this->getTimestamp());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getMessages() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMessage($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getIncidentReports() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addIncidentReport($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdincident(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return Incident Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return IncidentPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new IncidentPeer();
        }

        return self::$peer;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Message' == $relationName) {
            $this->initMessages();
        }
        if ('IncidentReport' == $relationName) {
            $this->initIncidentReports();
        }
    }

    /**
     * Clears out the collMessages collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Incident The current object (for fluent API support)
     * @see        addMessages()
     */
    public function clearMessages()
    {
        $this->collMessages = null; // important to set this to null since that means it is uninitialized
        $this->collMessagesPartial = null;

        return $this;
    }

    /**
     * reset is the collMessages collection loaded partially
     *
     * @return void
     */
    public function resetPartialMessages($v = true)
    {
        $this->collMessagesPartial = $v;
    }

    /**
     * Initializes the collMessages collection.
     *
     * By default this just sets the collMessages collection to an empty array (like clearcollMessages());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMessages($overrideExisting = true)
    {
        if (null !== $this->collMessages && !$overrideExisting) {
            return;
        }
        $this->collMessages = new PropelObjectCollection();
        $this->collMessages->setModel('Message');
    }

    /**
     * Gets an array of Message objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Incident is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Message[] List of Message objects
     * @throws PropelException
     */
    public function getMessages($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collMessagesPartial && !$this->isNew();
        if (null === $this->collMessages || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMessages) {
                // return empty collection
                $this->initMessages();
            } else {
                $collMessages = MessageQuery::create(null, $criteria)
                    ->filterByIncident($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collMessagesPartial && count($collMessages)) {
                      $this->initMessages(false);

                      foreach($collMessages as $obj) {
                        if (false == $this->collMessages->contains($obj)) {
                          $this->collMessages->append($obj);
                        }
                      }

                      $this->collMessagesPartial = true;
                    }

                    $collMessages->getInternalIterator()->rewind();
                    return $collMessages;
                }

                if($partial && $this->collMessages) {
                    foreach($this->collMessages as $obj) {
                        if($obj->isNew()) {
                            $collMessages[] = $obj;
                        }
                    }
                }

                $this->collMessages = $collMessages;
                $this->collMessagesPartial = false;
            }
        }

        return $this->collMessages;
    }

    /**
     * Sets a collection of Message objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $messages A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Incident The current object (for fluent API support)
     */
    public function setMessages(PropelCollection $messages, PropelPDO $con = null)
    {
        $messagesToDelete = $this->getMessages(new Criteria(), $con)->diff($messages);

        $this->messagesScheduledForDeletion = unserialize(serialize($messagesToDelete));

        foreach ($messagesToDelete as $messageRemoved) {
            $messageRemoved->setIncident(null);
        }

        $this->collMessages = null;
        foreach ($messages as $message) {
            $this->addMessage($message);
        }

        $this->collMessages = $messages;
        $this->collMessagesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Message objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Message objects.
     * @throws PropelException
     */
    public function countMessages(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collMessagesPartial && !$this->isNew();
        if (null === $this->collMessages || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMessages) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getMessages());
            }
            $query = MessageQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByIncident($this)
                ->count($con);
        }

        return count($this->collMessages);
    }

    /**
     * Method called to associate a Message object to this object
     * through the Message foreign key attribute.
     *
     * @param    Message $l Message
     * @return Incident The current object (for fluent API support)
     */
    public function addMessage(Message $l)
    {
        if ($this->collMessages === null) {
            $this->initMessages();
            $this->collMessagesPartial = true;
        }
        if (!in_array($l, $this->collMessages->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddMessage($l);
        }

        return $this;
    }

    /**
     * @param	Message $message The message object to add.
     */
    protected function doAddMessage($message)
    {
        $this->collMessages[]= $message;
        $message->setIncident($this);
    }

    /**
     * @param	Message $message The message object to remove.
     * @return Incident The current object (for fluent API support)
     */
    public function removeMessage($message)
    {
        if ($this->getMessages()->contains($message)) {
            $this->collMessages->remove($this->collMessages->search($message));
            if (null === $this->messagesScheduledForDeletion) {
                $this->messagesScheduledForDeletion = clone $this->collMessages;
                $this->messagesScheduledForDeletion->clear();
            }
            $this->messagesScheduledForDeletion[]= clone $message;
            $message->setIncident(null);
        }

        return $this;
    }

    /**
     * Clears out the collIncidentReports collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Incident The current object (for fluent API support)
     * @see        addIncidentReports()
     */
    public function clearIncidentReports()
    {
        $this->collIncidentReports = null; // important to set this to null since that means it is uninitialized
        $this->collIncidentReportsPartial = null;

        return $this;
    }

    /**
     * reset is the collIncidentReports collection loaded partially
     *
     * @return void
     */
    public function resetPartialIncidentReports($v = true)
    {
        $this->collIncidentReportsPartial = $v;
    }

    /**
     * Initializes the collIncidentReports collection.
     *
     * By default this just sets the collIncidentReports collection to an empty array (like clearcollIncidentReports());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initIncidentReports($overrideExisting = true)
    {
        if (null !== $this->collIncidentReports && !$overrideExisting) {
            return;
        }
        $this->collIncidentReports = new PropelObjectCollection();
        $this->collIncidentReports->setModel('IncidentReport');
    }

    /**
     * Gets an array of IncidentReport objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Incident is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|IncidentReport[] List of IncidentReport objects
     * @throws PropelException
     */
    public function getIncidentReports($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collIncidentReportsPartial && !$this->isNew();
        if (null === $this->collIncidentReports || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collIncidentReports) {
                // return empty collection
                $this->initIncidentReports();
            } else {
                $collIncidentReports = IncidentReportQuery::create(null, $criteria)
                    ->filterByIncident($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collIncidentReportsPartial && count($collIncidentReports)) {
                      $this->initIncidentReports(false);

                      foreach($collIncidentReports as $obj) {
                        if (false == $this->collIncidentReports->contains($obj)) {
                          $this->collIncidentReports->append($obj);
                        }
                      }

                      $this->collIncidentReportsPartial = true;
                    }

                    $collIncidentReports->getInternalIterator()->rewind();
                    return $collIncidentReports;
                }

                if($partial && $this->collIncidentReports) {
                    foreach($this->collIncidentReports as $obj) {
                        if($obj->isNew()) {
                            $collIncidentReports[] = $obj;
                        }
                    }
                }

                $this->collIncidentReports = $collIncidentReports;
                $this->collIncidentReportsPartial = false;
            }
        }

        return $this->collIncidentReports;
    }

    /**
     * Sets a collection of IncidentReport objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $incidentReports A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Incident The current object (for fluent API support)
     */
    public function setIncidentReports(PropelCollection $incidentReports, PropelPDO $con = null)
    {
        $incidentReportsToDelete = $this->getIncidentReports(new Criteria(), $con)->diff($incidentReports);

        $this->incidentReportsScheduledForDeletion = unserialize(serialize($incidentReportsToDelete));

        foreach ($incidentReportsToDelete as $incidentReportRemoved) {
            $incidentReportRemoved->setIncident(null);
        }

        $this->collIncidentReports = null;
        foreach ($incidentReports as $incidentReport) {
            $this->addIncidentReport($incidentReport);
        }

        $this->collIncidentReports = $incidentReports;
        $this->collIncidentReportsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related IncidentReport objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related IncidentReport objects.
     * @throws PropelException
     */
    public function countIncidentReports(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collIncidentReportsPartial && !$this->isNew();
        if (null === $this->collIncidentReports || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collIncidentReports) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getIncidentReports());
            }
            $query = IncidentReportQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByIncident($this)
                ->count($con);
        }

        return count($this->collIncidentReports);
    }

    /**
     * Method called to associate a IncidentReport object to this object
     * through the IncidentReport foreign key attribute.
     *
     * @param    IncidentReport $l IncidentReport
     * @return Incident The current object (for fluent API support)
     */
    public function addIncidentReport(IncidentReport $l)
    {
        if ($this->collIncidentReports === null) {
            $this->initIncidentReports();
            $this->collIncidentReportsPartial = true;
        }
        if (!in_array($l, $this->collIncidentReports->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddIncidentReport($l);
        }

        return $this;
    }

    /**
     * @param	IncidentReport $incidentReport The incidentReport object to add.
     */
    protected function doAddIncidentReport($incidentReport)
    {
        $this->collIncidentReports[]= $incidentReport;
        $incidentReport->setIncident($this);
    }

    /**
     * @param	IncidentReport $incidentReport The incidentReport object to remove.
     * @return Incident The current object (for fluent API support)
     */
    public function removeIncidentReport($incidentReport)
    {
        if ($this->getIncidentReports()->contains($incidentReport)) {
            $this->collIncidentReports->remove($this->collIncidentReports->search($incidentReport));
            if (null === $this->incidentReportsScheduledForDeletion) {
                $this->incidentReportsScheduledForDeletion = clone $this->collIncidentReports;
                $this->incidentReportsScheduledForDeletion->clear();
            }
            $this->incidentReportsScheduledForDeletion[]= clone $incidentReport;
            $incidentReport->setIncident(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Incident is new, it will return
     * an empty collection; or if this Incident has previously
     * been saved, it will retrieve related IncidentReports from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Incident.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|IncidentReport[] List of IncidentReport objects
     */
    public function getIncidentReportsJoinReport($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = IncidentReportQuery::create(null, $criteria);
        $query->joinWith('Report', $join_behavior);

        return $this->getIncidentReports($query, $con);
    }

    /**
     * Clears out the collReports collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Incident The current object (for fluent API support)
     * @see        addReports()
     */
    public function clearReports()
    {
        $this->collReports = null; // important to set this to null since that means it is uninitialized
        $this->collReportsPartial = null;

        return $this;
    }

    /**
     * Initializes the collReports collection.
     *
     * By default this just sets the collReports collection to an empty collection (like clearReports());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initReports()
    {
        $this->collReports = new PropelObjectCollection();
        $this->collReports->setModel('Report');
    }

    /**
     * Gets a collection of Report objects related by a many-to-many relationship
     * to the current object by way of the IncidentReport cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Incident is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param PropelPDO $con Optional connection object
     *
     * @return PropelObjectCollection|Report[] List of Report objects
     */
    public function getReports($criteria = null, PropelPDO $con = null)
    {
        if (null === $this->collReports || null !== $criteria) {
            if ($this->isNew() && null === $this->collReports) {
                // return empty collection
                $this->initReports();
            } else {
                $collReports = ReportQuery::create(null, $criteria)
                    ->filterByIncident($this)
                    ->find($con);
                if (null !== $criteria) {
                    return $collReports;
                }
                $this->collReports = $collReports;
            }
        }

        return $this->collReports;
    }

    /**
     * Sets a collection of Report objects related by a many-to-many relationship
     * to the current object by way of the IncidentReport cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $reports A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Incident The current object (for fluent API support)
     */
    public function setReports(PropelCollection $reports, PropelPDO $con = null)
    {
        $this->clearReports();
        $currentReports = $this->getReports();

        $this->reportsScheduledForDeletion = $currentReports->diff($reports);

        foreach ($reports as $report) {
            if (!$currentReports->contains($report)) {
                $this->doAddReport($report);
            }
        }

        $this->collReports = $reports;

        return $this;
    }

    /**
     * Gets the number of Report objects related by a many-to-many relationship
     * to the current object by way of the IncidentReport cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param boolean $distinct Set to true to force count distinct
     * @param PropelPDO $con Optional connection object
     *
     * @return int the number of related Report objects
     */
    public function countReports($criteria = null, $distinct = false, PropelPDO $con = null)
    {
        if (null === $this->collReports || null !== $criteria) {
            if ($this->isNew() && null === $this->collReports) {
                return 0;
            } else {
                $query = ReportQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByIncident($this)
                    ->count($con);
            }
        } else {
            return count($this->collReports);
        }
    }

    /**
     * Associate a Report object to this object
     * through the IncidentReport cross reference table.
     *
     * @param  Report $report The IncidentReport object to relate
     * @return Incident The current object (for fluent API support)
     */
    public function addReport(Report $report)
    {
        if ($this->collReports === null) {
            $this->initReports();
        }
        if (!$this->collReports->contains($report)) { // only add it if the **same** object is not already associated
            $this->doAddReport($report);

            $this->collReports[]= $report;
        }

        return $this;
    }

    /**
     * @param	Report $report The report object to add.
     */
    protected function doAddReport($report)
    {
        $incidentReport = new IncidentReport();
        $incidentReport->setReport($report);
        $this->addIncidentReport($incidentReport);
    }

    /**
     * Remove a Report object to this object
     * through the IncidentReport cross reference table.
     *
     * @param Report $report The IncidentReport object to relate
     * @return Incident The current object (for fluent API support)
     */
    public function removeReport(Report $report)
    {
        if ($this->getReports()->contains($report)) {
            $this->collReports->remove($this->collReports->search($report));
            if (null === $this->reportsScheduledForDeletion) {
                $this->reportsScheduledForDeletion = clone $this->collReports;
                $this->reportsScheduledForDeletion->clear();
            }
            $this->reportsScheduledForDeletion[]= $report;
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->idincident = null;
        $this->title = null;
        $this->timestamp = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volumne/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collMessages) {
                foreach ($this->collMessages as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collIncidentReports) {
                foreach ($this->collIncidentReports as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collReports) {
                foreach ($this->collReports as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collMessages instanceof PropelCollection) {
            $this->collMessages->clearIterator();
        }
        $this->collMessages = null;
        if ($this->collIncidentReports instanceof PropelCollection) {
            $this->collIncidentReports->clearIterator();
        }
        $this->collIncidentReports = null;
        if ($this->collReports instanceof PropelCollection) {
            $this->collReports->clearIterator();
        }
        $this->collReports = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(IncidentPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

}
