<?php

namespace Roomies\VonageVoiceChannel\Tests\Markup;

use PHPUnit\Framework\Attributes\CoversClass;
use Roomies\VonageVoiceChannel\Markup\Message;
use Roomies\VonageVoiceChannel\Markup\Sentence;
use Roomies\VonageVoiceChannel\Tests\TestCase;

#[CoversClass(Message::class)]
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
