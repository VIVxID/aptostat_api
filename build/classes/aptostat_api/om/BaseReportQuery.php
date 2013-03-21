<?php


/**
 * Base class that represents a query for the 'Report' table.
 *
 *
 *
 * @method ReportQuery orderByIdreport($order = Criteria::ASC) Order by the IdReport column
 * @method ReportQuery orderByTimestamp($order = Criteria::ASC) Order by the Timestamp column
 * @method ReportQuery orderByErrormessage($order = Criteria::ASC) Order by the ErrorMessage column
 * @method ReportQuery orderByChecktype($order = Criteria::ASC) Order by the CheckType column
 * @method ReportQuery orderByIdsource($order = Criteria::ASC) Order by the IdSource column
 * @method ReportQuery orderByIdservice($order = Criteria::ASC) Order by the IdService column
 *
 * @method ReportQuery groupByIdreport() Group by the IdReport column
 * @method ReportQuery groupByTimestamp() Group by the Timestamp column
 * @method ReportQuery groupByErrormessage() Group by the ErrorMessage column
 * @method ReportQuery groupByChecktype() Group by the CheckType column
 * @method ReportQuery groupByIdsource() Group by the IdSource column
 * @method ReportQuery groupByIdservice() Group by the IdService column
 *
 * @method ReportQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ReportQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ReportQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ReportQuery leftJoinSource($relationAlias = null) Adds a LEFT JOIN clause to the query using the Source relation
 * @method ReportQuery rightJoinSource($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Source relation
 * @method ReportQuery innerJoinSource($relationAlias = null) Adds a INNER JOIN clause to the query using the Source relation
 *
 * @method ReportQuery leftJoinService($relationAlias = null) Adds a LEFT JOIN clause to the query using the Service relation
 * @method ReportQuery rightJoinService($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Service relation
 * @method ReportQuery innerJoinService($relationAlias = null) Adds a INNER JOIN clause to the query using the Service relation
 *
 * @method ReportQuery leftJoinReportStatus($relationAlias = null) Adds a LEFT JOIN clause to the query using the ReportStatus relation
 * @method ReportQuery rightJoinReportStatus($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ReportStatus relation
 * @method ReportQuery innerJoinReportStatus($relationAlias = null) Adds a INNER JOIN clause to the query using the ReportStatus relation
 *
 * @method ReportQuery leftJoinIncidentReport($relationAlias = null) Adds a LEFT JOIN clause to the query using the IncidentReport relation
 * @method ReportQuery rightJoinIncidentReport($relationAlias = null) Adds a RIGHT JOIN clause to the query using the IncidentReport relation
 * @method ReportQuery innerJoinIncidentReport($relationAlias = null) Adds a INNER JOIN clause to the query using the IncidentReport relation
 *
 * @method Report findOne(PropelPDO $con = null) Return the first Report matching the query
 * @method Report findOneOrCreate(PropelPDO $con = null) Return the first Report matching the query, or a new Report object populated from the query conditions when no match is found
 *
 * @method Report findOneByTimestamp(string $Timestamp) Return the first Report filtered by the Timestamp column
 * @method Report findOneByErrormessage(string $ErrorMessage) Return the first Report filtered by the ErrorMessage column
 * @method Report findOneByChecktype(string $CheckType) Return the first Report filtered by the CheckType column
 * @method Report findOneByIdsource(int $IdSource) Return the first Report filtered by the IdSource column
 * @method Report findOneByIdservice(int $IdService) Return the first Report filtered by the IdService column
 *
 * @method array findByIdreport(int $IdReport) Return Report objects filtered by the IdReport column
 * @method array findByTimestamp(string $Timestamp) Return Report objects filtered by the Timestamp column
 * @method array findByErrormessage(string $ErrorMessage) Return Report objects filtered by the ErrorMessage column
 * @method array findByChecktype(string $CheckType) Return Report objects filtered by the CheckType column
 * @method array findByIdsource(int $IdSource) Return Report objects filtered by the IdSource column
 * @method array findByIdservice(int $IdService) Return Report objects filtered by the IdService column
 *
 * @package    propel.generator.aptostat_api.om
 */
