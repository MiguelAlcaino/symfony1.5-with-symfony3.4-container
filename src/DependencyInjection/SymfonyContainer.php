<?php

namespace MiguelAlcaino\DependencyInjection;

use Symfony\Component\DependencyInjection\Container;

class SymfonyContainer extends Container implements \sfServiceContainerInterface
{
    /**
     * @param string $id
     *
     * @return object
     * @throws \Exception
     */
    public function getService($id)
    {
        return $this->get($id);
    }

    /**
     * @param string $id
     * @param object $service
     */
    public function setService($id, $service)
    {
        return $this->set($id, $service);
    }

    public function getParameters()
    {
        $this->parameterBag->all();
    }

    public function setParameters(array $parameters)
    {
        foreach ($parameters as $key => $parameter) {
            $this->setParameter($key, $parameter);
        }
    }

    public function addParameters(array $parameters)
    {
        $this->setParameters($parameters);
    }

    public function hasService($id)
    {
        return $this->has($id);
    }

}