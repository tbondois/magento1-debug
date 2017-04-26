<?php

/**
 * Class TBD_Debug_Block_Logging
 *
 * @category TBD
 * @package  TBD_Debug
 * @license  Copyright: Pirate TBD, 2016
 * @link     https://piratetbd.com
 */
class TBD_Debug_Block_Logging extends TBD_Debug_Block_Panel
{
    protected $logLineCount = null;

    /**
     * @return TBD_Debug_Model_Logging
     */
    public function getLogging()
    {
        return $this->getRequestInfo()->getLogging();
    }


    /**
     * Returns an array with all registered log file names
     *
     * @return array
     */
    public function getLogFiles()
    {
        return $this->getLogging()->getFiles();
    }

}
