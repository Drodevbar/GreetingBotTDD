<?php

namespace Kata;

use Kata\Helpers\NestedExtractor;

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
        $this->name = $this->getExtractedNamesIfGiven();

        $shoutedResponse = $this->getFormattedShoutedResponse();

        $normalResponse = $this->getFormattedNormalResponse();

        if ($normalResponse && $shoutedResponse) {
            return "$normalResponse AND $shoutedResponse";
        }
        return $normalResponse . $shoutedResponse;
    }

    private function getExtractedNamesIfGiven() : array
    {
        $extractor = new NestedExtractor($this->name);

        return $extractor->extract();
    }

    private function getFormattedShoutedResponse() : ?string
    {
        $shoutedNames = $this->getShoutedNamesIfGiven();

        return $shoutedNames ? ('HELLO ' . strtoupper($this->getFormattedNames($shoutedNames)) . '!') : null;
    }

    private function getFormattedNormalResponse() : ?string
    {
        return ($this->name) ? "Hello, {$this->getFormattedNames($this->name)}." : null;
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

    private function getFormattedNames(array $names) : ?string
    {
        if (empty($names)) {
            return null;
        }
        if (count($names) > 2) {
            return $this->formatMoreThanTwoNames($names);
        }
        return $this->formatExactlyTwoNames($names);
    }

    private function formatMoreThanTwoNames(array $names) : string
    {
        $firstNames = array_slice($names, 0, count($names) - 1);
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
