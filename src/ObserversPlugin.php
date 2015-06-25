<?php

namespace CL\Swiftmailer;

use Swift_Events_SendListener;
use Swift_Message;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class ObserversPlugin implements Swift_Events_SendListener
{
    const HEADER = 'X-Observer-Event';

    /**
     * @var array
     */
    private $observers = [];

    public function __construct(array $observers)
    {
        foreach ($observers as $observer => $events) {
            $this->add($observer, $events);
        }
    }

    /**
     * @param string $observer
     * @param array  $events
     */
    public function add($observer, array $events)
    {
        $this->observers[$observer] = $events;
    }

    public function triggerEvent($event, Swift_Message $message)
    {
        foreach ($this->observers as $observer => $observerEvents) {
            if (in_array($event, $observerEvents)) {
                $message->addBcc($observer);
            }
        }
    }

    /**
     * Add an observer to bcc if his events match one of the triggered events
     *
     * @param Swift_Events_SendEvent $evt
     */
    public function beforeSendPerformed(\Swift_Events_SendEvent $evt)
    {
        $message = $evt->getMessage();
        $headers = $message->getHeaders();

        foreach ($headers->getAll(ObserversPlugin::HEADER) as $event) {
            $this->triggerEvent($event->getValue(), $message);
        }
    }

    /**
     * Do nothing
     *
     * @param Swift_Events_SendEvent $evt
     */
    public function sendPerformed(\Swift_Events_SendEvent $evt)
    {
        // Do Nothing
    }
}
