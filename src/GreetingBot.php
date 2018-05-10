<?php

namespace Kata;

class GreetingBot
{
    /**
     * @var string|array|null
     */
    private $name;

    /**
     * @param string|array|null $name
     * @return string
     */
    public function greet($name) : string
    {
        $this->name = $name;

        return $this->getResponseCall();
    }

    private function getResponseCall() : string
    {
        if (is_array($this->name)) {
            return $this->getResponseForMultipleNames();
        }
        return $this->getResponseForSingleName();
    }

    private function getResponseForMultipleNames() : string
    {
        $shoutedResponse = $this->getFormattedShoutedResponse();

        $response = "Hello, {$this->getFormattedNames($this->name)}.";

        return "{$response} AND {$shoutedResponse}";
    }

    private function getFormattedShoutedResponse() : string
    {
        $shoutedNames = $this->getShoutedNamesIfGiven();

        return $shoutedNames ? ('HELLO ' . strtoupper($this->getFormattedNames($shoutedNames)) . '!') : "";
    }

    private function getShoutedNamesIfGiven() : ?array
    {
        $shoutedNames = [];

        foreach ($this->name as $index => $name) {
            if (ctype_upper($name)) {
                unset($this->name[$index]);
                $shoutedNames[] = $name;
            }
        }
        return $shoutedNames ?? null;
    }

    private function getFormattedNames(array $names) : string
    {
        if (count($names) > 2) {
            return $this->formatMoreThanTwoNames($names);
        }
        return $this->formatExactlyTwoNames($names);
    }

    private function formatMoreThanTwoNames(array $names) : string
    {
        $firstNames = array_slice($this->name, 0, count($names) - 1);
        $lastName = end($names);

        return implode(", ", $firstNames) . ", and {$lastName}";
    }

    private function formatExactlyTwoNames(array $names) : string
    {
        return implode(" and ", $names);
    }

    private function getResponseForSingleName() : string
    {
        if ($this->name) {
            return $this->getResponseForGivenName();
        }
        return $this->getResponseForNullName();
    }

    private function getResponseForGivenName() : string
    {
        if (ctype_upper($this->name)) {
            return $this->getResponseForShoutedName($this->name);
        }
        return "Hello, {$this->name}.";
    }

    private function getResponseForShoutedName(string $name) : string
    {
        return "HELLO {$name}!";
    }

    private function getResponseForNullName() : string
    {
        return "Hello, my friend.";
    }
}
