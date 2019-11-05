<?php

namespace Roomies\NexmoVoiceChannel\Markup;

class Pause extends Markup
{
    /**
     * The element name.
     *
     * @var string
     */
    const NAME = 'break';

    /**
     * Supported attributes for the element.
     *
     * @var array
     */
    protected $attributes = [
        'time' => '',
        'strength' => '',
    ];
}
