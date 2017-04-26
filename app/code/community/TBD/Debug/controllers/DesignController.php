<?php

/**
 * Class TBD_Debug_DesignController
 *
 * @category TBD
 * @package  TBD_Debug
 * @license  Copyright: Pirate TBD, 2016
 * @link     https://piratetbd.com
 */
class TBD_Debug_DesignController extends TBD_Debug_Controller_Front_Action
{

    /**
     * View layout handle details
     */
    public function viewHandleAction()
    {
        $area = $this->getRequest()->getParam('area');
        $storeId = (int)$this->getRequest()->getParam('store');
        $handle = $this->getRequest()->getParam('handle');

        $updatesByFile = $this->getService()->getFileUpdatesWithHandle($handle, $storeId, $area);
        $databaseUpdates = $this->getService()->getDatabaseUpdatesWithHandle($handle, $storeId, $area);

        $block = $this->getLayout()->createBlock('tbd_debug/view', '', array(
            'template' => 'tbd_debug/view/panel/_layout_updates.phtml',
            'file_updates' => $updatesByFile,
            'db_updates' => $databaseUpdates
        ));

        $this->getResponse()->setBody($block->toHtml());
    }


    /**
     * Returns layout handles for specified request profile
     */
    public function layoutUpdatesAction()
    {
        $token = $this->getRequest()->getParam('token');
        if (!$token) {
            return $this->getResponse()->setHttpResponseCode(400)->setBody('Invalid parameters');
        }

        /** @var TBD_Debug_Model_RequestInfo $requestProfile */
        $requestProfile = Mage::getModel('tbd_debug/requestInfo')->load($token, 'token');
        if (!$requestProfile->getId()) {
            return $this->getResponse()->setHttpResponseCode(404)->setBody('Request profile not found');
        }

        $layoutUpdates = $requestProfile->getDesign()->getLayoutUpdates();
        $this->renderArray($layoutUpdates, 'No Data', array('#', 'XML'));
    }

}
