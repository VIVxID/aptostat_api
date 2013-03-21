<?php


/**
 * Base class that represents a row from the 'Report' table.
 *
 *
 *
 * @package    propel.generator.aptostat_api.om
 */
abstract class BaseReport extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'ReportPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ReportPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the idreport field.
     * @var        int
     */
    protected $idreport;

    /**
     * The value for the timestamp field.
     * @var        string
     */
    protected $timestamp;

    /**
     * The value for the errormessage field.
     * @var        string
     */
    protected $errormessage;

    /**
     * The value for the checktype field.
     * @var        string
     */
    protected $checktype;

    /**
     * The value for the idsource field.
     * @var        int
     */
    protected $idsource;

    /**
     * The value for the idservice field.
     * @var        int
     */
    protected $idservice;

    /**
     * @var        Source
     */
    protected $aSource;

    /**
     * @var        Service
     */
    protected $aService;

    /**
     * @var        PropelObjectCollection|ReportStatus[] Collection to store aggregation of ReportStatus objects.
     */
    protected $collReportStatuss;
    protected $collReportStatussPartial;

    /**
     * @var        PropelObjectCollection|IncidentReport[] Collection to store aggregation of IncidentReport objects.
     */
    protected $collIncidentReports;
    protected $collIncidentReportsPartial;

    /**
     * @var        PropelObjectCollection|Incident[] Collection to store aggregation of Incident objects.
     */
    protected $collIncidents;

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
    protected $incidentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $reportStatussScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $incidentReportsScheduledForDeletion = null;

    /**
     * Get the [idreport] column value.
     *
     * @return int
     */
    public function getIdreport()
    {
        return $this->idreport;
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
     * Get the [errormessage] column value.
     *
     * @return string
     */
    public function getErrormessage()
    {
        return $this->errormessage;
    }

    /**
     * Get the [checktype] column value.
     *
     * @return string
     */
    public function getChecktype()
    {
        return $this->checktype;
    }

    /**
     * Get the [idsource] column value.
     *
     * @return int
     */
    public function getIdsource()
    {
        return $this->idsource;
    }

    /**
     * Get the [idservice] column value.
     *
     * @return int
     */
    public function getIdservice()
    {
        return $this->idservice;
    }

    /**
     * Set the value of [idreport] column.
     *
     * @param int $v new value
     * @return Report The current object (for fluent API support)
     */
    public function setIdreport($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->idreport !== $v) {
            $this->idreport = $v;
            $this->modifiedColumns[] = ReportPeer::IDREPORT;
        }


        return $this;
    } // setIdreport()

    /**
     * Sets the value of [timestamp] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Report The current object (for fluent API support)
     */
    public function setTimestamp($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->timestamp !== null || $dt !== null) {
            $currentDateAsString = ($this->timestamp !== null && $tmpDt = new DateTime($this->timestamp)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->timestamp = $newDateAsString;
                $this->modifiedColumns[] = ReportPeer::TIMESTAMP;
            }
        } // if either are not null


        return $this;
    } // setTimestamp()

    /**
     * Set the value of [errormessage] column.
     *
     * @param string $v new value
     * @return Report The current object (for fluent API support)
     */
    public function setErrormessage($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->errormessage !== $v) {
            $this->errormessage = $v;
            $this->modifiedColumns[] = ReportPeer::ERRORMESSAGE;
        }


        return $this;
    } // setErrormessage()

    /**
     * Set the value of [checktype] column.
     *
     * @param string $v new value
     * @return Report The current object (for fluent API support)
     */
    public function setChecktype($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->checktype !== $v) {
            $this->checktype = $v;
            $this->modifiedColumns[] = ReportPeer::CHECKTYPE;
        }


        return $this;
    } // setChecktype()

    /**
     * Set the value of [idsource] column.
     *
     * @param int $v new value
     * @return Report The current object (for fluent API support)
     */
    public function setIdsource($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->idsource !== $v) {
            $this->idsource = $v;
            $this->modifiedColumns[] = ReportPeer::IDSOURCE;
        }

        if ($this->aSource !== null && $this->aSource->getIdsource() !== $v) {
            $this->aSource = null;
        }


        return $this;
    } // setIdsource()

    /**
     * Set the value of [idservice] column.
     *
     * @param int $v new value
     * @return Report The current object (for fluent API support)
     */
    public function setIdservice($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->idservice !== $v) {
            $this->idservice = $v;
            $this->modifiedColumns[] = ReportPeer::IDSERVICE;
        }

        if ($this->aService !== null && $this->aService->getIdservice() !== $v) {
            $this->aService = null;
        }


        return $this;
    } // setIdservice()

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

            $this->idreport = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->timestamp = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->errormessage = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->checktype = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->idsource = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->idservice = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 6; // 6 = ReportPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Report object", $e);
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

        if ($this->aSource !== null && $this->idsource !== $this->aSource->getIdsource()) {
            $this->aSource = null;
        }
        if ($this->aService !== null && $this->idservice !== $this->aService->getIdservice()) {
            $this->aService = null;
        }
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
            $con = Propel::getConnection(ReportPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ReportPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aSource = null;
            $this->aService = null;
            $this->collReportStatuss = null;

            $this->collIncidentReports = null;

            $this->collIncidents = null;
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
            $con = Propel::getConnection(ReportPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ReportQuery::create()
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
            $con = Propel::getConnection(ReportPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                ReportPeer::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aSource !== null) {
                if ($this->aSource->isModified() || $this->aSource->isNew()) {
                    $affectedRows += $this->aSource->save($con);
                }
                $this->setSource($this->aSource);
            }

            if ($this->aService !== null) {
                if ($this->aService->isModified() || $this->aService->isNew()) {
                    $affectedRows += $this->aService->save($con);
                }
                $this->setService($this->aService);
            }

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

            if ($this->incidentsScheduledForDeletion !== null) {
                if (!$this->incidentsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk = $this->getPrimaryKey();
                    foreach ($this->incidentsScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($pk, $remotePk);
                    }
                    IncidentReportQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->incidentsScheduledForDeletion = null;
                }

                foreach ($this->getIncidents() as $incident) {
                    if ($incident->isModified()) {
                        $incident->save($con);
                    }
                }
            } elseif ($this->collIncidents) {
                foreach ($this->collIncidents as $incident) {
                    if ($incident->isModified()) {
                        $incident->save($con);
                    }
                }
            }

            if ($this->reportStatussScheduledForDeletion !== null) {
                if (!$this->reportStatussScheduledForDeletion->isEmpty()) {
                    ReportStatusQuery::create()
                        ->filterByPrimaryKeys($this->reportStatussScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->reportStatussScheduledForDeletion = null;
                }
            }

            if ($this->collReportStatuss !== null) {
                foreach ($this->collReportStatuss as $referrerFK) {
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

        $this->modifiedColumns[] = ReportPeer::IDREPORT;
        if (null !== $this->idreport) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ReportPeer::IDREPORT . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ReportPeer::IDREPORT)) {
            $modifiedColumns[':p' . $index++]  = '`IdReport`';
        }
        if ($this->isColumnModified(ReportPeer::TIMESTAMP)) {
            $modifiedColumns[':p' . $index++]  = '`Timestamp`';
        }
        if ($this->isColumnModified(ReportPeer::ERRORMESSAGE)) {
            $modifiedColumns[':p' . $index++]  = '`ErrorMessage`';
        }
        if ($this->isColumnModified(ReportPeer::CHECKTYPE)) {
            $modifiedColumns[':p' . $index++]  = '`CheckType`';
        }
        if ($this->isColumnModified(ReportPeer::IDSOURCE)) {
            $modifiedColumns[':p' . $index++]  = '`IdSource`';
        }
        if ($this->isColumnModified(ReportPeer::IDSERVICE)) {
            $modifiedColumns[':p' . $index++]  = '`IdService`';
        }

        $sql = sprintf(
            'INSERT INTO `Report` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`IdReport`':
                        $stmt->bindValue($identifier, $this->idreport, PDO::PARAM_INT);
                        break;
                    case '`Timestamp`':
                        $stmt->bindValue($identifier, $this->timestamp, PDO::PARAM_STR);
                        break;
                    case '`ErrorMessage`':
                        $stmt->bindValue($identifier, $this->errormessage, PDO::PARAM_STR);
                        break;
                    case '`CheckType`':
                        $stmt->bindValue($identifier, $this->checktype, PDO::PARAM_STR);
                        break;
                    case '`IdSource`':
                        $stmt->bindValue($identifier, $this->idsource, PDO::PARAM_INT);
                        break;
                    case '`IdService`':
                        $stmt->bindValue($identifier, $this->idservice, PDO::PARAM_INT);
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
        $this->setIdreport($pk);

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


            // We call the validate method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aSource !== null) {
                if (!$this->aSource->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aSource->getValidationFailures());
                }
            }

            if ($this->aService !== null) {
                if (!$this->aService->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aService->getValidationFailures());
                }
            }


            if (($retval = ReportPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collReportStatuss !== null) {
                    foreach ($this->collReportStatuss as $referrerFK) {
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
        $pos = ReportPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getIdreport();
                break;
            case 1:
                return $this->getTimestamp();
                break;
            case 2:
                return $this->getErrormessage();
                break;
            case 3:
                return $this->getChecktype();
                break;
            case 4:
                return $this->getIdsource();
                break;
            case 5:
                return $this->getIdservice();
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
        if (isset($alreadyDumpedObjects['Report'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Report'][$this->getPrimaryKey()] = true;
        $keys = ReportPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdreport(),
            $keys[1] => $this->getTimestamp(),
            $keys[2] => $this->getErrormessage(),
            $keys[3] => $this->getChecktype(),
            $keys[4] => $this->getIdsource(),
            $keys[5] => $this->getIdservice(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aSource) {
                $result['Source'] = $this->aSource->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aService) {
                $result['Service'] = $this->aService->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collReportStatuss) {
                $result['ReportStatuss'] = $this->collReportStatuss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = ReportPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setIdreport($value);
                break;
            case 1:
                $this->setTimestamp($value);
                break;
            case 2:
                $this->setErrormessage($value);
                break;
            case 3:
                $this->setChecktype($value);
                break;
            case 4:
                $this->setIdsource($value);
                break;
            case 5:
                $this->setIdservice($value);
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
        $keys = ReportPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdreport($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setTimestamp($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setErrormessage($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setChecktype($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setIdsource($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setIdservice($arr[$keys[5]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ReportPeer::DATABASE_NAME);

        if ($this->isColumnModified(ReportPeer::IDREPORT)) $criteria->add(ReportPeer::IDREPORT, $this->idreport);
        if ($this->isColumnModified(ReportPeer::TIMESTAMP)) $criteria->add(ReportPeer::TIMESTAMP, $this->timestamp);
        if ($this->isColumnModified(ReportPeer::ERRORMESSAGE)) $criteria->add(ReportPeer::ERRORMESSAGE, $this->errormessage);
        if ($this->isColumnModified(ReportPeer::CHECKTYPE)) $criteria->add(ReportPeer::CHECKTYPE, $this->checktype);
        if ($this->isColumnModified(ReportPeer::IDSOURCE)) $criteria->add(ReportPeer::IDSOURCE, $this->idsource);
        if ($this->isColumnModified(ReportPeer::IDSERVICE)) $criteria->add(ReportPeer::IDSERVICE, $this->idservice);

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
        $criteria = new Criteria(ReportPeer::DATABASE_NAME);
        $criteria->add(ReportPeer::IDREPORT, $this->idreport);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdreport();
    }

    /**
     * Generic method to set the primary key (idreport column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdreport($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdreport();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Report (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTimestamp($this->getTimestamp());
        $copyObj->setErrormessage($this->getErrormessage());
        $copyObj->setChecktype($this->getChecktype());
        $copyObj->setIdsource($this->getIdsource());
        $copyObj->setIdservice($this->getIdservice());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getReportStatuss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addReportStatus($relObj->copy($deepCopy));
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
            $copyObj->setIdreport(NULL); // this is a auto-increment column, so set to default value
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
     * @return Report Clone of current object.
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
     * @return ReportPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ReportPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Source object.
     *
     * @param             Source $v
     * @return Report The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSource(Source $v = null)
    {
        if ($v === null) {
            $this->setIdsource(NULL);
        } else {
            $this->setIdsource($v->getIdsource());
        }

        $this->aSource = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Source object, it will not be re-added.
        if ($v !== null) {
            $v->addReport($this);
        }


        return $this;
    }


    /**
     * Get the associated Source object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Source The associated Source object.
     * @throws PropelException
     */
    public function getSource(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aSource === null && ($this->idsource !== null) && $doQuery) {
            $this->aSource = SourceQuery::create()->findPk($this->idsource, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSource->addReports($this);
             */
        }

        return $this->aSource;
    }

    /**
     * Declares an association between this object and a Service object.
     *
     * @param             Service $v
     * @return Report The current object (for fluent API support)
     * @throws PropelException
     */
    public function setService(Service $v = null)
    {
        if ($v === null) {
            $this->setIdservice(NULL);
        } else {
            $this->setIdservice($v->getIdservice());
        }

        $this->aService = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Service object, it will not be re-added.
        if ($v !== null) {
            $v->addReport($this);
        }


        return $this;
    }


    /**
     * Get the associated Service object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Service The associated Service object.
     * @throws PropelException
     */
    public function getService(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aService === null && ($this->idservice !== null) && $doQuery) {
            $this->aService = ServiceQuery::create()->findPk($this->idservice, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aService->addReports($this);
             */
        }

        return $this->aService;
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
        if ('ReportStatus' == $relationName) {
            $this->initReportStatuss();
        }
        if ('IncidentReport' == $relationName) {
            $this->initIncidentReports();
        }
    }

    /**
     * Clears out the collReportStatuss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Report The current object (for fluent API support)
     * @see        addReportStatuss()
     */
    public function clearReportStatuss()
    {
        $this->collReportStatuss = null; // important to set this to null since that means it is uninitialized
        $this->collReportStatussPartial = null;

        return $this;
    }

    /**
     * reset is the collReportStatuss collection loaded partially
     *
     * @return void
     */
    public function resetPartialReportStatuss($v = true)
    {
        $this->collReportStatussPartial = $v;
    }

    /**
     * Initializes the collReportStatuss collection.
     *
     * By default this just sets the collReportStatuss collection to an empty array (like clearcollReportStatuss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initReportStatuss($overrideExisting = true)
    {
        if (null !== $this->collReportStatuss && !$overrideExisting) {
            return;
        }
        $this->collReportStatuss = new PropelObjectCollection();
        $this->collReportStatuss->setModel('ReportStatus');
    }

    /**
     * Gets an array of ReportStatus objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Report is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ReportStatus[] List of ReportStatus objects
     * @throws PropelException
     */
    public function getReportStatuss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collReportStatussPartial && !$this->isNew();
        if (null === $this->collReportStatuss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collReportStatuss) {
                // return empty collection
                $this->initReportStatuss();
            } else {
                $collReportStatuss = ReportStatusQuery::create(null, $criteria)
                    ->filterByReport($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collReportStatussPartial && count($collReportStatuss)) {
                      $this->initReportStatuss(false);

                      foreach($collReportStatuss as $obj) {
                        if (false == $this->collReportStatuss->contains($obj)) {
                          $this->collReportStatuss->append($obj);
                        }
                      }

                      $this->collReportStatussPartial = true;
                    }

                    $collReportStatuss->getInternalIterator()->rewind();
                    return $collReportStatuss;
                }

                if($partial && $this->collReportStatuss) {
                    foreach($this->collReportStatuss as $obj) {
                        if($obj->isNew()) {
                            $collReportStatuss[] = $obj;
                        }
                    }
                }

                $this->collReportStatuss = $collReportStatuss;
                $this->collReportStatussPartial = false;
            }
        }

        return $this->collReportStatuss;
    }

    /**
     * Sets a collection of ReportStatus objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $reportStatuss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Report The current object (for fluent API support)
     */
    public function setReportStatuss(PropelCollection $reportStatuss, PropelPDO $con = null)
    {
        $reportStatussToDelete = $this->getReportStatuss(new Criteria(), $con)->diff($reportStatuss);

        $this->reportStatussScheduledForDeletion = unserialize(serialize($reportStatussToDelete));

        foreach ($reportStatussToDelete as $reportStatusRemoved) {
            $reportStatusRemoved->setReport(null);
        }

        $this->collReportStatuss = null;
        foreach ($reportStatuss as $reportStatus) {
            $this->addReportStatus($reportStatus);
        }

        $this->collReportStatuss = $reportStatuss;
        $this->collReportStatussPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ReportStatus objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ReportStatus objects.
     * @throws PropelException
     */
    public function countReportStatuss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collReportStatussPartial && !$this->isNew();
        if (null === $this->collReportStatuss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collReportStatuss) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getReportStatuss());
            }
            $query = ReportStatusQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByReport($this)
                ->count($con);
        }

        return count($this->collReportStatuss);
    }

    /**
     * Method called to associate a ReportStatus object to this object
     * through the ReportStatus foreign key attribute.
     *
     * @param    ReportStatus $l ReportStatus
     * @return Report The current object (for fluent API support)
     */
    public function addReportStatus(ReportStatus $l)
    {
        if ($this->collReportStatuss === null) {
            $this->initReportStatuss();
            $this->collReportStatussPartial = true;
        }
        if (!in_array($l, $this->collReportStatuss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddReportStatus($l);
        }

        return $this;
    }

    /**
     * @param	ReportStatus $reportStatus The reportStatus object to add.
     */
    protected function doAddReportStatus($reportStatus)
    {
        $this->collReportStatuss[]= $reportStatus;
        $reportStatus->setReport($this);
    }

    /**
     * @param	ReportStatus $reportStatus The reportStatus object to remove.
     * @return Report The current object (for fluent API support)
     */
    public function removeReportStatus($reportStatus)
    {
        if ($this->getReportStatuss()->contains($reportStatus)) {
            $this->collReportStatuss->remove($this->collReportStatuss->search($reportStatus));
            if (null === $this->reportStatussScheduledForDeletion) {
                $this->reportStatussScheduledForDeletion = clone $this->collReportStatuss;
                $this->reportStatussScheduledForDeletion->clear();
            }
            $this->reportStatussScheduledForDeletion[]= clone $reportStatus;
            $reportStatus->setReport(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Report is new, it will return
     * an empty collection; or if this Report has previously
     * been saved, it will retrieve related ReportStatuss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Report.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ReportStatus[] List of ReportStatus objects
     */
    public function getReportStatussJoinFlag($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ReportStatusQuery::create(null, $criteria);
        $query->joinWith('Flag', $join_behavior);

        return $this->getReportStatuss($query, $con);
    }

    /**
     * Clears out the collIncidentReports collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Report The current object (for fluent API support)
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
     * If this Report is new, it will return
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
                    ->filterByReport($this)
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
     * @return Report The current object (for fluent API support)
     */
    public function setIncidentReports(PropelCollection $incidentReports, PropelPDO $con = null)
    {
        $incidentReportsToDelete = $this->getIncidentReports(new Criteria(), $con)->diff($incidentReports);

        $this->incidentReportsScheduledForDeletion = unserialize(serialize($incidentReportsToDelete));

        foreach ($incidentReportsToDelete as $incidentReportRemoved) {
            $incidentReportRemoved->setReport(null);
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
                ->filterByReport($this)
                ->count($con);
        }

        return count($this->collIncidentReports);
    }

    /**
     * Method called to associate a IncidentReport object to this object
     * through the IncidentReport foreign key attribute.
     *
     * @param    IncidentReport $l IncidentReport
     * @return Report The current object (for fluent API support)
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
        $incidentReport->setReport($this);
    }

    /**
     * @param	IncidentReport $incidentReport The incidentReport object to remove.
     * @return Report The current object (for fluent API support)
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
            $incidentReport->setReport(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Report is new, it will return
     * an empty collection; or if this Report has previously
     * been saved, it will retrieve related IncidentReports from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Report.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|IncidentReport[] List of IncidentReport objects
     */
    public function getIncidentReportsJoinIncident($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = IncidentReportQuery::create(null, $criteria);
        $query->joinWith('Incident', $join_behavior);

        return $this->getIncidentReports($query, $con);
    }

    /**
     * Clears out the collIncidents collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Report The current object (for fluent API support)
     * @see        addIncidents()
     */
    public function clearIncidents()
    {
        $this->collIncidents = null; // important to set this to null since that means it is uninitialized
        $this->collIncidentsPartial = null;

        return $this;
    }

    /**
     * Initializes the collIncidents collection.
     *
     * By default this just sets the collIncidents collection to an empty collection (like clearIncidents());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initIncidents()
    {
        $this->collIncidents = new PropelObjectCollection();
        $this->collIncidents->setModel('Incident');
    }

    /**
     * Gets a collection of Incident objects related by a many-to-many relationship
     * to the current object by way of the IncidentReport cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Report is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param PropelPDO $con Optional connection object
     *
     * @return PropelObjectCollection|Incident[] List of Incident objects
     */
    public function getIncidents($criteria = null, PropelPDO $con = null)
    {
        if (null === $this->collIncidents || null !== $criteria) {
            if ($this->isNew() && null === $this->collIncidents) {
                // return empty collection
                $this->initIncidents();
            } else {
                $collIncidents = IncidentQuery::create(null, $criteria)
                    ->filterByReport($this)
                    ->find($con);
                if (null !== $criteria) {
                    return $collIncidents;
                }
                $this->collIncidents = $collIncidents;
            }
        }

        return $this->collIncidents;
    }

    /**
     * Sets a collection of Incident objects related by a many-to-many relationship
     * to the current object by way of the IncidentReport cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $incidents A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Report The current object (for fluent API support)
     */
    public function setIncidents(PropelCollection $incidents, PropelPDO $con = null)
    {
        $this->clearIncidents();
        $currentIncidents = $this->getIncidents();

        $this->incidentsScheduledForDeletion = $currentIncidents->diff($incidents);

        foreach ($incidents as $incident) {
            if (!$currentIncidents->contains($incident)) {
                $this->doAddIncident($incident);
            }
        }

        $this->collIncidents = $incidents;

        return $this;
    }

    /**
     * Gets the number of Incident objects related by a many-to-many relationship
     * to the current object by way of the IncidentReport cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param boolean $distinct Set to true to force count distinct
     * @param PropelPDO $con Optional connection object
     *
     * @return int the number of related Incident objects
     */
    public function countIncidents($criteria = null, $distinct = false, PropelPDO $con = null)
    {
        if (null === $this->collIncidents || null !== $criteria) {
            if ($this->isNew() && null === $this->collIncidents) {
                return 0;
            } else {
                $query = IncidentQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByReport($this)
                    ->count($con);
            }
        } else {
            return count($this->collIncidents);
        }
    }

    /**
     * Associate a Incident object to this object
     * through the IncidentReport cross reference table.
     *
     * @param  Incident $incident The IncidentReport object to relate
     * @return Report The current object (for fluent API support)
     */
    public function addIncident(Incident $incident)
    {
        if ($this->collIncidents === null) {
            $this->initIncidents();
        }
        if (!$this->collIncidents->contains($incident)) { // only add it if the **same** object is not already associated
            $this->doAddIncident($incident);

            $this->collIncidents[]= $incident;
        }

        return $this;
    }

    /**
     * @param	Incident $incident The incident object to add.
     */
    protected function doAddIncident($incident)
    {
        $incidentReport = new IncidentReport();
        $incidentReport->setIncident($incident);
        $this->addIncidentReport($incidentReport);
    }

    /**
     * Remove a Incident object to this object
     * through the IncidentReport cross reference table.
     *
     * @param Incident $incident The IncidentReport object to relate
     * @return Report The current object (for fluent API support)
     */
    public function removeIncident(Incident $incident)
    {
        if ($this->getIncidents()->contains($incident)) {
            $this->collIncidents->remove($this->collIncidents->search($incident));
            if (null === $this->incidentsScheduledForDeletion) {
                $this->incidentsScheduledForDeletion = clone $this->collIncidents;
                $this->incidentsScheduledForDeletion->clear();
            }
            $this->incidentsScheduledForDeletion[]= $incident;
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->idreport = null;
        $this->timestamp = null;
        $this->errormessage = null;
        $this->checktype = null;
        $this->idsource = null;
        $this->idservice = null;
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
            if ($this->collReportStatuss) {
                foreach ($this->collReportStatuss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collIncidentReports) {
                foreach ($this->collIncidentReports as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collIncidents) {
                foreach ($this->collIncidents as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aSource instanceof Persistent) {
              $this->aSource->clearAllReferences($deep);
            }
            if ($this->aService instanceof Persistent) {
              $this->aService->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collReportStatuss instanceof PropelCollection) {
            $this->collReportStatuss->clearIterator();
        }
        $this->collReportStatuss = null;
        if ($this->collIncidentReports instanceof PropelCollection) {
            $this->collIncidentReports->clearIterator();
        }
        $this->collIncidentReports = null;
        if ($this->collIncidents instanceof PropelCollection) {
            $this->collIncidents->clearIterator();
        }
        $this->collIncidents = null;
        $this->aSource = null;
        $this->aService = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ReportPeer::DEFAULT_STRING_FORMAT);
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
