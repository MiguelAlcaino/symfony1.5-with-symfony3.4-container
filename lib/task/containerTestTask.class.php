<?php

class containerTestTask extends sfBaseTask
{
    protected function configure()
    {
        // // add your own arguments here
        // $this->addArguments(array(
        //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
        // ));

        $this->addOptions(
            [
                new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'amboss'),
                new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
                new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
                // add your own options here
            ]
        );

        $this->namespace           = 'mao';
        $this->name                = 'test';
        $this->briefDescription    = '';
        $this->detailedDescription = <<<EOF
The [containerTest|INFO] task does things.
Call it with:

  [php symfony containerTest|INFO]
EOF;
    }

    protected function execute($arguments = [], $options = [])
    {
        $this->log('HOLA');
        $logger = $this->getService('logger');

        $message = $logger->log('CHAOOOOOOOOO');

        $this->log($message);
    }
}
