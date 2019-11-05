<?php

namespace Roomies\NexmoVoiceChannel\Markup;

class Prosody extends Markup
{
    /**
     * The element name.
     *
     * @var string
     */
    const NAME = 'prosody';

    /**
     * Supported attributes for the element.
     *
     * @var array
     */
    protected $attributes = [
        'volume' => null,
        'rate' => null,
        'pitch' => null,
    ];
}
