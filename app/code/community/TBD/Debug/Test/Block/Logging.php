<?php

/**
 * Class TBD_Debug_Test_Block_Logging
 *
 * @category TBD
 * @package  TBD_Debug
 * @license  Copyright: Pirate TBD, 2016
 * @link     https://piratetbd.com
 *
 * @covers TBD_Debug_Block_Logging
 * @codeCoverageIgnore
 */
class TBD_Debug_Test_Block_Logging extends EcomDev_PHPUnit_Test_Case
{

    public function testGetLogging()
    {
        $logging = $this->getModelMock('tbd_debug/logging', array('getFiles'), false, array(), '', false);
        $requestInfo = $this->getModelMock('tbd_debug/requestInfo', array('getLogging'));
        $requestInfo->expects($this->any())->method('getLogging')->willReturn($logging);

        $block = $this->getBlockMock('tbd_debug/logging', array('getRequestInfo'));
        $block->expects($this->any())->method('getRequestInfo')->willReturn($requestInfo);

        $actual = $block->getLogging();
        $this->assertNotNull($logging);
        $this->assertEquals($logging, $actual);
    }


    public function testLogFiles()
    {
        $logging = $this->getModelMock('tbd_debug/logging', array('getFiles'), false, array(), '', false);
        $logging->expects($this->once())->method('getFiles')->willReturn(array('a', 'b'));

        $block = $this->getBlockMock('tbd_debug/logging', array('getLogging'));
        $block->expects($this->any())->method('getLogging')->willReturn($logging);

        $actual = $block->getLogFiles();
        $this->assertNotNull($actual);
        $this->assertCount(2, $actual);
        $this->assertEquals(array('a', 'b'), $actual);
    }

}
