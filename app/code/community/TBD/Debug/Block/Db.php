<?php

/**
 * Class TBD_Debug_Block_Models
 *
 * @category TBD
 * @package  TBD_Debug
 * @license  Copyright: Pirate TBD, 2016
 * @link     https://piratetbd.com
 */
class TBD_Debug_Block_Db extends TBD_Debug_Block_Panel
{

    /**
     * Checks if SQL Profiler is enabled
     *
     * @return bool
     */
    public function isSqlProfilerEnabled()
    {
        return $this->helper->getSqlProfiler()->getEnabled();
    }

}