abstract class BaseReportQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseReportQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Aptostat', $modelName = 'Report', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ReportQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ReportQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ReportQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ReportQuery) {
            return $criteria;
        }
        $query = new ReportQuery();
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
     * @return   Report|Report[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ReportPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ReportPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Report A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByIdreport($key, $con = null)
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
     * @return                 Report A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `IdReport`, `Timestamp`, `ErrorMessage`, `CheckType`, `IdSource`, `IdService` FROM `Report` WHERE `IdReport` = :p0';
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
            $obj = new Report();
            $obj->hydrate($row);
            ReportPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Report|Report[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Report[]|mixed the list of results, formatted by the current formatter
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
     * @return ReportQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ReportPeer::IDREPORT, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ReportQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ReportPeer::IDREPORT, $keys, Criteria::IN);
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
     * @param     mixed $idreport The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ReportQuery The current query, for fluid interface
     */
    public function filterByIdreport($idreport = null, $comparison = null)
    {
        if (is_array($idreport)) {
            $useMinMax = false;
            if (isset($idreport['min'])) {
                $this->addUsingAlias(ReportPeer::IDREPORT, $idreport['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idreport['max'])) {
                $this->addUsingAlias(ReportPeer::IDREPORT, $idreport['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ReportPeer::IDREPORT, $idreport, $comparison);
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
     * @return ReportQuery The current query, for fluid interface
     */
    public function filterByTimestamp($timestamp = null, $comparison = null)
    {
        if (is_array($timestamp)) {
            $useMinMax = false;
            if (isset($timestamp['min'])) {
                $this->addUsingAlias(ReportPeer::TIMESTAMP, $timestamp['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timestamp['max'])) {
                $this->addUsingAlias(ReportPeer::TIMESTAMP, $timestamp['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ReportPeer::TIMESTAMP, $timestamp, $comparison);
    }

    /**
     * Filter the query on the ErrorMessage column
     *
     * Example usage:
     * <code>
     * $query->filterByErrormessage('fooValue');   // WHERE ErrorMessage = 'fooValue'
     * $query->filterByErrormessage('%fooValue%'); // WHERE ErrorMessage LIKE '%fooValue%'
     * </code>
     *
     * @param     string $errormessage The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ReportQuery The current query, for fluid interface
     */
    public function filterByErrormessage($errormessage = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($errormessage)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $errormessage)) {
                $errormessage = str_replace('*', '%', $errormessage);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ReportPeer::ERRORMESSAGE, $errormessage, $comparison);
    }

    /**
     * Filter the query on the CheckType column
     *
     * Example usage:
     * <code>
     * $query->filterByChecktype('fooValue');   // WHERE CheckType = 'fooValue'
     * $query->filterByChecktype('%fooValue%'); // WHERE CheckType LIKE '%fooValue%'
     * </code>
     *
     * @param     string $checktype The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ReportQuery The current query, for fluid interface
     */
    public function filterByChecktype($checktype = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($checktype)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $checktype)) {
                $checktype = str_replace('*', '%', $checktype);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ReportPeer::CHECKTYPE, $checktype, $comparison);
    }

    /**
     * Filter the query on the IdSource column
     *
     * Example usage:
     * <code>
     * $query->filterByIdsource(1234); // WHERE IdSource = 1234
     * $query->filterByIdsource(array(12, 34)); // WHERE IdSource IN (12, 34)
     * $query->filterByIdsource(array('min' => 12)); // WHERE IdSource >= 12
     * $query->filterByIdsource(array('max' => 12)); // WHERE IdSource <= 12
     * </code>
     *
     * @see       filterBySource()
     *
     * @param     mixed $idsource The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ReportQuery The current query, for fluid interface
     */
    public function filterByIdsource($idsource = null, $comparison = null)
    {
        if (is_array($idsource)) {
            $useMinMax = false;
            if (isset($idsource['min'])) {
                $this->addUsingAlias(ReportPeer::IDSOURCE, $idsource['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idsource['max'])) {
                $this->addUsingAlias(ReportPeer::IDSOURCE, $idsource['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ReportPeer::IDSOURCE, $idsource, $comparison);
    }

    /**
     * Filter the query on the IdService column
     *
     * Example usage:
     * <code>
     * $query->filterByIdservice(1234); // WHERE IdService = 1234
     * $query->filterByIdservice(array(12, 34)); // WHERE IdService IN (12, 34)
     * $query->filterByIdservice(array('min' => 12)); // WHERE IdService >= 12
     * $query->filterByIdservice(array('max' => 12)); // WHERE IdService <= 12
     * </code>
     *
     * @see       filterByService()
     *
     * @param     mixed $idservice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ReportQuery The current query, for fluid interface
     */
    public function filterByIdservice($idservice = null, $comparison = null)
    {
        if (is_array($idservice)) {
            $useMinMax = false;
            if (isset($idservice['min'])) {
                $this->addUsingAlias(ReportPeer::IDSERVICE, $idservice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idservice['max'])) {
                $this->addUsingAlias(ReportPeer::IDSERVICE, $idservice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ReportPeer::IDSERVICE, $idservice, $comparison);
    }

    /**
     * Filter the query by a related Source object
     *
     * @param   Source|PropelObjectCollection $source The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ReportQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterBySource($source, $comparison = null)
    {
        if ($source instanceof Source) {
            return $this
                ->addUsingAlias(ReportPeer::IDSOURCE, $source->getIdsource(), $comparison);
        } elseif ($source instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ReportPeer::IDSOURCE, $source->toKeyValue('PrimaryKey', 'Idsource'), $comparison);
        } else {
            throw new PropelException('filterBySource() only accepts arguments of type Source or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Source relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ReportQuery The current query, for fluid interface
     */
    public function joinSource($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Source');

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
            $this->addJoinObject($join, 'Source');
        }

        return $this;
    }

    /**
     * Use the Source relation Source object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   SourceQuery A secondary query class using the current class as primary query
     */
    public function useSourceQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSource($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Source', 'SourceQuery');
    }

    /**
     * Filter the query by a related Service object
     *
     * @param   Service|PropelObjectCollection $service The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ReportQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByService($service, $comparison = null)
    {
        if ($service instanceof Service) {
            return $this
                ->addUsingAlias(ReportPeer::IDSERVICE, $service->getIdservice(), $comparison);
        } elseif ($service instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ReportPeer::IDSERVICE, $service->toKeyValue('PrimaryKey', 'Idservice'), $comparison);
        } else {
            throw new PropelException('filterByService() only accepts arguments of type Service or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Service relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ReportQuery The current query, for fluid interface
     */
    public function joinService($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Service');

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
            $this->addJoinObject($join, 'Service');
        }

        return $this;
    }

    /**
     * Use the Service relation Service object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   ServiceQuery A secondary query class using the current class as primary query
     */
    public function useServiceQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinService($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Service', 'ServiceQuery');
    }

    /**
     * Filter the query by a related ReportStatus object
     *
     * @param   ReportStatus|PropelObjectCollection $reportStatus  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ReportQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByReportStatus($reportStatus, $comparison = null)
    {
        if ($reportStatus instanceof ReportStatus) {
            return $this
                ->addUsingAlias(ReportPeer::IDREPORT, $reportStatus->getIdreport(), $comparison);
        } elseif ($reportStatus instanceof PropelObjectCollection) {
            return $this
                ->useReportStatusQuery()
                ->filterByPrimaryKeys($reportStatus->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByReportStatus() only accepts arguments of type ReportStatus or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ReportStatus relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ReportQuery The current query, for fluid interface
     */
    public function joinReportStatus($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ReportStatus');

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
            $this->addJoinObject($join, 'ReportStatus');
        }

        return $this;
    }

    /**
     * Use the ReportStatus relation ReportStatus object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   ReportStatusQuery A secondary query class using the current class as primary query
     */
    public function useReportStatusQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinReportStatus($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ReportStatus', 'ReportStatusQuery');
    }

    /**
     * Filter the query by a related IncidentReport object
     *
     * @param   IncidentReport|PropelObjectCollection $incidentReport  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ReportQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByIncidentReport($incidentReport, $comparison = null)
    {
        if ($incidentReport instanceof IncidentReport) {
            return $this
                ->addUsingAlias(ReportPeer::IDREPORT, $incidentReport->getIdreport(), $comparison);
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
     * @return ReportQuery The current query, for fluid interface
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
     * Filter the query by a related Incident object
     * using the IncidentReport table as cross reference
     *
     * @param   Incident $incident the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   ReportQuery The current query, for fluid interface
     */
    public function filterByIncident($incident, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useIncidentReportQuery()
            ->filterByIncident($incident, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   Report $report Object to remove from the list of results
     *
     * @return ReportQuery The current query, for fluid interface
     */
    public function prune($report = null)
    {
        if ($report) {
            $this->addUsingAlias(ReportPeer::IDREPORT, $report->getIdreport(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
