<?php


/**
 * Base class that represents a query for the 'ReportStatus' table.
 *
 *
 *
 * @method ReportStatusQuery orderByIdreport($order = Criteria::ASC) Order by the IdReport column
 * @method ReportStatusQuery orderByTimestamp($order = Criteria::ASC) Order by the Timestamp column
 * @method ReportStatusQuery orderByIdflag($order = Criteria::ASC) Order by the IdFlag column
 *
 * @method ReportStatusQuery groupByIdreport() Group by the IdReport column
 * @method ReportStatusQuery groupByTimestamp() Group by the Timestamp column
 * @method ReportStatusQuery groupByIdflag() Group by the IdFlag column
 *
 * @method ReportStatusQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ReportStatusQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ReportStatusQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ReportStatusQuery leftJoinReport($relationAlias = null) Adds a LEFT JOIN clause to the query using the Report relation
 * @method ReportStatusQuery rightJoinReport($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Report relation
 * @method ReportStatusQuery innerJoinReport($relationAlias = null) Adds a INNER JOIN clause to the query using the Report relation
 *
 * @method ReportStatusQuery leftJoinFlag($relationAlias = null) Adds a LEFT JOIN clause to the query using the Flag relation
 * @method ReportStatusQuery rightJoinFlag($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Flag relation
 * @method ReportStatusQuery innerJoinFlag($relationAlias = null) Adds a INNER JOIN clause to the query using the Flag relation
 *
 * @method ReportStatus findOne(PropelPDO $con = null) Return the first ReportStatus matching the query
 * @method ReportStatus findOneOrCreate(PropelPDO $con = null) Return the first ReportStatus matching the query, or a new ReportStatus object populated from the query conditions when no match is found
 *
 * @method ReportStatus findOneByIdreport(int $IdReport) Return the first ReportStatus filtered by the IdReport column
 * @method ReportStatus findOneByTimestamp(string $Timestamp) Return the first ReportStatus filtered by the Timestamp column
 * @method ReportStatus findOneByIdflag(int $IdFlag) Return the first ReportStatus filtered by the IdFlag column
 *
 * @method array findByIdreport(int $IdReport) Return ReportStatus objects filtered by the IdReport column
 * @method array findByTimestamp(string $Timestamp) Return ReportStatus objects filtered by the Timestamp column
 * @method array findByIdflag(int $IdFlag) Return ReportStatus objects filtered by the IdFlag column
 *
 * @package    propel.generator.aptostat_api.om
 */
abstract class BaseReportStatusQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseReportStatusQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Aptostat', $modelName = 'ReportStatus', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ReportStatusQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ReportStatusQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ReportStatusQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ReportStatusQuery) {
            return $criteria;
        }
        $query = new ReportStatusQuery();
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
                         A Primary key composition: [$IdReport, $Timestamp]
     * @param     PropelPDO $con an optional connection object
     *
     * @return   ReportStatus|ReportStatus[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ReportStatusPeer::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ReportStatusPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 ReportStatus A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `IdReport`, `Timestamp`, `IdFlag` FROM `ReportStatus` WHERE `IdReport` = :p0 AND `Timestamp` = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new ReportStatus();
            $obj->hydrate($row);
            ReportStatusPeer::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ReportStatus|ReportStatus[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|ReportStatus[]|mixed the list of results, formatted by the current formatter
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
     * @return ReportStatusQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ReportStatusPeer::IDREPORT, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ReportStatusPeer::TIMESTAMP, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ReportStatusQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ReportStatusPeer::IDREPORT, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ReportStatusPeer::TIMESTAMP, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return ReportStatusQuery The current query, for fluid interface
     */
    public function filterByIdreport($idreport = null, $comparison = null)
    {
        if (is_array($idreport)) {
            $useMinMax = false;
            if (isset($idreport['min'])) {
                $this->addUsingAlias(ReportStatusPeer::IDREPORT, $idreport['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idreport['max'])) {
                $this->addUsingAlias(ReportStatusPeer::IDREPORT, $idreport['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ReportStatusPeer::IDREPORT, $idreport, $comparison);
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
     * @return ReportStatusQuery The current query, for fluid interface
     */
    public function filterByTimestamp($timestamp = null, $comparison = null)
    {
        if (is_array($timestamp)) {
            $useMinMax = false;
            if (isset($timestamp['min'])) {
                $this->addUsingAlias(ReportStatusPeer::TIMESTAMP, $timestamp['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timestamp['max'])) {
                $this->addUsingAlias(ReportStatusPeer::TIMESTAMP, $timestamp['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ReportStatusPeer::TIMESTAMP, $timestamp, $comparison);
    }

    /**
     * Filter the query on the IdFlag column
     *
     * Example usage:
     * <code>
     * $query->filterByIdflag(1234); // WHERE IdFlag = 1234
     * $query->filterByIdflag(array(12, 34)); // WHERE IdFlag IN (12, 34)
     * $query->filterByIdflag(array('min' => 12)); // WHERE IdFlag >= 12
     * $query->filterByIdflag(array('max' => 12)); // WHERE IdFlag <= 12
     * </code>
     *
     * @see       filterByFlag()
     *
     * @param     mixed $idflag The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ReportStatusQuery The current query, for fluid interface
     */
    public function filterByIdflag($idflag = null, $comparison = null)
    {
        if (is_array($idflag)) {
            $useMinMax = false;
            if (isset($idflag['min'])) {
                $this->addUsingAlias(ReportStatusPeer::IDFLAG, $idflag['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idflag['max'])) {
                $this->addUsingAlias(ReportStatusPeer::IDFLAG, $idflag['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ReportStatusPeer::IDFLAG, $idflag, $comparison);
    }

    /**
     * Filter the query by a related Report object
     *
     * @param   Report|PropelObjectCollection $report The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ReportStatusQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByReport($report, $comparison = null)
    {
        if ($report instanceof Report) {
            return $this
                ->addUsingAlias(ReportStatusPeer::IDREPORT, $report->getIdreport(), $comparison);
        } elseif ($report instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ReportStatusPeer::IDREPORT, $report->toKeyValue('PrimaryKey', 'Idreport'), $comparison);
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
     * @return ReportStatusQuery The current query, for fluid interface
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
     * Filter the query by a related Flag object
     *
     * @param   Flag|PropelObjectCollection $flag The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ReportStatusQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFlag($flag, $comparison = null)
    {
        if ($flag instanceof Flag) {
            return $this
                ->addUsingAlias(ReportStatusPeer::IDFLAG, $flag->getIdflag(), $comparison);
        } elseif ($flag instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ReportStatusPeer::IDFLAG, $flag->toKeyValue('PrimaryKey', 'Idflag'), $comparison);
        } else {
            throw new PropelException('filterByFlag() only accepts arguments of type Flag or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Flag relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ReportStatusQuery The current query, for fluid interface
     */
    public function joinFlag($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Flag');

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
            $this->addJoinObject($join, 'Flag');
        }

        return $this;
    }

    /**
     * Use the Flag relation Flag object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   FlagQuery A secondary query class using the current class as primary query
     */
    public function useFlagQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFlag($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Flag', 'FlagQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ReportStatus $reportStatus Object to remove from the list of results
     *
     * @return ReportStatusQuery The current query, for fluid interface
     */
    public function prune($reportStatus = null)
    {
        if ($reportStatus) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ReportStatusPeer::IDREPORT), $reportStatus->getIdreport(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ReportStatusPeer::TIMESTAMP), $reportStatus->getTimestamp(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

}
