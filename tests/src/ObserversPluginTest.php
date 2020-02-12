<?php

namespace CL\Swiftmailer\Test;

use PHPUnit\Framework\TestCase;
use Swift_Mailer;
use Swift_Message;
use Swift_NullTransport;
use Swift_Plugins_MessageLogger;
use CL\Swiftmailer\ObserversPlugin;

/**
 * @coversDefaultClass \CL\Swiftmailer\ObserversPlugin
 */
class ObserversPluginTest extends TestCase
{
    /**
     * @covers ::beforeSendPerformed
     * @covers ::sendPerformed
     * @covers ::__construct
     * @covers ::add
     * @covers ::triggerEvent
     */
    public function testTest()
    {
        $mailer = Swift_Mailer::newInstance(Swift_NullTransport::newInstance());

        $mailer->registerPLugin(new ObserversPlugin([
            'test1@example.com' => ['event1', 'event2'],
            'test2@example.com' => ['event2', 'event6'],
            'test3@example.com' => ['event3'],
        ]));

        $logger = new Swift_Plugins_MessageLogger();

        $mailer->registerPlugin($logger);


        $message1 = Swift_Message::newInstance();
        $message1
            ->setSubject('My subject')
            ->setBody('body')
            ->setTo('other@example.com')
            ->setFrom('me@example.com');

        $headers = $message1->getHeaders();
        $headers->addTextHeader(ObserversPlugin::HEADER, 'event1');

        $mailer->send($message1);

        #========================================

        $message1 = Swift_Message::newInstance();
        $message1
            ->setSubject('My subject')
            ->setBody('body')
            ->setTo('other@example.com')
            ->setFrom('me@example.com');

        $mailer->send($message1);

        #========================================

        $message2 = Swift_Message::newInstance();
        $message2
            ->setSubject('My subject')
            ->setBody('body')
            ->setTo('other@example.com')
            ->setFrom('me@example.com');

        $headers = $message2->getHeaders();
        $headers->addTextHeader(ObserversPlugin::HEADER, 'event2');

        $mailer->send($message2);

        #========================================

        $message3 = Swift_Message::newInstance();
        $message3
            ->setSubject('My subject')
            ->setBody('body')
            ->setTo('other@example.com')
            ->setFrom('me@example.com');

        $headers = $message3->getHeaders();
        $headers->addTextHeader(ObserversPlugin::HEADER, 'event6');
        $headers->addTextHeader(ObserversPlugin::HEADER, 'event3');

        $mailer->send($message3);

        #========================================

        $message4 = Swift_Message::newInstance();
        $message4
            ->setSubject('My subject')
            ->setBody('body')
            ->setTo('other@example.com')
            ->setFrom('me@example.com');

        $headers = $message4->getHeaders();
        $headers->addTextHeader(ObserversPlugin::HEADER, 'event1');
        $headers->addTextHeader(ObserversPlugin::HEADER, 'event2');

        $mailer->send($message4);


        $sent = $logger->getMessages();

        $this->assertEquals(
            ['test1@example.com' => null],
            $sent[0]->getBcc()
        );

        $this->assertEquals(
            null,
            $sent[1]->getBcc()
        );

        $this->assertEquals(
            ['test1@example.com' => null, 'test2@example.com' => null],
            $sent[2]->getBcc()
        );

        $this->assertEquals(
            ['test2@example.com' => null, 'test3@example.com' => null],
            $sent[3]->getBcc()
        );

        $this->assertEquals(
            ['test1@example.com' => null, 'test2@example.com' => null],
            $sent[4]->getBcc()
        );

    }
}
