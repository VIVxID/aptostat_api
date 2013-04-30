<?php


/**
 * Base class that represents a query for the 'Message' table.
 *
 *
 *
 * @method MessageQuery orderByIdmessage($order = Criteria::ASC) Order by the IdMessage column
 * @method MessageQuery orderByIdincident($order = Criteria::ASC) Order by the IdIncident column
 * @method MessageQuery orderByFlag($order = Criteria::ASC) Order by the Flag column
 * @method MessageQuery orderByTimestamp($order = Criteria::ASC) Order by the Timestamp column
 * @method MessageQuery orderByText($order = Criteria::ASC) Order by the Text column
 * @method MessageQuery orderByAuthor($order = Criteria::ASC) Order by the Author column
 * @method MessageQuery orderByHidden($order = Criteria::ASC) Order by the Hidden column
 *
 * @method MessageQuery groupByIdmessage() Group by the IdMessage column
 * @method MessageQuery groupByIdincident() Group by the IdIncident column
 * @method MessageQuery groupByFlag() Group by the Flag column
 * @method MessageQuery groupByTimestamp() Group by the Timestamp column
 * @method MessageQuery groupByText() Group by the Text column
 * @method MessageQuery groupByAuthor() Group by the Author column
 * @method MessageQuery groupByHidden() Group by the Hidden column
 *
 * @method MessageQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method MessageQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method MessageQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method MessageQuery leftJoinIncident($relationAlias = null) Adds a LEFT JOIN clause to the query using the Incident relation
 * @method MessageQuery rightJoinIncident($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Incident relation
 * @method MessageQuery innerJoinIncident($relationAlias = null) Adds a INNER JOIN clause to the query using the Incident relation
 *
 * @method Message findOne(PropelPDO $con = null) Return the first Message matching the query
 * @method Message findOneOrCreate(PropelPDO $con = null) Return the first Message matching the query, or a new Message object populated from the query conditions when no match is found
 *
 * @method Message findOneByIdincident(int $IdIncident) Return the first Message filtered by the IdIncident column
 * @method Message findOneByFlag(string $Flag) Return the first Message filtered by the Flag column
 * @method Message findOneByTimestamp(string $Timestamp) Return the first Message filtered by the Timestamp column
 * @method Message findOneByText(string $Text) Return the first Message filtered by the Text column
 * @method Message findOneByAuthor(string $Author) Return the first Message filtered by the Author column
 * @method Message findOneByHidden(boolean $Hidden) Return the first Message filtered by the Hidden column
 *
 * @method array findByIdmessage(int $IdMessage) Return Message objects filtered by the IdMessage column
 * @method array findByIdincident(int $IdIncident) Return Message objects filtered by the IdIncident column
 * @method array findByFlag(string $Flag) Return Message objects filtered by the Flag column
 * @method array findByTimestamp(string $Timestamp) Return Message objects filtered by the Timestamp column
 * @method array findByText(string $Text) Return Message objects filtered by the Text column
 * @method array findByAuthor(string $Author) Return Message objects filtered by the Author column
 * @method array findByHidden(boolean $Hidden) Return Message objects filtered by the Hidden column
 *
 * @package    propel.generator.aptostat_api.om
 */
