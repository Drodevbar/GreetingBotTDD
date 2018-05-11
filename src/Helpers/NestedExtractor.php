<?php

namespace Kata\Helpers;

class NestedExtractor
{
    /**
     * @var array
     */
    private $nestedData;

    public function __construct(array $nestedData)
    {
        $this->nestedData = $nestedData;
    }

    public function extract() : array
    {
        foreach ($this->nestedData as $index => &$cell) {
            if ($this->checkIfIntentionallyNested($cell)) {
                $this->removeQuotes($index);
                continue;
            }

            $potentiallyNested = $this->getElementsWithoutWhitespaces($cell);

            if (count($potentiallyNested) > 1) {
                $this->putElementsInSpecifiedIndex($potentiallyNested, $index);
            }
        }
        return $this->nestedData;
    }

    private function getElementsWithoutWhitespaces(string $elements) : array
    {
        return array_map('trim', explode(',', $elements));
    }

    private function checkIfIntentionallyNested(string $elements) : bool
    {
        return preg_match("/\".+\"/", $elements);
    }

    private function removeQuotes(int $index) : void
    {
        $this->nestedData[$index] = str_replace("\"", "", $this->nestedData[$index]);
    }

    private function putElementsInSpecifiedIndex(array &$elements, int $index) : void
    {
        array_splice($this->nestedData, $index, count($elements), $elements);
    }
}
