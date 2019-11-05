<?php

namespace Roomies\NexmoVoiceChannel\Tests\Markup;

use Roomies\NexmoVoiceChannel\Markup\Pause;
use Roomies\NexmoVoiceChannel\Tests\TestCase;

class PauseTest extends TestCase
{
    public function test_it_can_be_instantiated()
    {
        $instance = new Pause;

        $this->assertInstanceOf(Pause::class, $instance);
    }

    public function test_it_can_be_converted_to_string()
    {
        $instance = new Pause;

        $this->assertEquals('<break/>', (string) $instance);
    }

    public function test_it_can_be_converted_to_string_with_invalid_key()
    {
        $instance = (new Pause)->invalid('invalid');

        $this->assertEquals('<break/>', (string) $instance);
    }

    public function test_it_can_be_converted_to_string_with_time()
    {
        $instance = (new Pause)->time('1s');

        $this->assertEquals('<break time="1s"/>', (string) $instance);
    }

    public function test_it_can_be_converted_to_string_without_time()
    {
        $instance = (new Pause)->time(null);

        $this->assertEquals('<break/>', (string) $instance);
    }

    public function test_it_can_be_converted_to_string_with_strength()
    {
        $instance = (new Pause)->strength('weak');

        $this->assertEquals('<break strength="weak"/>', (string) $instance);
    }
}
