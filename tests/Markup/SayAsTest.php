<?php

namespace Roomies\NexmoVoiceChannel\Tests\Markup;

use PHPUnit\Framework\TestCase;
use Roomies\NexmoVoiceChannel\Markup\SayAs;

class SayAsTest extends TestCase
{
    public function test_it_can_be_converted_to_string()
    {
        $sayAs = (new SayAs('RSVP'))->interpretAs('spell-out');

        $result = (string) $sayAs;

        $this->assertEquals(
            '<say-as interpret-as="spell-out">RSVP</say-as>',
            $result
        );
    }
}
