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
    public function itHandlesNullName()
    {
        $answer = $this->getAnswerForName(null);

        $this->assertContains("my friend", $answer);
    }

    /**
     * @test
     */
    public function itHandlesShoutingWhenGivenNameIsAllUppercase()
    {
        $answer = $this->getAnswerForName("BART");

        $this->assertContains("HELLO BART!", $answer);
    }

    /**
     * @test
     */
    public function itHandlesExactlyTwoNames()
    {
        $answer = $this->getAnswerForMultipleNames(["Bart", "Amy"]);

        $this->assertContains("Bart and Amy", $answer);
    }

    /**
     * @test
     */
    public function itHandlesMoreThanTwoNames()
    {
        $answer = $this->getAnswerForMultipleNames(["Bart", "Amy", "Nicole"]);

        $this->assertContains("Bart, Amy, and Nicole", $answer);
    }

    /**
     * @test
     */
    public function itHandlesMultipleNamesBothNormalAndShouted()
    {
        $answer = $this->getAnswerForMultipleNames(["Bart", "AMY", "Nicole"]);

        $this->assertContains("Bart and Nicole. AND HELLO AMY!", $answer);
    }

    private function getAnswerForName(?string $name) : string
    {
        $bot = new GreetingBot();

        return $bot->greet($name);
    }

    private function getAnswerForMultipleNames(array $names) : string
    {
        $bot = new GreetingBot();

        return $bot->greet($names);
    }
}
