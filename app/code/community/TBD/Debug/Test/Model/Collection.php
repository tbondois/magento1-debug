<?php

/**
 * Class TBD_Debug_Model_Test_Collection
 *
 * @category TBD
 * @package  TBD_Debug
 * @license  Copyright: Pirate TBD, 2016
 * @link     https://piratetbd.com
 *
 * @covers TBD_Debug_Model_Collection
 * @codeCoverageIgnore
 */
class TBD_Debug_Test_Model_Collection extends EcomDev_PHPUnit_Test_Case
{

    public function testConstruct()
    {
        $model = Mage::getModel('tbd_debug/collection');
        $this->assertNotFalse($model);
        $this->assertInstanceOf('TBD_Debug_Model_Collection', $model);
    }


    public function testInit()
    {
        $collection = $this->getMock('Varien_Data_Collection_Db', array('getSelectSql'));
        $collection->expects($this->once())->method('getSelectSql')->with(true)->willReturn('sql query');

        $model = Mage::getModel('tbd_debug/collection');
        $model->init($collection);

        $this->assertContains('Varien_Data_Collection_Db', $model->getClass());
        $this->assertEquals('flat', $model->getType());
        $this->assertEquals('sql query', $model->getQuery());
        $this->assertEquals(0, $model->getCount());
    }


    public function testIncrementCount()
    {
        $model = Mage::getModel('tbd_debug/collection');
        $this->assertEquals(0, $model->getCount());

        $model->incrementCount();
        $this->assertEquals(1, $model->getCount());

        $model->incrementCount();
        $this->assertEquals(2, $model->getCount());
    }

}
