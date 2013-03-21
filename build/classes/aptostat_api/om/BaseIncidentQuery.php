<?php


/**
 * Base class that represents a query for the 'Incident' table.
 *
 *
 *
 * @method IncidentQuery orderByIdincident($order = Criteria::ASC) Order by the IdIncident column
 * @method IncidentQuery orderByTimestamp($order = Criteria::ASC) Order by the Timestamp column
 *
 * @method IncidentQuery groupByIdincident() Group by the IdIncident column
 * @method IncidentQuery groupByTimestamp() Group by the Timestamp column
 *
 * @method IncidentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method IncidentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method IncidentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method IncidentQuery leftJoinMessage($relationAlias = null) Adds a LEFT JOIN clause to the query using the Message relation
 * @method IncidentQuery rightJoinMessage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Message relation
 * @method IncidentQuery innerJoinMessage($relationAlias = null) Adds a INNER JOIN clause to the query using the Message relation
 *
 * @method IncidentQuery leftJoinIncidentReport($relationAlias = null) Adds a LEFT JOIN clause to the query using the IncidentReport relation
 * @method IncidentQuery rightJoinIncidentReport($relationAlias = null) Adds a RIGHT JOIN clause to the query using the IncidentReport relation
 * @method IncidentQuery innerJoinIncidentReport($relationAlias = null) Adds a INNER JOIN clause to the query using the IncidentReport relation
 *
 * @method Incident findOne(PropelPDO $con = null) Return the first Incident matching the query
 * @method Incident findOneOrCreate(PropelPDO $con = null) Return the first Incident matching the query, or a new Incident object populated from the query conditions when no match is found
 *
 * @method Incident findOneByTimestamp(string $Timestamp) Return the first Incident filtered by the Timestamp column
 *
 * @method array findByIdincident(int $IdIncident) Return Incident objects filtered by the IdIncident column
 * @method array findByTimestamp(string $Timestamp) Return Incident objects filtered by the Timestamp column
 *
 * @package    propel.generator.aptostat_api.om
 */
abstract class BaseIncidentQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseIncidentQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Aptostat', $modelName = 'Incident', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new IncidentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   IncidentQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return IncidentQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof IncidentQuery) {
            return $criteria;
        }
        $query = new IncidentQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Incident|Incident[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = IncidentPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(IncidentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Incident A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByIdincident($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Incident A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `IdIncident`, `Timestamp` FROM `Incident` WHERE `IdIncident` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Incident();
            $obj->hydrate($row);
            IncidentPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return Incident|Incident[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Incident[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return IncidentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(IncidentPeer::IDINCIDENT, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return IncidentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(IncidentPeer::IDINCIDENT, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the IdIncident column
     *
     * Example usage:
     * <code>
     * $query->filterByIdincident(1234); // WHERE IdIncident = 1234
     * $query->filterByIdincident(array(12, 34)); // WHERE IdIncident IN (12, 34)
     * $query->filterByIdincident(array('min' => 12)); // WHERE IdIncident >= 12
     * $query->filterByIdincident(array('max' => 12)); // WHERE IdIncident <= 12
     * </code>
     *
     * @param     mixed $idincident The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return IncidentQuery The current query, for fluid interface
     */
    public function filterByIdincident($idincident = null, $comparison = null)
    {
        if (is_array($idincident)) {
            $useMinMax = false;
            if (isset($idincident['min'])) {
                $this->addUsingAlias(IncidentPeer::IDINCIDENT, $idincident['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idincident['max'])) {
                $this->addUsingAlias(IncidentPeer::IDINCIDENT, $idincident['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IncidentPeer::IDINCIDENT, $idincident, $comparison);
    }

    /**
     * Filter the query on the Timestamp column
     *
     * Example usage:
     * <code>
     * $query->filterByTimestamp('2011-03-14'); // WHERE Timestamp = '2011-03-14'
     * $query->filterByTimestamp('now'); // WHERE Timestamp = '2011-03-14'
     * $query->filterByTimestamp(array('max' => 'yesterday')); // WHERE Timestamp > '2011-03-13'
     * </code>
     *
     * @param     mixed $timestamp The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return IncidentQuery The current query, for fluid interface
     */
    public function filterByTimestamp($timestamp = null, $comparison = null)
    {
        if (is_array($timestamp)) {
            $useMinMax = false;
            if (isset($timestamp['min'])) {
                $this->addUsingAlias(IncidentPeer::TIMESTAMP, $timestamp['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timestamp['max'])) {
                $this->addUsingAlias(IncidentPeer::TIMESTAMP, $timestamp['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IncidentPeer::TIMESTAMP, $timestamp, $comparison);
    }

    /**
     * Filter the query by a related Message object
     *
     * @param   Message|PropelObjectCollection $message  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 IncidentQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMessage($message, $comparison = null)
    {
        if ($message instanceof Message) {
            return $this
                ->addUsingAlias(IncidentPeer::IDINCIDENT, $message->getIdincident(), $comparison);
        } elseif ($message instanceof PropelObjectCollection) {
            return $this
                ->useMessageQuery()
                ->filterByPrimaryKeys($message->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMessage() only accepts arguments of type Message or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Message relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return IncidentQuery The current query, for fluid interface
     */
    public function joinMessage($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Message');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Message');
        }

        return $this;
    }

    /**
     * Use the Message relation Message object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   MessageQuery A secondary query class using the current class as primary query
     */
    public function useMessageQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMessage($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Message', 'MessageQuery');
    }

    /**
     * Filter the query by a related IncidentReport object
     *
     * @param   IncidentReport|PropelObjectCollection $incidentReport  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 IncidentQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByIncidentReport($incidentReport, $comparison = null)
    {
        if ($incidentReport instanceof IncidentReport) {
            return $this
                ->addUsingAlias(IncidentPeer::IDINCIDENT, $incidentReport->getIdincident(), $comparison);
        } elseif ($incidentReport instanceof PropelObjectCollection) {
            return $this
                ->useIncidentReportQuery()
                ->filterByPrimaryKeys($incidentReport->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByIncidentReport() only accepts arguments of type IncidentReport or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the IncidentReport relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return IncidentQuery The current query, for fluid interface
     */
    public function joinIncidentReport($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('IncidentReport');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'IncidentReport');
        }

        return $this;
    }

    /**
     * Use the IncidentReport relation IncidentReport object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   IncidentReportQuery A secondary query class using the current class as primary query
     */
    public function useIncidentReportQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinIncidentReport($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'IncidentReport', 'IncidentReportQuery');
    }

    /**
     * Filter the query by a related Report object
     * using the IncidentReport table as cross reference
     *
     * @param   Report $report the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   IncidentQuery The current query, for fluid interface
     */
    public function filterByReport($report, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useIncidentReportQuery()
            ->filterByReport($report, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   Incident $incident Object to remove from the list of results
     *
     * @return IncidentQuery The current query, for fluid interface
     */
    public function prune($incident = null)
    {
        if ($incident) {
            $this->addUsingAlias(IncidentPeer::IDINCIDENT, $incident->getIdincident(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
