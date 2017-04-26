<?php

/**
 * Class TBD_Debug_Model_Resource_RequestInfo
 *
 * @category TBD
 * @package  TBD_Debug
 * @license  Copyright: Pirate TBD, 2016
 * @link     https://piratetbd.com
 */
class TBD_Debug_Model_Resource_RequestInfo extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Resource initialization
     */
    protected function _construct()
    {
        $this->_init('tbd_debug/request_info', 'id');
    }

}
