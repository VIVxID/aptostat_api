<?php


/**
 * Base class that represents a query for the 'Flag' table.
 *
 *
 *
 * @method FlagQuery orderByIdflag($order = Criteria::ASC) Order by the IdFlag column
 * @method FlagQuery orderByName($order = Criteria::ASC) Order by the Name column
 *
 * @method FlagQuery groupByIdflag() Group by the IdFlag column
 * @method FlagQuery groupByName() Group by the Name column
 *
 * @method FlagQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method FlagQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method FlagQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method FlagQuery leftJoinMessage($relationAlias = null) Adds a LEFT JOIN clause to the query using the Message relation
 * @method FlagQuery rightJoinMessage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Message relation
 * @method FlagQuery innerJoinMessage($relationAlias = null) Adds a INNER JOIN clause to the query using the Message relation
 *
 * @method FlagQuery leftJoinReportStatus($relationAlias = null) Adds a LEFT JOIN clause to the query using the ReportStatus relation
 * @method FlagQuery rightJoinReportStatus($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ReportStatus relation
 * @method FlagQuery innerJoinReportStatus($relationAlias = null) Adds a INNER JOIN clause to the query using the ReportStatus relation
 *
 * @method Flag findOne(PropelPDO $con = null) Return the first Flag matching the query
 * @method Flag findOneOrCreate(PropelPDO $con = null) Return the first Flag matching the query, or a new Flag object populated from the query conditions when no match is found
 *
 * @method Flag findOneByName(string $Name) Return the first Flag filtered by the Name column
 *
 * @method array findByIdflag(int $IdFlag) Return Flag objects filtered by the IdFlag column
 * @method array findByName(string $Name) Return Flag objects filtered by the Name column
 *
 * @package    propel.generator.aptostat_api.om
 */
abstract class BaseFlagQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseFlagQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Aptostat', $modelName = 'Flag', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new FlagQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   FlagQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return FlagQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof FlagQuery) {
            return $criteria;
        }
        $query = new FlagQuery();
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
     * @return   Flag|Flag[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FlagPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(FlagPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Flag A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByIdflag($key, $con = null)
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
     * @return                 Flag A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `IdFlag`, `Name` FROM `Flag` WHERE `IdFlag` = :p0';
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
            $obj = new Flag();
            $obj->hydrate($row);
            FlagPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Flag|Flag[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Flag[]|mixed the list of results, formatted by the current formatter
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
     * @return FlagQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FlagPeer::IDFLAG, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return FlagQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FlagPeer::IDFLAG, $keys, Criteria::IN);
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
     * @param     mixed $idflag The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FlagQuery The current query, for fluid interface
     */
    public function filterByIdflag($idflag = null, $comparison = null)
    {
        if (is_array($idflag)) {
            $useMinMax = false;
            if (isset($idflag['min'])) {
                $this->addUsingAlias(FlagPeer::IDFLAG, $idflag['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idflag['max'])) {
                $this->addUsingAlias(FlagPeer::IDFLAG, $idflag['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FlagPeer::IDFLAG, $idflag, $comparison);
    }

    /**
     * Filter the query on the Name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE Name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE Name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FlagQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FlagPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query by a related Message object
     *
     * @param   Message|PropelObjectCollection $message  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FlagQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMessage($message, $comparison = null)
    {
        if ($message instanceof Message) {
            return $this
                ->addUsingAlias(FlagPeer::IDFLAG, $message->getIdflag(), $comparison);
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
     * @return FlagQuery The current query, for fluid interface
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
     * Filter the query by a related ReportStatus object
     *
     * @param   ReportStatus|PropelObjectCollection $reportStatus  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FlagQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByReportStatus($reportStatus, $comparison = null)
    {
        if ($reportStatus instanceof ReportStatus) {
            return $this
                ->addUsingAlias(FlagPeer::IDFLAG, $reportStatus->getIdflag(), $comparison);
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
     * @return FlagQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   Flag $flag Object to remove from the list of results
     *
     * @return FlagQuery The current query, for fluid interface
     */
    public function prune($flag = null)
    {
        if ($flag) {
            $this->addUsingAlias(FlagPeer::IDFLAG, $flag->getIdflag(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
