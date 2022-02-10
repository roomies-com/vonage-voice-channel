<?php

namespace Roomies\VonageVoiceChannel\Tests\Markup;

use Roomies\VonageVoiceChannel\Markup\Sentence;
use Roomies\VonageVoiceChannel\Markup\Substitution;
use Roomies\VonageVoiceChannel\Tests\TestCase;

class SubstitutionTest extends TestCase
{
    public function test_it_can_be_converted_to_string_array()
    {
        $substitution = (new Substitution(['US']))->alias('United States');

        $result = (string) $substitution;

        $this->assertEquals('<sub alias="United States">US</sub>', $result);
    }
}
