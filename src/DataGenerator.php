<?php


namespace Route;

use Route\Interfaces\DataGenerator as DataGeneratorInterface;

class DataGenerator implements DataGeneratorInterface
{

    private array $parsed;

    /**
     * @param array $parsed
     */
    public function addRoute(array $parsed)
    {
        return $this->setParsed($parsed);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->getParsed();
    }

    /**
     * @return array
     */
    public function getParsed(): array
    {
        return $this->parsed;
    }

    /**
     * @param array $parsed
     */
    public function setParsed(array $parsed)
    {
        $this->parsed = $parsed;
    }
}
