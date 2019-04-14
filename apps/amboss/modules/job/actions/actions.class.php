<?php

use MiguelAlcaino\Action\BaseAction;

/**
 * job actions.
 *
 * @package    jobbet2
 * @subpackage job
 * @author     Your name here
 * @version    SVN: $Id$
 */
class jobActions extends BaseAction
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $logger = $this->getService(\MiguelAlcaino\Service\Logger::class);

        $this->getResponse()->setContent(json_encode(['hola' => 'pianola', 'logger' => $logger->log('HOLANDAQUETALCA')]));

        return sfView::NONE;
    }
}
