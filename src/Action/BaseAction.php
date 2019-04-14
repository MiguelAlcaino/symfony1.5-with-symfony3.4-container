<?php

namespace MiguelAlcaino\Action;

use sfConfig;
use sfEvent;
use sfInitializationException;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class BaseAction extends \sfActions
{

    public function execute($request)
    {
        // dispatch action
        $actionToRun = 'execute'.ucfirst($this->getActionName());

        if ($actionToRun === 'execute')
        {
            // no action given
            throw new sfInitializationException(sprintf('sfAction initialization failed for module "%s". There was no action given.', $this->getModuleName()));
        }

        if (!is_callable(array($this, $actionToRun)))
        {
            // action not found
            throw new sfInitializationException(sprintf('sfAction initialization failed for module "%s", action "%s". You must create a "%s" method.', $this->getModuleName(), $this->getActionName(), $actionToRun));
        }

        if (sfConfig::get('sf_logging_enabled'))
        {
            $this->dispatcher->notify(new sfEvent($this, 'application.log', array(sprintf('Call "%s->%s()"', get_class($this), $actionToRun))));
        }

        $arguments = [];
        foreach ($this->getArgumentsMetadata($this, $actionToRun) as $argumentMetadata) {
            if ($argumentMetadata->getType() === \sfWebRequest::class) {
                $arguments[] = $request;
            } elseif ($this->getServiceContainer()->hasService($argumentMetadata->getType())) {
                $arguments[] = $this->getService($argumentMetadata->getType());
            } else {
                throw new \LogicException(sprintf('Unable to resolve %s. It should be defined as a Service.', $argumentMetadata->getType()));
            }
        }

        // run action
        return $this->$actionToRun(... $arguments);
    }

    /**
     * Returns a Collection of ArgumentMetadata based a Symfony1 controller instance and an action name
     *
     * @param $controller
     * @param $action
     *
     * @return ArgumentMetadata[]
     * @throws \ReflectionException
     */
    private function getArgumentsMetadata($controller, $action)
    {
        $reflection = new \ReflectionMethod($controller, $action);
        $arguments  = [];
        foreach ($reflection->getParameters() as $param) {
            $arguments[] = new ArgumentMetadata(
                $param->getName(),
                $this->getType($param, $reflection),
                $param->isVariadic(),
                $param->isDefaultValueAvailable(),
                $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null,
                $param->allowsNull()
            );
        }

        return $arguments;
    }

    /**
     * Returns an associated type to the given parameter if available.
     *
     * @param \ReflectionParameter        $parameter
     * @param \ReflectionFunctionAbstract $function
     *
     * @return string|null
     */
    private function getType(\ReflectionParameter $parameter, \ReflectionFunctionAbstract $function)
    {
        if (!$type = $parameter->getType()) {
            return;
        }
        $name   = $type->getName();
        $lcName = strtolower($name);

        if ('self' !== $lcName && 'parent' !== $lcName) {
            return $name;
        }
        if (!$function instanceof \ReflectionMethod) {
            return;
        }
        if ('self' === $lcName) {
            return $function->getDeclaringClass()->name;
        }
        if ($parent = $function->getDeclaringClass()->getParentClass()) {
            return $parent->name;
        }
    }

}