<?php

namespace Roomies\NexmoVoiceChannel\Tests\Markup;

use Roomies\NexmoVoiceChannel\Markup\Sentence;
use Roomies\NexmoVoiceChannel\Markup\Substitution;
use Roomies\NexmoVoiceChannel\Tests\TestCase;

class SubstitutionTest extends TestCase
{
    public function test_it_can_be_converted_to_string_array()
    {
        $substitution = (new Substitution(['US']))->alias('United States');

        $result = (string) $substitution;

        $this->assertEquals('<sub alias="United States">US</sub>', $result);
    }
}
