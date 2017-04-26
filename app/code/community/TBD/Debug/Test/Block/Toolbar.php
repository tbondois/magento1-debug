<?php

/**
 * Class TBD_Debug_Test_Block_Toolbar
 *
 * @category TBD
 * @package  TBD_Debug
 * @license  Copyright: Pirate TBD, 2016
 * @link     https://piratetbd.com
 *
 * @covers TBD_Debug_Block_Toolbar
 * @codeCoverageIgnore
 */
class TBD_Debug_Test_Block_Toolbar extends EcomDev_PHPUnit_Test_Case
{

    public function testRenderView()
    {
        $helper = $this->getModelMock('tbd_debug', array('canShowToolbar'));
        $helper->expects($this->any())->method('canShowToolbar')->willReturn(true);
        $this->replaceByMock('helper', 'tbd_debug', $helper);

        $block = $this->getBlockMock('tbd_debug/toolbar', array('fetchView'));
        $block->expects($this->once())->method('fetchView')->willReturn('content');

        $actual = $block->renderView();
        $this->assertEquals('content', $actual);
    }


    public function testRenderViewWithoutPermissions()
    {
        $helper = $this->getModelMock('tbd_debug', array('canShowToolbar'));
        $helper->expects($this->any())->method('canShowToolbar')->willReturn(false);
        $this->replaceByMock('helper', 'tbd_debug', $helper);

        $block = $this->getBlockMock('tbd_debug/toolbar', array('fetchView'));
        $block->expects($this->never())->method('fetchView')->willReturn('content');

        $actual = $block->renderView();
        $this->assertEquals('', $actual);
    }


    public function testGetVersion()
    {
        $helper = $this->getModelMock('tbd_debug', array('getModuleVersion'));
        $helper->expects($this->any())->method('getModuleVersion')->willReturn('1.2.3');
        $this->replaceByMock('helper', 'tbd_debug', $helper);

        $block = $this->getBlockMock('tbd_debug/toolbar', array('fetchView'));

        $actual = $block->getVersion();
        $this->assertEquals('1.2.3', $actual);
    }

    public function testGetVisiblePanels()
    {
        $block = $this->getBlockMock('tbd_debug/toolbar', array('getSortedChildBlocks'));
        $block->expects($this->once())->method('getSortedChildBlocks')->willReturn(array(
            $this->getBlockMock('core/template'),
            $this->getBlockMock('tbd_debug/panel'),
            $this->getBlockMock('tbd_debug/panel')
        ));

        $actual = $block->getVisiblePanels();
        $this->assertNotNull($actual);
        $this->assertCount(2, $actual);

        $actual = $block->getVisiblePanels();
        $this->assertCount(2, $actual);
    }
}
