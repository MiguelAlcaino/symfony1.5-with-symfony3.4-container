<?php

namespace MiguelAlcaino\Action;

use sfConfig;
use sfEvent;
use sfInitializationException;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;

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

        // run action
        return $this->$actionToRun($request);
    }

}