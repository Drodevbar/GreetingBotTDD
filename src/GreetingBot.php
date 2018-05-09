<?php

namespace Kata;

class GreetingBot
{
    /**
     * @var ?string
     */
    private $name;

    public function greet(?string $name) : string
    {
        $this->name = $name;

        $response = $this->getResponseCall();

        return "Hello, {$response}.";
    }

    private function getResponseCall() : string
    {
        return $this->name ?? "my friend";
    }
}
