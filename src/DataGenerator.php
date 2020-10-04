<?php


namespace Gjoni\Router;

use Gjoni\Router\Interfaces\DataGenerator as DataGeneratorInterface;

class DataGenerator implements DataGeneratorInterface
{
    private array $parsed;

    /**
     * @param array $route
     */
    public function addRoute(array $route)
    {
        return $this->setParsed($route);
    }

    /**
     * @return array|string|void
     */
    public function getData()
    {
        if ($this->isDynamicRoute()) {
            return $this->generateDynamic();
        } elseif ($this->isStaticRoute()) {
            return $this->generateStatic();
        } else {
            return $this->routeEmpty();
        }
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

    /**
     * @return bool|void
     */
    public function isStaticRoute()
    {
        if (array_filter(array_keys($this->getParsed()), 'is_int')) {
            return true;
        }
    }

    /**
     * @return bool|void
     */
    public function isDynamicRoute()
    {
        if (array_filter(array_keys($this->getParsed()), 'is_string')) {
            return true;
        }
    }

    private function generateStatic()
    {
        return ["static" => $this->getParsed()];
    }

    /**
     * @return array
     */
    private function generateDynamic()
    {
        $replacedRoute = $this->getParsed()[0];
        $filtered = array_filter(array_keys($this->getParsed()), 'is_string');
        $flipped = array_flip($filtered);

        $params = array_intersect_key($this->getParsed(), $flipped);

        return [
            "dynamic" => [
                "route" => $replacedRoute,
                "params" => $params
            ]
        ];
    }

    /**
     * @return array|void
     */
    public function routeEmpty()
    {
        if (empty($this->getParsed())) {
            return [];
        }
    }
}
