<?php

/**
 * Class TBD_Debug_Block_Toolbar
 *
 * @category TBD
 * @package  TBD_Debug
 * @license  Copyright: Pirate TBD, 2016
 * @link     https://piratetbd.com
 */
class TBD_Debug_Block_Toolbar extends TBD_Debug_Block_Abstract
{
    /** @var  TBD_Debug_Block_Panel[] */
    protected $visiblePanels;

    /**
     * Render toolbar only if request is allowed
     *
     * @return string
     */
    public function renderView()
    {
        // Render Debug toolbar only if allowed
        if (!$this->helper->canShowToolbar()) {
            return '';
        }

        return parent::renderView();
    }


    /**
     * Returns TBD Debug module version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->helper->getModuleVersion();
    }


    /**
     * Returns sorted visible debug panels
     *
     * @return TBD_Debug_Block_Panel[]
     */
    public function getVisiblePanels()
    {
        if ($this->visiblePanels === null) {
            $this->visiblePanels = array();

            $panels = $this->getSortedChildBlocks();
            foreach ($panels as $panel) {
                if (!$panel instanceof TBD_Debug_Block_Panel) {
                    continue;
                }

                $this->visiblePanels[] = $panel;
            }
        }
        return $this->visiblePanels;
    }

}
