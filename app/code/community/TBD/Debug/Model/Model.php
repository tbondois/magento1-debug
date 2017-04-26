<?php

/**
 * Class TBD_Debug_Model_Model
 *
 * @category TBD
 * @package  TBD_Debug
 * @license  Copyright: Pirate TBD, 2016
 * @link     https://piratetbd.com
 */
class TBD_Debug_Model_Model
{
    protected $class;
    protected $resource;
    protected $count;


    /**
     * Captures information about specified model
     *
     * @param Mage_Core_Model_Abstract $model
     */
    public function init(Mage_Core_Model_Abstract $model)
    {
        $this->class = get_class($model);
        $this->resource = $model->getResourceName();
        $this->count = 0;
    }


    /**
     * Returns model's class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }


    /**
     * Increments number of times this model was loaded
     */
    public function incrementCount()
    {
        $this->count++;
    }


    /**
     * Returns model's resource name
     *
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }


    /**
     * Returns model's number of loads
     *
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

}
