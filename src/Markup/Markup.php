<?php

namespace Roomies\VonageVoiceChannel\Markup;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class Markup
{
    /**
     * Supported attributes for the element.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The children of the element.
     *
     * @var array
     */
    protected $children = [];

    /**
     * Create a new markup instance>
     *
     * @param  mixed  $children
     * @return void
     */
    public function __construct($children = [])
    {
        $this->children = Arr::wrap($children);
    }

    /**
     * Set the attribute if it is supported by the element.
     *
     * @param  string  $name
     * @param  array  $arguments
     * @return $this
     */
    public function __call(string $name, array $arguments)
    {
        $key = Str::kebab($name);

        if (Arr::has($this->attributes, $key)) {
            $this->attributes[$key] = Arr::first($arguments);
        }

        return $this;
    }

    /**
     * Get the string representation of the element.
     *
     * @return string
     */
    public function __toString(): string
    {
        if ($children = $this->getChildren()) {
            return sprintf('<%s%s>%s</%s>', static::NAME, $this->getAttributes(), $children, static::NAME);
        }

        return sprintf('<%s%s/>', static::NAME, $this->getAttributes());
    }

    /**
     * Build the children of the markup.
     *
     * @return string
     */
    public function getChildren(): string
    {
        return collect($this->children)->map(function ($component) {
            return (string) $component;
        })->implode('');
    }

    /**
     * Build an XML attribute string from an array.
     *
     * @return string
     */
    protected function getAttributes()
    {
        $attributes = collect($this->attributes)
            ->filter()
            ->map(function ($value, $key) {
                return $key . '="' . e($value, false) . '"';
            });

        if ($attributes->isEmpty()) {
            return '';
        }

        return ' '.$attributes->implode(' ');
    }
}
