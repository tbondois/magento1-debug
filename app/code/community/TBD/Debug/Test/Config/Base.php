<?php

/**
 * Class TBD_Debug_Test_Config_Base
 *
 * @category TBD
 * @package  TBD_Debug
 * @license  Copyright: Pirate TBD, 2016
 * @link     https://piratetbd.com
 */
class TBD_Debug_Test_Config_Base extends EcomDev_PHPUnit_Test_Case_Config
{

    public function testModelAliases()
    {
        $this->assertModelAlias('tbd_debug/resourceInfo', 'TBD_Debug_Model_ResourceInfo');
        $this->assertModelAlias('core/email', 'TBD_Debug_Model_Core_Email');
        $this->assertModelAlias('core/email_template', 'TBD_Debug_Model_Core_Email_Template');
    }

    public function testSetup()
    {
        $this->assertSetupResourceDefined('TBD_Debug', 'tbd_debug_setup');
    }

    public function testBlocks()
    {
        $this->assertBlockAlias('tbd_debug/abstract', 'TBD_Debug_Block_Abstract');
    }

    public function testHelperAlias()
    {
        $this->assertHelperAlias('tbd_debug', 'TBD_Debug_Helper_Data');
    }

    public function testObservers()
    {
        $this->assertEventObserverDefined('global', 'controller_front_init_before', 'tbd_debug/observer', 'onControllerFrontInitBefore');
        $this->assertEventObserverDefined('global', 'controller_action_layout_generate_blocks_after', 'tbd_debug/observer', 'onLayoutGenerate');
        $this->assertEventObserverDefined('global', 'core_block_abstract_to_html_before', 'tbd_debug/observer', 'onBlockToHtml');
        $this->assertEventObserverDefined('global', 'core_block_abstract_to_html_after', 'tbd_debug/observer', 'onBlockToHtmlAfter');
        $this->assertEventObserverDefined('global', 'controller_action_postdispatch', 'tbd_debug/observer', 'onActionPostDispatch');
        $this->assertEventObserverDefined('global', 'core_collection_abstract_load_before', 'tbd_debug/observer', 'onCollectionLoad');
        $this->assertEventObserverDefined('global', 'eav_collection_abstract_load_before', 'tbd_debug/observer', 'onCollectionLoad');
        $this->assertEventObserverDefined('global', 'model_load_after', 'tbd_debug/observer', 'onModelLoad');
        $this->assertEventObserverDefined('global', 'controller_action_predispatch', 'tbd_debug/observer', 'onActionPreDispatch');
        $this->assertEventObserverDefined('global', 'controller_front_send_response_after', 'tbd_debug/observer', 'onControllerFrontSendResponseAfter');
    }

    public function testFrontend()
    {
        $this->assertRouteIn('tbd_debug');
        $this->assertLayoutFileDefined('frontend', 'tbd_debug.xml');
    }

    public function testAdmin()
    {
        $this->assertLayoutFileDefined('adminhtml', 'tbd_debug.xml');
    }

    public function testDefaultConfigs()
    {
        $this->assertDefaultConfigValue('tbd_debug/options/enable', 1);
        $this->assertDefaultConfigValue('tbd_debug/options/persist', 1);
        $this->assertDefaultConfigValue('tbd_debug/options/persist_expiration', 1);
        $this->assertDefaultConfigValue('tbd_debug/options/force_varien_profile', 1);
    }

}
