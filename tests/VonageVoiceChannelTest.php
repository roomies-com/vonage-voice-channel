<?php

namespace Roomies\VonageVoiceChannel\Tests;

use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;
use Mockery;
use Vonage\Client;
use Vonage\Voice\OutboundCall;
use Roomies\VonageVoiceChannel\Markup\Message;
use Roomies\VonageVoiceChannel\Markup\Sentence;
use Roomies\VonageVoiceChannel\VonageVoiceChannel;

class VonageVoiceChannelTest extends TestCase
{
    public function test_it_calls_vonage_with_message_content()
    {
        $notifiable = new TestNotifiable;
        $notification = new TestMessageNotification;

        $channel = new VonageVoiceChannel($vonage = Mockery::mock(Client::class), '4444444444', 'en-US', 0);

        $vonage->shouldReceive('voice->createOutboundCall')
            ->with(Mockery::on(function ($outboundCall) {
                $ncco = Arr::first($outboundCall->getNCCO()->toArray());

                return $outboundCall instanceof OutboundCall
                    && Arr::get($outboundCall->getTo()->toArray(), 'number') === '5555555555'
                    && Arr::get($outboundCall->getFrom()->toArray(), 'number') === '4444444444'
                    && Arr::get($ncco, 'action') === 'talk'
                    && Arr::get($ncco, 'text') === '<speak><s>Hello, world</s></speak>'
                    && Arr::get($ncco, 'level') === '1'
                    && Arr::get($ncco, 'language') === 'en-US'
                    && Arr::get($ncco, 'style') === '0';
            }))
            ->once();

        $channel->send($notifiable, $notification);
    }

    public function test_it_calls_vonage_with_string_content()
    {
        $notifiable = new TestNotifiable;
        $notification = new TestTextNotification;

        $channel = new VonageVoiceChannel($vonage = Mockery::mock(Client::class), '4444444444', 'en-US', 0);

        $vonage->shouldReceive('voice->createOutboundCall')
            ->with(Mockery::on(function ($outboundCall) {
                $ncco = Arr::first($outboundCall->getNCCO()->toArray());

                return $outboundCall instanceof OutboundCall
                    && Arr::get($outboundCall->getTo()->toArray(), 'number') === '5555555555'
                    && Arr::get($outboundCall->getFrom()->toArray(), 'number') === '4444444444'
                    && Arr::get($ncco, 'action') === 'talk'
                    && Arr::get($ncco, 'text') === '<speak><s>Hello, world</s></speak>'
                    && Arr::get($ncco, 'level') === '1'
                    && Arr::get($ncco, 'language') === 'en-US'
                    && Arr::get($ncco, 'style') === '0';
            }))
            ->once();

        $channel->send($notifiable, $notification);
    }
}

class TestNotifiable
{
    use Notifiable;

    public $phone_number = '5555555555';

    public function routeNotificationForVonage($notification)
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
