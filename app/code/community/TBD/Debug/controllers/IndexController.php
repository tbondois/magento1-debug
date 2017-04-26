<?php

/**
 * Class TBD_Debug_IndexController
 *
 * @category TBD
 * @package  TBD_Debug
 * @license  Copyright: Pirate TBD, 2016
 * @link     https://piratetbd.com
 */
class TBD_Debug_IndexController extends TBD_Debug_Controller_Front_Action
{

    /**
     * Request profile index page
     */
    public function indexAction()
    {
        $this->_forward('search');
    }


    /**
     * View request profile list
     */
    public function searchAction()
    {
        /** @var TBD_Debug_Model_Resource_RequestInfo_Collection $requests */
        $requests = $this->_getFilteredRequests();

        $this->loadLayout('tbd_debug');
        /** @var Mage_Page_Block_Html $rootBlock */
        $rootBlock = $this->getLayout()->getBlock('root');
        $rootBlock->setHeaderTitle($this->__('Request profiles'));

        /** @var TBD_Debug_Block_View $profileListBlock */
        $profileListBlock = $this->getLayout()->getBlock('tbd_debug_list');
        $profileListBlock->setData('results', $requests);

        $this->renderLayout();
    }


    /**
     * View latest request profile
     */
    public function latestAction()
    {
        /** @var TBD_Debug_Model_Resource_RequestInfo_Collection $profileRequests */
        $profileRequests = Mage::getModel('tbd_debug/requestInfo')->getCollection();
        $profileRequests->addOrder('id', Varien_Data_Collection_Db::SORT_ORDER_DESC);
        $profileRequests->setCurPage(1)->setPageSize(1);

        /** @var TBD_Debug_Model_RequestInfo $lastProfileRequest */
        $lastProfileRequest = $profileRequests->getFirstItem();

        $this->_forward('view', null, null, array('token' => $lastProfileRequest->getToken()));
    }


    /**
     * View request profile page
     */
    public function viewAction()
    {
        $token = (string)$this->getRequest()->getParam('token');
        if (!$token) {
            $this->getResponse()->setHttpResponseCode(400);
            return $this->_getRefererUrl();
        }

        /** @var TBD_Debug_Model_RequestInfo $requestInfo */
        $requestInfo = Mage::getModel('tbd_debug/requestInfo')->load($token, 'token');
        if (!$requestInfo->getId()) {
            $this->getResponse()->setHttpResponseCode(404);
            return $this->_getRefererUrl();
        }

        $section = $this->getRequest()->getParam('panel', 'request');
        if (!in_array($section, array('request', 'performance', 'events', 'db', 'logging', 'email', 'layout', 'config'))) {
            $section = 'request';
        }

        Mage::register('tbd_debug_request_info', $requestInfo);

        $blockName = 'tbd_debug_' . $section;
        $blockTemplate = "tbd_debug/view/panel/{$section}.phtml";

        // Add section block to content area
        $this->loadLayout();
        $layout = $this->getLayout();
        $sectionBlock = $layout->createBlock('tbd_debug/view', $blockName, array('template' => $blockTemplate));
        $layout->getBlock('tbd_debug_content')->insert($sectionBlock);

        $layout->getBlock('root')->setHeaderTitle($this->__('Profile for request %s (%s)', $requestInfo->getRequestPath(), $requestInfo->getToken()));

        $this->renderLayout();
    }


    /**
     * Returns lines from log file
     */
    public function viewLogAction()
    {
        $token = $this->getRequest()->getParam('token');
        $log = $this->getRequest()->getParam('log');

        if (!$token || !$log) {
            $this->getResponse()->setHttpResponseCode(400)->setBody('Invalid parameters');
            return;
        }

        /** @var TBD_Debug_Model_RequestInfo $requestProfile */
        $requestProfile = Mage::getModel('tbd_debug/requestInfo')->load($token, 'token');
        if (!$requestProfile->getId()) {
            $this->getResponse()->setHttpResponseCode(404)->setBody('Request profile not found');
            return;
        }

        try {
            $content = $requestProfile->getLogging()->getLoggedContent($log);
            $this->getResponse()->setHttpResponseCode(200)->setBody($content);
        } catch (Exception $e) {
            $this->getResponse()->setHttpResponseCode(200)->setBody('Unable to retrieve logged content');
        }
    }


    /**
     * Deletes all request profiles
     */
    public function purgeProfilesAction()
    {
        $count = $this->getService()->purgeAllProfiles();
        $this->getSession()->addSuccess($this->__('%d request profiles were deleted', $count));

        $this->_redirect('/');
    }


    /**
     * Initialise request profile collection based on filters set on request
     *
     * @return TBD_Debug_Model_Resource_RequestInfo_Collection
     */
    protected function _getFilteredRequests()
    {
        /** @var TBD_Debug_Model_Resource_RequestInfo_Collection $requests */
        $requests = Mage::getModel('tbd_debug/requestInfo')->getCollection();
        $requests->setCurPage(1);
        $requests->setPageSize(Mage::helper('tbd_debug/filter')->getLimitDefaultValue());

        if ($sessionId = $this->getRequest()->getParam('session_id')) {
            $requests->addSessionIdFilter($sessionId);
        }

        if ($ip = $this->getRequest()->getParam('ip')) {
            $requests->addIpFilter($ip);
        }

        if ($method = $this->getRequest()->getParam('method')) {
            $requests->addHttpMethodFilter($method);
        }

        if ($limit = $this->getRequest()->getParam('limit')) {
            $requests->setPageSize($limit);
        }

        if ($path = $this->getRequest()->getParam('path')) {
            $requests->addRequestPathFilter($path);
        }

        if ($token = $this->getRequest()->getParam('token')) {
            $requests->addTokenFilter($token);
        }

        if ($startDate = $this->getRequest()->getParam('start')) {
            $requests->addAfterFilter($startDate);
        }

        if ($endDate = $this->getRequest()->getParam('end')) {
            $requests->addEarlierFilter($endDate);
        }

        if ($page = (int)$this->getRequest()->getParam('page')) {
            $requests->setCurPage($page);
        }

        $requests->addOrder('id', Varien_Data_Collection_Db::SORT_ORDER_DESC);

        return $requests;
    }

}
