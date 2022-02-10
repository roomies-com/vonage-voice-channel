<?php

namespace Roomies\VonageVoiceChannel;

use Vonage\Client as VonageClient;
use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;

class VonageVoiceChannelServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind(VonageVoiceChannel::class, function ($app) {
            $vonage = $app->make(VonageClient::class);

            return new VonageVoiceChannel(
                $vonage,
                $app['config']['services.vonage.call_from'],
                $app['config']['services.vonage.call_language'] ?? 'en-US',
                $app['config']['services.vonage.call_style'] ?? 0
            );
        });

        Notification::resolved(function (ChannelManager $service) {
            $service->extend('voice', function ($app) {
                return $app->make(VonageVoiceChannel::class);
            });
        });
    }
}
