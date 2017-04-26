<?php

/**
 * Class TBD_Debug_Test_Block_Db
 *
 * @category TBD
 * @package  TBD_Debug
 * @license  Copyright: Pirate TBD, 2016
 * @link     https://piratetbd.com
 *
 * @covers TBD_Debug_Block_Db
 * @codeCoverageIgnore
 */
class TBD_Debug_Test_Block_Db extends EcomDev_PHPUnit_Test_Case
{

    public function testIsSqlProfilerEnabled()
    {
        $profiler = $this->getMock('Zend_Db_Profiler', array('getEnabled'));
        $profiler->expects($this->once())->method('getEnabled')->willReturn(true);

        $helper = $this->getHelperMock('tbd_debug', array('getSqlProfiler'));
        $helper->expects($this->once())->method('getSqlProfiler')->willReturn($profiler);
        $this->replaceByMock('helper', 'tbd_debug', $helper);

        $block = $this->getBlockMock('tbd_debug/db', array('toHtml'));
        $this->assertTrue($block->isSqlProfilerEnabled());
    }

}
