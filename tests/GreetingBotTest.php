<?php

namespace Kata\Tests;

use PHPUnit\Framework\TestCase;
use Kata\GreetingBot;

class GreetingBotTest extends TestCase
{
    /**
     * @test
     */
    public function itInterpolatesGivenNameInAGreeting()
    {
        $answer = $this->getAnswerForName("Bart");

        $this->assertContains("Bart", $answer);
    }

    /**
     * @test
     */
    public function itAllowsNullNamesByIntroducingStandIn()
    {
        $answer = $this->getAnswerForName(null);

        $this->assertContains("my friend", $answer);
    }

    private function getAnswerForName(?string $name) : string
    {
        $bot = new GreetingBot();

        return $bot->greet($name);
    }
}
