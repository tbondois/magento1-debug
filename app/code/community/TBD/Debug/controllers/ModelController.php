<?php

/**
 * Class TBD_Debug_ModelController
 *
 * @category TBD
 * @package  TBD_Debug
 * @license  Copyright: Pirate TBD, 2016
 * @link     https://piratetbd.com
 */
class TBD_Debug_ModelController extends TBD_Debug_Controller_Front_Action
{

    /**
     * Enable SQL profiler
     */
    public function enableSqlProfilerAction()
    {
        try {
            $this->getService()->setSqlProfilerStatus(true);
            $this->getService()->flushCache();

            Mage::getSingleton('core/session')->addSuccess('SQL profiler was enabled.');
        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError('Unable to enable SQL profiler: ' . $e->getMessage());
        }

        $this->_redirectReferer();
    }


    /**
     * Disable SQL profiler
     */
    public function disableSqlProfilerAction()
    {
        try {
            $this->getService()->setSqlProfilerStatus(false);
            $this->getService()->flushCache();

            Mage::getSingleton('core/session')->addSuccess('SQL profiler was disabled.');
        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError('Unable to disable SQL profiler: ' . $e->getMessage());
        }

        $this->_redirectReferer();
    }


    /**
     * Runs specified SQL
     */
    public function selectSqlAction()
    {
        if ($query = $this->_initQuery()) {
            $helper = Mage::helper('tbd_debug');
            $results = $helper->runSql($query->getQuery(), $query->getQueryParams());
            $this->renderTable($results);
        }
    }


    /**
     * Runs DESCRIBE for specified SQL
     */
    public function describeSqlAction()
    {
        if ($query = $this->_initQuery()) {
            $helper = Mage::helper('tbd_debug');
            $results = $helper->runSql('EXPLAIN EXTENDED ' . $query->getQuery(), $query->getQueryParams());
            $this->renderTable($results);
        }
    }


    /**
     * Returns query referenced in request parameters
     *
     * @return Zend_Db_Profiler_Query
     */
    protected function _initQuery()
    {
        $token = $this->getRequest()->getParam('token');
        $index = $this->getRequest()->getParam('index');

        if ($token === null || $index === null) {
            $this->getResponse()->setHttpResponseCode(400)->setBody('Invalid parameters');
            return null;
        }

        /** @var TBD_Debug_Model_RequestInfo $requestProfile */
        $requestProfile = Mage::getModel('tbd_debug/requestInfo')->load($token, 'token');
        if (!$requestProfile->getId()) {
            $this->getResponse()->setHttpResponseCode(404)->setBody('Request profile not found');
            return null;
        }

        $queries = $requestProfile->getQueries();
        if (!$queries || !($index < count($queries))) {
            $this->getResponse()->setHttpResponseCode(404)->setBody('Query not found');
            return null;
        }

        /** @var Zend_Db_Profiler_Query $query */
        return $queries[(int)$index];
    }

}
