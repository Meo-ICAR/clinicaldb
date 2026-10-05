<?php

namespace App\Listeners;

use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Log;
use Throwable;
use Webklex\PHPIMAP\ClientManager;

class SaveSentEmailToImap
{
    public function handle(MessageSent $event): void
    {
        if (blank(config('services.imap.host')) || blank(config('services.imap.username'))) {
            return;
        }

        try {
            $client = (new ClientManager)->make([
                'host' => config('services.imap.host'),
                'port' => config('services.imap.port'),
                'encryption' => config('services.imap.encryption'),
                'validate_cert' => config('services.imap.validate_cert'),
                'username' => config('services.imap.username'),
                'password' => config('services.imap.password'),
                'protocol' => 'imap',
            ]);

            $client->connect();
            $client->getFolder('Sent')->appendMessage($event->sent->toString(), ['\\Seen']);
        } catch (Throwable $e) {
            Log::warning('Impossibile salvare la copia in Posta inviata su Zimbra: '.$e->getMessage());
        }
    }
}
