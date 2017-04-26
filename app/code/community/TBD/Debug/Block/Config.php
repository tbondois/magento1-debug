<?php

/**
 * Class TBD_Debug_Block_Config
 *
 * @category TBD
 * @package  TBD_Debug
 * @license  Copyright: Pirate TBD, 2016
 * @link     https://piratetbd.com
 */
class TBD_Debug_Block_Config extends TBD_Debug_Block_Panel
{

    /**
     * Returns version for Magento
     *
     * @return string
     */
    public function getMagentoVersion()
    {
        return Mage::helper('tbd_debug/config')->getMagentoVersion();
    }


    /**
     * Checks if Magento Developer Mode is enabled
     *
     * @return bool
     */
    public function isDeveloperMode()
    {
        return $this->helper->getIsDeveloperMode();
    }


    /**
     * Returns an array with statuses for PHP extensions required by Magento
     *
     * @return array
     */
    public function getExtensionStatus()
    {
        return Mage::helper('tbd_debug/config')->getExtensionStatus();
    }


    /**
     * Returns a string representation for current store (website name and store name)
     *
     * @return string
     */
    public function getCurrentStore()
    {
        $currentStore = $this->_getApp()->getStore();
        return sprintf('%s / %s', $currentStore->getWebsite()->getName(),  $currentStore->getName());
    }

}
