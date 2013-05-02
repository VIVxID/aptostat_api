<?php


/**
 * Base class that represents a query for the 'IncidentReport' table.
 *
 *
 *
 * @method IncidentReportQuery orderByIdincident($order = Criteria::ASC) Order by the IdIncident column
 * @method IncidentReportQuery orderByIdreport($order = Criteria::ASC) Order by the IdReport column
 *
 * @method IncidentReportQuery groupByIdincident() Group by the IdIncident column
 * @method IncidentReportQuery groupByIdreport() Group by the IdReport column
 *
 * @method IncidentReportQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method IncidentReportQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method IncidentReportQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method IncidentReportQuery leftJoinReport($relationAlias = null) Adds a LEFT JOIN clause to the query using the Report relation
 * @method IncidentReportQuery rightJoinReport($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Report relation
 * @method IncidentReportQuery innerJoinReport($relationAlias = null) Adds a INNER JOIN clause to the query using the Report relation
 *
 * @method IncidentReportQuery leftJoinIncident($relationAlias = null) Adds a LEFT JOIN clause to the query using the Incident relation
 * @method IncidentReportQuery rightJoinIncident($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Incident relation
 * @method IncidentReportQuery innerJoinIncident($relationAlias = null) Adds a INNER JOIN clause to the query using the Incident relation
 *
 * @method IncidentReport findOne(PropelPDO $con = null) Return the first IncidentReport matching the query
 * @method IncidentReport findOneOrCreate(PropelPDO $con = null) Return the first IncidentReport matching the query, or a new IncidentReport object populated from the query conditions when no match is found
 *
 * @method IncidentReport findOneByIdincident(int $IdIncident) Return the first IncidentReport filtered by the IdIncident column
 * @method IncidentReport findOneByIdreport(int $IdReport) Return the first IncidentReport filtered by the IdReport column
 *
 * @method array findByIdincident(int $IdIncident) Return IncidentReport objects filtered by the IdIncident column
 * @method array findByIdreport(int $IdReport) Return IncidentReport objects filtered by the IdReport column
 *
 * @package    propel.generator.aptostat_api.om
 */
abstract class BaseIncidentReportQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseIncidentReportQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'aptostat', $modelName = 'IncidentReport', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new IncidentReportQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   IncidentReportQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return IncidentReportQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof IncidentReportQuery) {
            return $criteria;
        }
        $query = new IncidentReportQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array $key Primary key to use for the query
                         A Primary key composition: [$IdIncident, $IdReport]
     * @param     PropelPDO $con an optional connection object
     *
     * @return   IncidentReport|IncidentReport[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = IncidentReportPeer::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(IncidentReportPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 IncidentReport A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `IdIncident`, `IdReport` FROM `IncidentReport` WHERE `IdIncident` = :p0 AND `IdReport` = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new IncidentReport();
            $obj->hydrate($row);
            IncidentReportPeer::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return IncidentReport|IncidentReport[]|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|IncidentReport[]|mixed the list of results, formatted by the current formatter
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
     * @return IncidentReportQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(IncidentReportPeer::IDINCIDENT, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(IncidentReportPeer::IDREPORT, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return IncidentReportQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(IncidentReportPeer::IDINCIDENT, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(IncidentReportPeer::IDREPORT, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @see       filterByIncident()
     *
     * @param     mixed $idincident The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return IncidentReportQuery The current query, for fluid interface
     */
    public function filterByIdincident($idincident = null, $comparison = null)
    {
        if (is_array($idincident)) {
            $useMinMax = false;
            if (isset($idincident['min'])) {
                $this->addUsingAlias(IncidentReportPeer::IDINCIDENT, $idincident['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idincident['max'])) {
                $this->addUsingAlias(IncidentReportPeer::IDINCIDENT, $idincident['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IncidentReportPeer::IDINCIDENT, $idincident, $comparison);
    }

    /**
     * Filter the query on the IdReport column
     *
     * Example usage:
     * <code>
     * $query->filterByIdreport(1234); // WHERE IdReport = 1234
     * $query->filterByIdreport(array(12, 34)); // WHERE IdReport IN (12, 34)
     * $query->filterByIdreport(array('min' => 12)); // WHERE IdReport >= 12
     * $query->filterByIdreport(array('max' => 12)); // WHERE IdReport <= 12
     * </code>
     *
     * @see       filterByReport()
     *
     * @param     mixed $idreport The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return IncidentReportQuery The current query, for fluid interface
     */
    public function filterByIdreport($idreport = null, $comparison = null)
    {
        if (is_array($idreport)) {
            $useMinMax = false;
            if (isset($idreport['min'])) {
                $this->addUsingAlias(IncidentReportPeer::IDREPORT, $idreport['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idreport['max'])) {
                $this->addUsingAlias(IncidentReportPeer::IDREPORT, $idreport['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IncidentReportPeer::IDREPORT, $idreport, $comparison);
    }

    /**
     * Filter the query by a related Report object
     *
     * @param   Report|PropelObjectCollection $report The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 IncidentReportQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByReport($report, $comparison = null)
    {
        if ($report instanceof Report) {
            return $this
                ->addUsingAlias(IncidentReportPeer::IDREPORT, $report->getIdreport(), $comparison);
        } elseif ($report instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(IncidentReportPeer::IDREPORT, $report->toKeyValue('PrimaryKey', 'Idreport'), $comparison);
        } else {
            throw new PropelException('filterByReport() only accepts arguments of type Report or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Report relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return IncidentReportQuery The current query, for fluid interface
     */
    public function joinReport($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Report');

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
            $this->addJoinObject($join, 'Report');
        }

        return $this;
    }

    /**
     * Use the Report relation Report object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   ReportQuery A secondary query class using the current class as primary query
     */
    public function useReportQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinReport($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Report', 'ReportQuery');
    }

    /**
     * Filter the query by a related Incident object
     *
     * @param   Incident|PropelObjectCollection $incident The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 IncidentReportQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByIncident($incident, $comparison = null)
    {
        if ($incident instanceof Incident) {
            return $this
                ->addUsingAlias(IncidentReportPeer::IDINCIDENT, $incident->getIdincident(), $comparison);
        } elseif ($incident instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(IncidentReportPeer::IDINCIDENT, $incident->toKeyValue('PrimaryKey', 'Idincident'), $comparison);
        } else {
            throw new PropelException('filterByIncident() only accepts arguments of type Incident or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Incident relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return IncidentReportQuery The current query, for fluid interface
     */
    public function joinIncident($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Incident');

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
            $this->addJoinObject($join, 'Incident');
        }

        return $this;
    }

    /**
     * Use the Incident relation Incident object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   IncidentQuery A secondary query class using the current class as primary query
     */
    public function useIncidentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinIncident($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Incident', 'IncidentQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   IncidentReport $incidentReport Object to remove from the list of results
     *
     * @return IncidentReportQuery The current query, for fluid interface
     */
    public function prune($incidentReport = null)
    {
        if ($incidentReport) {
            $this->addCond('pruneCond0', $this->getAliasedColName(IncidentReportPeer::IDINCIDENT), $incidentReport->getIdincident(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(IncidentReportPeer::IDREPORT), $incidentReport->getIdreport(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

}
