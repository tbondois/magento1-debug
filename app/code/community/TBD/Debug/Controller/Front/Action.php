<?php

/**
 * Class TBD_Debug_Controller_Front_Action
 *
 * @category TBD
 * @package  TBD_Debug
 * @license  Copyright: Pirate TBD, 2016
 * @link     https://piratetbd.com
 */
class TBD_Debug_Controller_Front_Action extends Mage_Core_Controller_Front_Action
{

    /**
     * Prevent access to our access if toolbar is disabled
     *
     * @throws Zend_Controller_Response_Exception
     */
    public function preDispatch()
    {
        parent::preDispatch();

        if (!Mage::helper('tbd_debug')->isAllowed()) {
            $this->setFlag('', 'no-dispatch', true);
            $this->getResponse()->setHttpResponseCode(404);
        }
    }


    /**
     * Returns current session
     *
     * @return Mage_Core_Model_Session
     */
    public function getSession()
    {
        return Mage::getSingleton('core/session');
    }


    /**
     * Returns an instance to our all known service
     *
     * @return TBD_Debug_Model_Service
     */
    public function getService()
    {
        return Mage::getModel('tbd_debug/service');
    }


    /**
     * Renders specified array
     *
     * @param array $data
     * @param string $noDataLabel   Label when array is empty.
     * @param null $header          An array with column label.
     * @return string
     */
    public function renderArray(array $data, $noDataLabel = 'No Data', $header = null)
    {
        /** @var TBD_Debug_Block_View $block */
        $block = $this->getLayout()->createBlock('tbd_debug/view');
        $html = $block->renderArray($data, $noDataLabel, $header);

        $this->getResponse()->setHttpResponseCode(200)->setBody($html);
    }


    /**
     * Renders specified table (array of arrays)
     *
     * @param array $data
     * @param array $fields
     * @param string $noDataLabel
     * @return string
     */
    public function renderTable(array $data, array $fields = array(), $noDataLabel = 'No Data')
    {
        /** @var TBD_Debug_Block_View $block */
        $block = $this->getLayout()->createBlock('tbd_debug/view');
        $html = $block->renderArrayFields($data, $fields, $noDataLabel);

        $this->getResponse()->setHttpResponseCode(200)->setBody($html);
    }

}
