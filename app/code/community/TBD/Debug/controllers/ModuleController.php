<?php

/**
 * Class TBD_Debug_ModuleController
 *
 * @category TBD
 * @package  TBD_Debug
 * @license  Copyright: Pirate TBD, 2016
 * @link     https://piratetbd.com
 */
class TBD_Debug_ModuleController extends TBD_Debug_Controller_Front_Action
{

    /**
     * Enables specified module
     */
    public function enableAction()
    {
        $moduleName = (string)$this->getRequest()->getParam('module');

        try {
            $this->getService()->setModuleStatus($moduleName, true);
            $this->getService()->flushCache();
            Mage::getSingleton('core/session')->addSuccess('Module was enabled.');
        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError('Unable to enable module: ' . $e->getMessage());
        }

        $this->_redirectReferer();
    }


    /**
     * Disables specified module
     */
    public function disableAction()
    {

        $moduleName = (string)$this->getRequest()->getParam('module');

        try {
            $this->getService()->setModuleStatus($moduleName, false);
            $this->getService()->flushCache();
            Mage::getSingleton('core/session')->addSuccess('Module was disabled.');
        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError('Unable to disable module: ' . $e->getMessage());
        }

        $this->_redirectReferer();
    }

}
