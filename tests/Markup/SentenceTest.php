<?php

namespace Roomies\NexmoVoiceChannel\Tests\Markup;

use PHPUnit\Framework\TestCase;
use Roomies\NexmoVoiceChannel\Markup\Prosody;
use Roomies\NexmoVoiceChannel\Markup\Sentence;

class SentenceTest extends TestCase
{
    public function test_it_can_be_converted_to_string()
    {
        $sentence = new Sentence(['Hello, world!']);

        $result = (string) $sentence;

        $this->assertEquals('<s>Hello, world!</s>', $result);
    }

    public function test_it_can_have_mutiple_children()
    {
        $sentence = new Sentence([
            'Hello,',
            (new Prosody('world'))->volume('loud'),
            '!',
        ]);

        $result = (string) $sentence;

        $this->assertEquals('<s>Hello,<prosody volume="loud">world</prosody>!</s>', $result);
    }
}
