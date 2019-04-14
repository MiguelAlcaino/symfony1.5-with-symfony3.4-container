<?php

namespace MiguelAlcaino\Service;

class Mailer
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * Mailer constructor.
     *
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param $to
     * @param $body
     *
     * @return string|null
     */
    public function send($to, $body)
    {
        return $this->logger->log(sprintf('Email sent to %s with body %s', $to, $body));
    }
}