<?php

namespace Roomies\NexmoVoiceChannel;

use App\User;
use Illuminate\Notifications\Notification;
use Nexmo\Client;

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
     * The voice to use for calls.
     *
     * @var string
     */
    protected $voice;

    /**
     * Create a new channel instance.
     *
     * @param  \Nexmo\Client  $client
     * @param  string  $from
     * @param  string  $voice
     * @return void
     */
    public function __construct(Client $client, string $from, string $voice)
    {
        $this->client = $client;
        $this->from = $from;
        $this->voice = $voice;
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
        $this->client->calls()->create([
            'to' => [[
                'type' => 'phone',
                'number' => $phoneNumber,
            ]],
            'from' => [
                'type' => 'phone',
                'number' => $this->from,
            ],
            'ncco' => [
                [
                    'action' => 'talk',
                    'text' => $message,
                    'level' => 1,
                    'voiceName' => $this->voice,
                ]
            ]
        ]);
    }
}