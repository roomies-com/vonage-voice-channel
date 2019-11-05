<?php

namespace Roomies\NexmoVoiceChannel\Tests\Markup;

use Roomies\NexmoVoiceChannel\Markup\Message;
use Roomies\NexmoVoiceChannel\Markup\Sentence;
use Roomies\NexmoVoiceChannel\Tests\TestCase;

class MessageTest extends TestCase
{
    public function test_it_can_be_converted_to_string()
    {
        $message = new Message([
            new Sentence('Hello, world!'),
            new Sentence(['How are you today?']),
        ]);

        $result = (string) $message;

        $this->assertEquals(
            '<speak><s>Hello, world!</s><s>How are you today?</s></speak>',
            $result
        );
    }
}
