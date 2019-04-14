<?php

use MiguelAlcaino\Action\BaseAction;
use MiguelAlcaino\Service\Logger;
use MiguelAlcaino\Service\Mailer;

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
     * @param sfWebRequest $request
     * @param Logger       $logger
     *
     * @return string
     */
    public function executeIndex(sfWebRequest $request, Logger $logger, Mailer $mailer)
    {
        $this->getResponse()->setContent(json_encode(['message' => 'hello', 'logger' => $logger->log('FROM LOGGER'), 'mailer' => $mailer->send('mao@medicuja.com','Hello Miguel')]));

        return sfView::NONE;
    }
}