abstract class BaseMessageQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseMessageQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'aptostat', $modelName = 'Message', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new MessageQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   MessageQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return MessageQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof MessageQuery) {
            return $criteria;
        }
        $query = new MessageQuery();
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
     * @return   Message|Message[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MessagePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(MessagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Message A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByIdmessage($key, $con = null)
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
     * @return                 Message A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `IdMessage`, `IdIncident`, `Flag`, `Timestamp`, `Text`, `Author`, `Hidden` FROM `Message` WHERE `IdMessage` = :p0';
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
            $obj = new Message();
            $obj->hydrate($row);
            MessagePeer::addInstanceToPool($obj, (string) $key);
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
     * @return Message|Message[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Message[]|mixed the list of results, formatted by the current formatter
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
     * @return MessageQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MessagePeer::IDMESSAGE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return MessageQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MessagePeer::IDMESSAGE, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the IdMessage column
     *
     * Example usage:
     * <code>
     * $query->filterByIdmessage(1234); // WHERE IdMessage = 1234
     * $query->filterByIdmessage(array(12, 34)); // WHERE IdMessage IN (12, 34)
     * $query->filterByIdmessage(array('min' => 12)); // WHERE IdMessage >= 12
     * $query->filterByIdmessage(array('max' => 12)); // WHERE IdMessage <= 12
     * </code>
     *
     * @param     mixed $idmessage The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MessageQuery The current query, for fluid interface
     */
    public function filterByIdmessage($idmessage = null, $comparison = null)
    {
        if (is_array($idmessage)) {
            $useMinMax = false;
            if (isset($idmessage['min'])) {
                $this->addUsingAlias(MessagePeer::IDMESSAGE, $idmessage['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idmessage['max'])) {
                $this->addUsingAlias(MessagePeer::IDMESSAGE, $idmessage['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagePeer::IDMESSAGE, $idmessage, $comparison);
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
     * @return MessageQuery The current query, for fluid interface
     */
    public function filterByIdincident($idincident = null, $comparison = null)
    {
        if (is_array($idincident)) {
            $useMinMax = false;
            if (isset($idincident['min'])) {
                $this->addUsingAlias(MessagePeer::IDINCIDENT, $idincident['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idincident['max'])) {
                $this->addUsingAlias(MessagePeer::IDINCIDENT, $idincident['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagePeer::IDINCIDENT, $idincident, $comparison);
    }

    /**
     * Filter the query on the Flag column
     *
     * Example usage:
     * <code>
     * $query->filterByFlag('fooValue');   // WHERE Flag = 'fooValue'
     * $query->filterByFlag('%fooValue%'); // WHERE Flag LIKE '%fooValue%'
     * </code>
     *
     * @param     string $flag The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MessageQuery The current query, for fluid interface
     */
    public function filterByFlag($flag = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($flag)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $flag)) {
                $flag = str_replace('*', '%', $flag);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MessagePeer::FLAG, $flag, $comparison);
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
     * @return MessageQuery The current query, for fluid interface
     */
    public function filterByTimestamp($timestamp = null, $comparison = null)
    {
        if (is_array($timestamp)) {
            $useMinMax = false;
            if (isset($timestamp['min'])) {
                $this->addUsingAlias(MessagePeer::TIMESTAMP, $timestamp['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timestamp['max'])) {
                $this->addUsingAlias(MessagePeer::TIMESTAMP, $timestamp['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagePeer::TIMESTAMP, $timestamp, $comparison);
    }

    /**
     * Filter the query on the Text column
     *
     * Example usage:
     * <code>
     * $query->filterByText('fooValue');   // WHERE Text = 'fooValue'
     * $query->filterByText('%fooValue%'); // WHERE Text LIKE '%fooValue%'
     * </code>
     *
     * @param     string $text The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MessageQuery The current query, for fluid interface
     */
    public function filterByText($text = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($text)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $text)) {
                $text = str_replace('*', '%', $text);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MessagePeer::TEXT, $text, $comparison);
    }

    /**
     * Filter the query on the Author column
     *
     * Example usage:
     * <code>
     * $query->filterByAuthor('fooValue');   // WHERE Author = 'fooValue'
     * $query->filterByAuthor('%fooValue%'); // WHERE Author LIKE '%fooValue%'
     * </code>
     *
     * @param     string $author The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MessageQuery The current query, for fluid interface
     */
    public function filterByAuthor($author = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($author)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $author)) {
                $author = str_replace('*', '%', $author);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MessagePeer::AUTHOR, $author, $comparison);
    }

    /**
     * Filter the query on the Hidden column
     *
     * Example usage:
     * <code>
     * $query->filterByHidden(true); // WHERE Hidden = true
     * $query->filterByHidden('yes'); // WHERE Hidden = true
     * </code>
     *
     * @param     boolean|string $hidden The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MessageQuery The current query, for fluid interface
     */
    public function filterByHidden($hidden = null, $comparison = null)
    {
        if (is_string($hidden)) {
            $hidden = in_array(strtolower($hidden), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(MessagePeer::HIDDEN, $hidden, $comparison);
    }

    /**
     * Filter the query by a related Incident object
     *
     * @param   Incident|PropelObjectCollection $incident The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MessageQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByIncident($incident, $comparison = null)
    {
        if ($incident instanceof Incident) {
            return $this
                ->addUsingAlias(MessagePeer::IDINCIDENT, $incident->getIdincident(), $comparison);
        } elseif ($incident instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MessagePeer::IDINCIDENT, $incident->toKeyValue('PrimaryKey', 'Idincident'), $comparison);
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
     * @return MessageQuery The current query, for fluid interface
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
     * @param   Message $message Object to remove from the list of results
     *
     * @return MessageQuery The current query, for fluid interface
     */
    public function prune($message = null)
    {
        if ($message) {
            $this->addUsingAlias(MessagePeer::IDMESSAGE, $message->getIdmessage(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
