<?php

/**
 * Class TBD_Debug_Model_Query
 *
 * @category TBD
 * @package  TBD_Debug
 * @license  Copyright: Pirate TBD, 2016
 * @link     https://piratetbd.com
 */
class TBD_Debug_Model_Query
{
    protected $queryType;
    protected $query;
    protected $queryParams;
    protected $elapsedSecs;


    /**
     * TBD_Debug_Model_Query constructor.
     *
     * @param Zend_Db_Profiler_Query $profilerQuery
     */
    public function __construct(Zend_Db_Profiler_Query $profilerQuery)
    {
        $this->queryType = $profilerQuery->getQueryType();
        $this->query = $profilerQuery->getQuery();
        $this->queryParams = $profilerQuery->getQueryParams();
        $this->elapsedSecs = $profilerQuery->getElapsedSecs();
    }


    /**
     * Returns query type
     *
     * @return int
     */
    public function getQueryType()
    {
        return $this->queryType;
    }


    /**
     * Returns SQL query
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }


    /**
     * Returns SQL query parameters
     *
     * @return array
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }


    /**
     * Returns execution time in seconds
     *
     * @return false|float
     */
    public function getElapsedSecs()
    {
        return $this->elapsedSecs;
    }

}
