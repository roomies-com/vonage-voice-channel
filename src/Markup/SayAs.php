<?php

namespace Roomies\VonageVoiceChannel\Markup;

class SayAs extends Markup
{
    /**
     * The element name.
     *
     * @var string
     */
    const NAME = 'say-as';

    /**
     * Supported attributes for the element.
     *
     * @var array
     */
    protected $attributes = [
        'interpret-as' => null,
        'format' => null,
    ];
}
