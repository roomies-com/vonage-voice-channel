<?php

namespace Roomies\VonageVoiceChannel\Tests\Markup;

use PHPUnit\Framework\Attributes\CoversClass;
use Roomies\VonageVoiceChannel\Markup\Prosody;
use Roomies\VonageVoiceChannel\Tests\TestCase;

#[CoversClass(Prosody::class)]
class ProsodyTest extends TestCase
{
    public function test_it_can_be_instantiated()
    {
        $instance = new Prosody;

        $this->assertInstanceOf(Prosody::class, $instance);
    }

    public function test_it_can_be_converted_to_string()
    {
        $instance = new Prosody;

        $this->assertEquals('<prosody/>', (string) $instance);
    }

    public function test_it_can_be_converted_to_string_with_invalid_key()
    {
        $instance = (new Prosody)->invalid('invalid');

        $this->assertEquals('<prosody/>', (string) $instance);
    }

    public function test_it_can_be_converted_to_string_with_volume()
    {
        $instance = (new Prosody)->volume('loud');

        $this->assertEquals('<prosody volume="loud"/>', (string) $instance);
    }

    public function test_it_can_be_converted_to_string_without_time()
    {
        $instance = (new Prosody)->volume(null);

        $this->assertEquals('<prosody/>', (string) $instance);
    }

    public function test_it_can_be_converted_to_string_with_rate()
    {
        $instance = (new Prosody)->rate('fast');

        $this->assertEquals('<prosody rate="fast"/>', (string) $instance);
    }

    public function test_it_can_be_converted_to_string_with_pitch()
    {
        $instance = (new Prosody)->pitch('default');

        $this->assertEquals('<prosody pitch="default"/>', (string) $instance);
    }
}
