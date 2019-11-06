# nexmo-voice-channel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/roomies/nexmo-voice-channel.svg?style=flat-square)](https://packagist.org/packages/roomies/nexmo-voice-channel)
[![Build Status](https://img.shields.io/travis/roomies-com/nexmo-voice-channel/master.svg?style=flat-square)](https://travis-ci.org/roomies-com/nexmo-voice-channel)
[![Total Downloads](https://img.shields.io/packagist/dt/roomies/nexmo-voice-channel.svg?style=flat-square)](https://packagist.org/packages/roomies/nexmo-voice-channel)

This package provides a notification channel for the Laravel framework that works with Nexmo's voice API, allowing text-to-speech phone calls. It also provides a fluent interface to construct your message content.

## Installation

You can install the package via Composer:

```bash
composer require roomies/nexmo-voice-channel
```

Under the hood we use [`nexmo/nexmo-laravel`](https://github.com/Nexmo/nexmo-laravel) to configure Nexmo. This is the same package used by Laravel's first-party Nexmo notification channel. However, in order to make voice calls you need to provide additional credentials in your environment. Note that the private key can be a string or path to the key file.

```
NEXMO_APPLICATION_ID=
NEXMO_PRIVATE_KEY=
```

Then add your call from number and voice to `config/services.php` under the `nexmo` key. You can review the [available voices in the Nexmo documentation](https://developer.nexmo.com/voice/voice-api/guides/text-to-speech).

```
'nexmo' => [
    'call_from' => env('NEXMO_CALL_FROM'),
    'call_voice' => env('NEXMO_CALL_VOICE', 'Kimberly'),
],
```

## Usage

Simply route a notification through the `VoiceChannel` and return a formatted message from the `toVoice` method. You use a string with your own [Speech Synthesis Markup Language (SSML)](https://developer.nexmo.com/voice/voice-api/guides/customizing-tts) or use the the included wrapper API to build up your message.

``` php
use Roomies\NexmoVoiceChannel\Markup\Message;
use Roomies\NexmoVoiceChannel\Markup\SayAs;
use Roomies\NexmoVoiceChannel\Markup\Sentence;
use Roomies\NexmoVoiceChannel\NexmoVoiceChannel;

/**
 * Get the notification's delivery channels.
 *
 * @param  mixed  $notifiable
 * @return array
 */
public function via($notifiable)
{
    return [NexmoVoiceChannel::class];
}

/**
 * Get the voice representation of the notification.
 *
 * @param  mixed  $notifiable
 * @return \Roomies\NexmoVoiceChannel\Markup\Message
 */
public function toVoice($notifiable)
{
    return new Message([
        new Sentence('Hi, thanks for joining Roomies.'),
        new Sentence([
            'Your verification code is',
            new SayAs('ABC123')->interpretAs('spell-out')
        ]),
    ]);
}
```

### Markup

There are a handful of different markup types available to get the right message you're after. Here are some additional examples, otherwise browse `src/Markup` to see all the available options.

```php
new Paragraph([
    new Sentence('This is the first sentence of a paragraph.'),
]);

new Sentence([
    'Hey!',
    (new Pause)->time('1s'),
    (new Prosody('Wake up!'))->volume('loud'),
    (new Substitution(
        (new SayAs('US'))->interpretAs('spell-out'),
    ))->alias('United States'),
])
```

### Custom

Alternatively, you're free to just return your own SSML markup as a string. This gives you complete control if you need something more custom or have more complex requirements.

```php
/**
 * Get the voice representation of the notification.
 *
 * @param  mixed  $notifiable
 * @return string
 */
public function toVoice($notifiable)
{
    return '<speak>
        <s>Hi, thanks for joining Roomies</s>
        <s>Your verification code is <say-as interpret-as="spell-out">ABC123</say-as></s>
    <speak>';
}
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
