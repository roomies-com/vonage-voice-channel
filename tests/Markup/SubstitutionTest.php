<?php

namespace Roomies\NexmoVoiceChannel\Tests\Markup;

use PHPUnit\Framework\TestCase;
use Roomies\NexmoVoiceChannel\Markup\Substitution;
use Roomies\NexmoVoiceChannel\Markup\Sentence;

class SubstitutionTest extends TestCase
{
    public function test_it_can_be_converted_to_string_array()
    {
        $substitution = (new Substitution(['US']))->alias('United States');

        $result = (string) $substitution;

        $this->assertEquals('<sub alias="United States">US</sub>', $result);
    }
}
