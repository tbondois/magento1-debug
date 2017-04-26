<?php

/**
 * Class TBD_Debug_Test_Model_Core_Email_Template
 *
 * @category TBD
 * @package  TBD_Debug
 * @license  Copyright: Pirate TBD, 2016
 * @link     https://piratetbd.com
 *
 * @covers TBD_Debug_Model_Core_Email_Template
 * @codeCoverageIgnore
 */
class TBD_Debug_Test_Model_Core_Email_Template extends EcomDev_PHPUnit_Test_Case
{

    public function testRewrite()
    {
        $model = Mage::getModel('core/email_template');
        $this->assertNotNull($model);
        $this->assertInstanceOf('Mage_Core_Model_Email_Template', $model);
        $this->assertInstanceOf('TBD_Debug_Model_Core_Email_Template', $model);
    }


    /**
     * @covers TBD_Debug_Model_Core_Email_Template_Capture::send
     */
    public function testSend()
    {
        $mail = $this->getMock('Zend_Mail');

        $model = $this->getModelMock('core/email_template', array('getMail', 'parentSend', 'addEmailToProfile'));
        $model->expects($this->once())->method('getMail')->willReturn($mail);

        // Parameters are passed to parrent method
        $model->expects($this->once())->method('parentSend')
            ->with('mario@mailinator.com', 'Mario', array('store' => 'Pirate TBD'))
            ->willReturn(true);
        $model->expects($this->once())->method('addEmailToProfile')->with(
            'mario@mailinator.com',
            'Mario',
            array('store' => 'Pirate TBD'),
            true,
            $mail
        );

        $model->send('mario@mailinator.com', 'Mario', array('store' => 'Pirate TBD'));
    }


    /**
     * Checks that execution is not interrupted if an exception is raised by our profile method
     *
     * @covers TBD_Debug_Model_Core_Email_Template_Capture::send
     */
    public function testSendWithException()
    {
        $mail = $this->getMock('Zend_Mail');

        $model = $this->getModelMock('core/email_template', array('getMail', 'parentSend', 'addEmailToProfile'));
        $model->expects($this->once())->method('getMail')->willReturn($mail);

        // Parameters are passed to parrent method
        $model->expects($this->once())->method('parentSend')
            ->with('mario@mailinator.com', 'Mario', array('store' => 'Pirate TBD'))
            ->willReturn(true);
        $model->expects($this->once())->method('addEmailToProfile')->willThrowException(new Exception('boom'));

        $actual = $model->send('mario@mailinator.com', 'Mario', array('store' => 'Pirate TBD'));
        $this->assertTrue($actual);
    }


    /**
     * @covers TBD_Debug_Model_Core_Email_Template_Capture::addEmailToProfile
     */
    public function testAddEmailToProfile()
    {
        $model = $this->getModelMock('core/email_template', array('decodeSubject', 'getContent', 'getSenderName', 'getSenderEmail', 'isPlain', 'send'));
        $model->expects($this->once())->method('decodeSubject')->with('encoded e-mail subject')->willReturn('e-mail subject');
        $model->expects($this->once())->method('getSenderName')->willReturn('Mario Sender');
        $model->expects($this->once())->method('getSenderEmail')->willReturn('mario+sender@mailinator.com');
        $model->expects($this->once())->method('isPlain')->willReturn(true);


        $emailMock = $this->getModelMock('tbd_debug/email',
            array('setFromName', 'setFromEmail', 'setToEmail', 'setToName', 'setSubject', 'setIsPlain', 'setBody', 'setIsAccepted', 'setVariables'));
        $this->replaceByMock('model', 'tbd_debug/email', $emailMock);
        $emailMock->expects($this->once())->method('setFromName')->with('Mario Sender');
        $emailMock->expects($this->once())->method('setFromEmail')->with('mario+sender@mailinator.com');
        $emailMock->expects($this->once())->method('setToEmail')->with('mario@mailinator.com');
        $emailMock->expects($this->once())->method('setToName')->with('Mario');
        $emailMock->expects($this->once())->method('setSubject')->with('e-mail subject');
        $emailMock->expects($this->once())->method('setIsPlain')->with(true);
        $emailMock->expects($this->once())->method('setBody')->with('e-mail body');
        $emailMock->expects($this->once())->method('setIsAccepted')->with(true);
        $emailMock->expects($this->once())->method('setVariables')->with(array('store' => 'Pirate TBD'));


        $requestInfo = $this->getModelMock('tbd_debug/requestInfo', array('addEmail'));
        $requestInfo->expects($this->once())->method('addEmail')->with($emailMock);

        $observer = $this->getModelMock('tbd_debug/observer', array('getRequestInfo'));
        $this->replaceByMock('singleton', 'tbd_debug/observer', $observer);
        $observer->expects($this->any())->method('getRequestInfo')->willReturn($requestInfo);


        $mail = $this->getMock('Zend_Mail', array('getSubject'));
        $mail->expects($this->any())->method('getSubject')->willReturn('encoded e-mail subject');
        $model->expects($this->once())->method('getContent')->with($mail)->willReturn('e-mail body');



        $model->addEmailToProfile('mario@mailinator.com', 'Mario', array('store' => 'Pirate TBD'), true, $mail);
    }


