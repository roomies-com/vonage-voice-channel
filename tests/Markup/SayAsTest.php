<?php

namespace Roomies\VonageVoiceChannel\Tests\Markup;

use Roomies\VonageVoiceChannel\Markup\SayAs;
use Roomies\VonageVoiceChannel\Tests\TestCase;

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
