<?php
namespace App\Channels;

use Twilio\Rest\Client;
use App\Notifications\WhatsAppInvitation;
use App\Notifications\WhatsAppReminder;
use Illuminate\Support\Facades\Notification;

class WhatsAppChannel
{
    public function send($notifiable, $notification)
    {
        $message = $notification->toWhatsApp($notifiable);


        $to = $notifiable->routeNotificationFor('WhatsApp');
        $from = config('services.twilio.whatsapp_from');


        $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));

        return $twilio->messages->create('whatsapp:' . $to, [
            "from" => 'whatsapp:' . $from,
            "contentSid" => $message->templateSid,
            "contentVariables" => json_encode($message->contentVariables)
        ]);
    }
}