    /**
     * @covers TBD_Debug_Model_Core_Email_Template_Capture::getContent
     */
    public function testGetContentForPlain()
    {
        $mimePart = $this->getMock('Zend_Mime_Part', null, array(), '', false);;

        $mail = $this->getMock('Zend_Mail', array('getBodyText', 'getBodyHtml'));
        $mail->expects($this->once())->method('getBodyText')->willReturn($mimePart);
        $mail->expects($this->never())->method('getBodyHtml');

        $model = $this->getModelMock('core/email_template', array('isPlain', 'getPartDecodedContent'));
        $model->expects($this->any())->method('isPlain')->willReturn(true);
        $model->expects($this->once())->method('getPartDecodedContent')->with($mimePart)->willReturn('raw content');

        $actual = $model->getContent($mail);
        $this->assertEquals('raw content', $actual);
    }


    /**
     * @covers TBD_Debug_Model_Core_Email_Template_Capture::getContent
     */
    public function testGetContentForNonPlain()
    {
        $mimePart = $this->getMock('Zend_Mime_Part', null, array(), '', false);;

        $mail = $this->getMock('Zend_Mail', array('getBodyText', 'getBodyHtml'));
        $mail->expects($this->never())->method('getBodyText');
        $mail->expects($this->once())->method('getBodyHtml')->willReturn($mimePart);

        $model = $this->getModelMock('core/email_template', array('isPlain', 'getPartDecodedContent'));
        $model->expects($this->any())->method('isPlain')->willReturn(false);
        $model->expects($this->once())->method('getPartDecodedContent')->with($mimePart)->willReturn('raw html content');

        $actual = $model->getContent($mail);
        $this->assertEquals('raw html content', $actual);
    }


    /**
     * @covers TBD_Debug_Model_Core_Email_Template_Capture::getContent
     */
    public function testGetContentForQueue()
    {
        $mail = $this->getMock('Zend_Mail', array('getBodyText', 'getBodyHtml'));
        $mail->expects($this->never())->method('getBodyText');
        $mail->expects($this->never())->method('getBodyHtml');

        $queue = $this->getModelMock('core/email_queue', array('getMessageBody'));
        $queue->expects($this->once())->method('getMessageBody')->willReturn('e-mail body');

        $model = $this->getModelMock('core/email_template', array('hasQueue', 'getQueue'));
        $model->expects($this->any())->method('hasQueue')->willReturn(true);
        $model->expects($this->any())->method('getQueue')->willReturn($queue);

        $actual = $model->getContent($mail);
        $this->assertEquals('e-mail body', $actual);

    }


    /**
     * @covers TBD_Debug_Model_Core_Email_Template_Capture::getPartDecodedContent
     */
    public function testGetPartDecodedContent()
    {
        // this condition doesn't seem right to live in a test
        $zendWithGetRawContent = Zend_Version::compareVersion('1.12.0') <= 0;

        $mimePart = $this->getMock('Zend_Mime_Part', array(), array(), '', false);
        if ($zendWithGetRawContent) {
            $mimePart->expects($this->any())->method('getRawContent')->willReturn('raw content');
        } else {
            $mimePart->expects($this->any())->method('getContent')->willReturn('content');
        }

        $model = $this->getModelMock('core/email_template', array('isPlain'));
        $actual = $model->getPartDecodedContent($mimePart);

        if ($zendWithGetRawContent) {
            $this->assertEquals('raw content', $actual);
        } else {
            $this->assertEquals('content', $actual);

        }
    }


    /**
     * @covers TBD_Debug_Model_Core_Email_Template_Capture::decodeSubject
     */
    public function testDecodeSubject()
    {
        $model = $this->getModelMock('core/email_template', array('send'));
        $this->assertEquals('Hello, world', $model->decodeSubject('=?utf-8?B?SGVsbG8sIHdvcmxk?='));
    }


    /**
     * @covers TBD_Debug_Model_Core_Email_Template_Capture::decodeSubject
     */
    public function testDecodeSubjectForQueue()
    {
        $queue = $this->getModelMock('core/email_queue', array('getMessageParameters'));
        $queue->expects($this->once())->method('getMessageParameters')
            ->with('subject')
            ->willReturn('e-mail subject');

        $model = $this->getModelMock('core/email_template', array('hasQueue', 'getQueue'));
        $model->expects($this->any())->method('hasQueue')->willReturn(true);
        $model->expects($this->any())->method('getQueue')->willReturn($queue);

        $actual = $model->decodeSubject('subject');
        $this->assertEquals('e-mail subject', $actual);
    }

}
