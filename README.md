# vonage-voice-channel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/roomies/vonage-voice-channel.svg)](https://packagist.org/packages/roomies/vonage-voice-channel)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/roomies-com/vonage-voice-channel/phpunit)
[![Total Downloads](https://img.shields.io/packagist/dt/roomies/vonage-voice-channel.svg)](https://packagist.org/packages/roomies/vonage-voice-channel)

This package provides a notification channel for the Laravel framework that works with Vonage's voice API, allowing text-to-speech phone calls. It also provides a fluent interface to construct your message content.

## Installation

You can install the package via Composer:

```bash
composer require roomies/vonage-voice-channel
```

Under the hood we use [`laravel/vonage-notification-channel`](https://github.com/laravel/vonage-notification-channel) to configure Vonage, so make sure you have it properly configured using Vonage environment variables. However, in order to make voice calls you need to provide additional credentials in your environment. Note that the private key can be a string or path to the key file.

```
VONAGE_APPLICATION_ID=
VONAGE_PRIVATE_KEY=
```

Then add your call from number and voice to `config/services.php` under the `vonage` key. You can review the [available voices in the Vonage documentation](https://developer.vonage.com/voice/voice-api/guides/text-to-speech).

```php
'vonage' => [
    'call_from' => env('VONAGE_CALL_FROM'),
    'call_language' => env('VONAGE_CALL_LANGUAGE', 'en-US'),
    'call_style' => env('VONAGE_CALL_STYLE', 0),
],
```

## Usage

Simply route a notification through the `VoiceChannel` and return a formatted message from the `toVoice` method. You use a string with your own [Speech Synthesis Markup Language (SSML)](https://developer.vonage.com/voice/voice-api/guides/customizing-tts) or use the the included wrapper API to build up your message.

```php
use Roomies\VonageVoiceChannel\Markup\Message;
use Roomies\VonageVoiceChannel\Markup\SayAs;
use Roomies\VonageVoiceChannel\Markup\Sentence;
use Roomies\VonageVoiceChannel\VonageVoiceChannel;

/**
 * Get the notification's delivery channels.
 *
 * @param  mixed  $notifiable
 * @return array
 */
public function via($notifiable)
{
    return [VonageVoiceChannel::class];
}

/**
 * Get the voice representation of the notification.
 *
 * @param  mixed  $notifiable
 * @return \Roomies\VonageVoiceChannel\Markup\Message
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
