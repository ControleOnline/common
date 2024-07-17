<?php

namespace ControleOnline\Service;

use Symfony\Component\Messenger\MessageBusInterface;

class PusherService
{

    public function __construct(
        private MessageBusInterface $messageBus
    ) {
    }

    public function push($data, $topic)
    {
        try {
            $this->messageBus->dispatch(new PushMessage($topic, $data));
        } catch (\Exception $e) {
            // Handle exception, e.g., log the error
            throw $e; // Or rethrow for further handling
        }
    }
}
