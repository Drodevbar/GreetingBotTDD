<?php

namespace Kata\Helpers;

class NestedExtractor
{
    /**
     * @var array
     */
    private $nestedData;

    /**
     * @var array
     */
    private $extractedElementsBuffer;

    public function __construct(array $nestedData)
    {
        $this->nestedData = $nestedData;
        $this->extractedElementsBuffer = [];
    }

    public function extract() : array
    {
        foreach ($this->nestedData as $index => $cell) {
            if ($this->isIntentionallyNested($cell)) {
                $this->removeQuotes($index);
                continue;
            }

            $explodedElements = $this->getElementsWithoutWhitespaces($cell);

            if (count($explodedElements) > 1) {
                $this->extractedElementsBuffer[$index] = $explodedElements;
            }
        }
        return $this->getExtractedData();
    }

    private function getElementsWithoutWhitespaces(string $elements) : array
    {
        return array_map('trim', explode(',', $elements));
    }

    private function isIntentionallyNested(string $elements) : bool
    {
        return preg_match("/\".+\"/", $elements);
    }

    private function removeQuotes(int $index) : void
    {
        $this->nestedData[$index] = str_replace("\"", "", $this->nestedData[$index]);
    }

    private function getExtractedData() : array
    {
        foreach ($this->extractedElementsBuffer as $index => $data) {
            array_splice($this->nestedData, $index, 1, $data);
        }
        return $this->nestedData;
    }
}
