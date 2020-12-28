<?php

namespace Roomies\NexmoVoiceChannel;

use App\User;
use Illuminate\Notifications\Notification;
use Nexmo\Client;
use Nexmo\Voice\Endpoint\Phone;
use Nexmo\Voice\NCCO\Action\Talk;
use Nexmo\Voice\NCCO\NCCO;
use Nexmo\Voice\OutboundCall;

class NexmoVoiceChannel
{
    /**
     * The Nexmo client instance.
     *
     * @var \Nexmo\Client
     */
    protected $client;

    /**
     * The phone number notifications should come from.
     *
     * @var string
     */
    protected $from;

    /**
     * The language to use for calls.
     *
     * @var string
     */
    protected $language;

    /**
     * The language style to use for calls.
     *
     * @var string
     */
    protected $style;

    /**
     * Create a new channel instance.
     *
     * @param  \Nexmo\Client  $client
     * @param  string  $from
     * @param  string  $language
     * @param  string  $style
     * @return void
     */
    public function __construct(Client $client, string $from, string $language, string $style)
    {
        $this->client = $client;
        $this->from = $from;
        $this->language = $language;
        $this->style = $style;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('nexmo', $notification)) {
            return;
        }

        $message = $notification->toVoice($notifiable);

        $this->call($to, (string) $message);
    }

    /**
     * Make the call to the given number with the given message.
     *
     * @param  string  $phoneNumber
     * @param  string  $message
     * @return void
     */
    protected function call($phoneNumber, $message)
    {
        $outboundCall = new OutboundCall(new Phone($phoneNumber), new Phone($this->from));

        $ncco = (new NCCO)->addAction(Talk::factory($message, [
            'level' => 1,
            'language' => $this->language,
            'style' => $this->style,
        ]));

        $outboundCall->setNCCO($ncco);

        $this->client->voice()->createOutboundCall($outboundCall);
    }
}
