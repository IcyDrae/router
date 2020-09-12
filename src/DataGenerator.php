<?php


namespace Gjoni\Router;

use Gjoni\Router\Interfaces\DataGenerator as DataGeneratorInterface;

class DataGenerator implements DataGeneratorInterface
{

    # TODO: static and dynamic route generation through the DataGenerator

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
        /*if ($this->isStaticRoute($this->parsed)) {
            $this->generateStatic();
        } elseif($this->isDynamicRoute($this->parsed)) {
            $this->generateDynamic();
        }*/
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

    public function isStaticRoute($parsed)
    {

    }

    public function isDynamicRoute($parsed)
    {

    }

    private function generateStatic()
    {
        /*$parsedRoute[] = [
                "base" => $split[0],
                "argument" => (!empty($split[1]) ? $split[1] : NULL)
            ];*/
    }

    private function generateDynamic()
    {

    }
}
