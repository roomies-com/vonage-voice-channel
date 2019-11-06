<?php

namespace Roomies\NexmoVoiceChannel\Tests;

use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Mockery;
use Nexmo\Client;
use Roomies\NexmoVoiceChannel\Markup\Message;
use Roomies\NexmoVoiceChannel\Markup\Sentence;
use Roomies\NexmoVoiceChannel\NexmoVoiceChannel;

class NexmoVoiceChannelTest extends TestCase
{
    public function test_it_calls_nexmo_with_message_content()
    {
        $notifiable = new TestNotifiable;
        $notification = new TestMessageNotification;

        $channel = new NexmoVoiceChannel($nexmo = Mockery::mock(Client::class), '4444444444', 'Kimberly');

        $nexmo->shouldReceive('calls->create')
            ->with([
                'to' => [[
                    'type' => 'phone',
                    'number' => '5555555555',
                ]],
                'from' => [
                    'type' => 'phone',
                    'number' => '4444444444'
                ],
                'ncco' => [
                    [
                        'action' => 'talk',
                        'text' => '<speak><s>Hello, world</s></speak>',
                        'level' => 1,
                        'voiceName' => 'Kimberly'
                    ]
                ]
            ])->once();

        $channel->send($notifiable, $notification);
    }

    public function test_it_calls_nexmo_with_string_content()
    {
        $notifiable = new TestNotifiable;
        $notification = new TestTextNotification;

        $channel = new NexmoVoiceChannel($nexmo = Mockery::mock(Client::class), '4444444444', 'Kimberly');

        $nexmo->shouldReceive('calls->create')
            ->with([
                'to' => [[
                    'type' => 'phone',
                    'number' => '5555555555',
                ]],
                'from' => [
                    'type' => 'phone',
                    'number' => '4444444444'
                ],
                'ncco' => [
                    [
                        'action' => 'talk',
                        'text' => '<speak><s>Hello, world</s></speak>',
                        'level' => 1,
                        'voiceName' => 'Kimberly'
                    ]
                ]
            ])->once();

        $channel->send($notifiable, $notification);
    }
}

class TestNotifiable
{
    use Notifiable;

    public $phone_number = '5555555555';

    public function routeNotificationForNexmo($notification)
    {
        return $this->phone_number;
    }
}

class TestMessageNotification extends Notification
{
    public function toVoice($notifiable)
    {
        return new Message(
            new Sentence('Hello, world')
        );
    }
}

class TestTextNotification extends Notification
{
    public function toVoice($notifiable)
    {
        return '<speak><s>Hello, world</s></speak>';
    }
}
