<?php

/**
 * Class TBD_Debug_Test_Model_Email
 *
 * @category TBD
 * @package  TBD_Subscription
 * @license  Copyright: Pirate TBD, 2016
 * @link     https://piratetbd.com
 *
 * @covers TBD_Debug_Model_Email
 * @codeCoverageIgnore
 */
class TBD_Debug_Test_Model_Email extends EcomDev_PHPUnit_Test_Case
{

    public function testSetters()
    {
        $model = Mage::getModel('tbd_debug/email');

        $model->setFromEmail('mario@mailinator.com');
        $this->assertEquals('mario@mailinator.com', $model->getFromEmail());

        $model->setFromName('Mario O');
        $this->assertEquals('Mario O', $model->getFromName());

        $model->setToEmail('mario+to@mailinator.com');
        $this->assertEquals('mario+to@mailinator.com', $model->getToEmail());

        $model->setToName('Mario To');
        $this->assertEquals('Mario To', $model->getToName());

        $model->setSubject('Some subject');
        $this->assertEquals('Some subject', $model->getSubject());

        $model->setIsPlain(true);
        $this->assertTrue($model->getIsPlain());

        $model->setBody('e-mail body');
        $this->assertEquals('e-mail body', $model->getBody());

        $model->setIsSmtpDisabled(false);
        $this->assertFalse($model->isIsSmtpDisabled());

        $model->setIsAccepted(false);
        $this->assertFalse($model->isAccepted());
    }


    public function testSetVariables()
    {
        $model = Mage::getModel('tbd_debug/email');
        $variables = array(
            'int'    => 10,
            'float'  => 10.5,
            'string' => 'tbd_debug',
            'array'  => array('key1' => 1, 'key2' => 2),
            'object' => new Varien_Object(),
            'null'   => NULL
        );

        $model->setVariables($variables);
        $actual = $model->getVariables();

        $this->assertArrayHasKey('int', $actual);
        $this->assertEquals(10, $actual['int']);

        $this->assertArrayHasKey('float', $actual);
        $this->assertEquals(10.5, $actual['float']);

        $this->assertArrayHasKey('string', $actual);
        $this->assertEquals('tbd_debug', $actual['string']);

        $this->assertArrayHasKey('array', $actual);
        $this->assertEquals(array('key1', 'key2'), $actual['array']);

        $this->assertArrayHasKey('object', $actual);
        $this->assertEquals('Varien_Object', $actual['object']);

        $this->assertArrayHasKey('null', $actual);
        $this->assertEquals('', $actual['null']);
    }

}
