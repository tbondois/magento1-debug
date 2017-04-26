<?php

/**
 * Class TBD_Debug_Block_View_Sidebar
 *
 * @category TBD
 * @package  TBD_Debug
 * @license  Copyright: Pirate TBD, 2016
 * @link     https://piratetbd.com
 */
class TBD_Debug_Block_View_Sidebar extends TBD_Debug_Block_View
{

    /**
     * Returns available http method filters
     *
     * @return array
     */
    public function getHttpMethodOptions()
    {
        return $this->getOptionArray(Mage::helper('tbd_debug/filter')->getHttpMethodValues());
    }


    /**
     * Returns html for http methods select
     *
     * @return string
     * @throws Exception
     */
    public function getHttpMethodsSelect()
    {
        $options = $this->getHttpMethodOptions();
        array_unshift($options, array('value' => '', 'label' => 'Any'));

        /** @var Mage_Core_Block_Html_Select $select */
        $select = $this->getLayout()->createBlock('core/html_select');

        $select->setName('method')
            ->setId('method')
            ->setValue($this->getRequest()->getParam('method'))
            ->setOptions($options);

        return $select->getHtml();
    }


    /**
     * Returns html for limit selects
     *
     * @return string
     * @throws Exception
     */
    public function getLimitOptionsSelect()
    {
        /** @var TBD_Debug_Helper_Filter $filterHelper */
        $filterHelper = Mage::helper('tbd_debug/filter');

        /** @var Mage_Core_Block_Html_Select $select */
        $select = $this->getLayout()->createBlock('core/html_select');

        $select->setName('limit')
            ->setId('limit')
            ->setValue($this->getRequest()->getParam('limit', $filterHelper->getLimitDefaultValue()))
            ->setOptions($this->getOptionArray($filterHelper->getLimitValues()));

        return $select->getHtml();
    }

}
