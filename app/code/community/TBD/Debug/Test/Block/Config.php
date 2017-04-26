<?php

/**
 * Class TBD_Debug_Test_Block_Config
 *
 * @category TBD
 * @package  TBD_Debug
 * @license  Copyright: Pirate TBD, 2016
 * @link     https://piratetbd.com
 *
 * @covers TBD_Debug_Block_Config
 * @codeCoverageIgnore
 */
class TBD_Debug_Test_Block_Config extends EcomDev_PHPUnit_Test_Case
{

    public function testGetMagentoVersion()
    {
        $helper = $this->getHelperMock('tbd_debug/config', array('getMagentoVersion'));
        $helper->expects($this->once())->method('getMagentoVersion')->willReturn('1.2.3');
        $this->replaceByMock('helper', 'tbd_debug/config', $helper);

        $block = $this->getBlockMock('tbd_debug/config', array('toHtml'));
        $actual = $block->getMagentoVersion();
        $this->assertEquals('1.2.3', $actual);
    }


    public function testGetIsDeveloperMode()
    {
        $helper = $this->getHelperMock('tbd_debug', array('getIsDeveloperMode'));
        $helper->expects($this->once())->method('getIsDeveloperMode')->willReturn(true);
        $this->replaceByMock('helper', 'tbd_debug', $helper);

        $block = $this->getBlockMock('tbd_debug/config', array('toHtml'));
        $actual = $block->isDeveloperMode();
        $this->assertTrue($actual);
    }


    public function testGetExtensionStatus()
    {
        $helper = $this->getHelperMock('tbd_debug/config', array('getExtensionStatus'));
        $helper->expects($this->once())->method('getExtensionStatus')
            ->willReturn(array('xdebug' => true, 'mcrypt' => false));
        $this->replaceByMock('helper', 'tbd_debug/config', $helper);

        $block = $this->getBlockMock('tbd_debug/config', array('toHtml'));
        $actual = $block->getExtensionStatus();
        $this->assertCount(2, $actual);
        $this->assertArrayHasKey('xdebug', $actual);
        $this->assertTrue($actual['xdebug']);
        $this->assertArrayHasKey('mcrypt', $actual);
        $this->assertFalse($actual['mcrypt']);
    }


    public function testGetCurrentStore()
    {
        $website = $this->getModelMock('core/website', array('getName'));
        $website->expects($this->any())->method('getName')->willReturn('My Website');

        $store = $this->getModelMock('core/store', array('getWebsite', 'getName'));
        $store->expects($this->any())->method('getWebsite')->willReturn($website);
        $store->expects($this->any())->method('getName')->willReturn('My Store');

        $app = $this->getModelMock('core/app', array('getStore'));
        $app->expects($this->any())->method('getStore')->willReturn($store);

        $block = $this->getBlockMock('tbd_debug/config', array('_getApp'));
        $block->expects($this->any())->method('_getApp')->willReturn($app);
        $actual = $block->getCurrentStore();

        $this->assertEquals('My Website / My Store', $actual);
    }

}
