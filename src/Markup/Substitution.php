<?php

namespace Roomies\VonageVoiceChannel\Markup;

class Substitution extends Markup
{
    /**
     * The element name.
     *
     * @var string
     */
    const NAME = 'sub';

    /**
     * Supported attributes for the element.
     *
     * @var array
     */
    protected $attributes = [
        'alias' => null,
    ];
}
