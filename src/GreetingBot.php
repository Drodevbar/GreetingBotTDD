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
        $shoutedName = $this->getShoutedNameIfGiven();

        if ($shoutedName) {
            $this->removeShoutedNameFromAllNames($shoutedName);
        }

        if (count($this->name) > 2) {
            $response = $this->getResponseForMoreThanTwoNames();
        } else {
            $response = $this->getResponseForExactlyTwoNames();
        }

        return $shoutedName ? ($response . " AND {$this->getResponseForShoutedName($shoutedName)}") : $response;
    }

    private function getShoutedNameIfGiven() : ?string
    {
        foreach ($this->name as $name) {
            if (ctype_upper($name)) {
                return $name;
            }
        }
        return null;
    }

    private function removeShoutedNameFromAllNames(string $shoutedName) : void
    {
        $shoutedNameIndex = array_search($shoutedName, $this->name);

        unset($this->name[$shoutedNameIndex]);

        $this->name = array_values($this->name);
    }

    private function getResponseForMoreThanTwoNames() : string
    {
        $firstNames = array_slice($this->name, 0, count($this->name) - 1);
        $lastName = end($this->name);
        $names = implode(", ", $firstNames) . ", and {$lastName}";

        return "Hello, {$names}.";
    }

    private function getResponseForExactlyTwoNames() : string
    {
        $names = implode(" and ", $this->name);

        return "Hello, {$names}.";
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
