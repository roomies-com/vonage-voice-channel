<?php

namespace Roomies\NexmoVoiceChannel;

use Nexmo\Client as NexmoClient;
use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;

class NexmoVoiceChannelServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind(NexmoVoiceChannel::class, function ($app) {
            $nexmo = $app->make(NexmoClient::class);

            return new NexmoVoiceChannel(
                $nexmo,
                $app['config']['services.nexmo.call_from'],
                $app['config']['services.nexmo.call_voice'] ?? 'Kimberly'
            );
        });

        Notification::resolved(function (ChannelManager $service) {
            $service->extend('voice', function ($app) {
                return $app->make(NexmoVoiceChannel::class);
            });
        });
    }
}
