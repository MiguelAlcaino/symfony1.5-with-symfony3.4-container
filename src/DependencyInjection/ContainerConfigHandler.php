<?php

namespace MiguelAlcaino\DependencyInjection;

use sfConfig;
use sfYamlConfigHandler;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ContainerConfigHandler extends sfYamlConfigHandler
{
    public function execute($configFiles)
    {
        $class = sfConfig::get('sf_app') . '_' . sfConfig::get('sf_environment') . 'ServiceContainer';

        $container = new ContainerBuilder();
        $loader    = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../'));
        $loader->load('config/services.yml');

        $container->compile();

        $dumper = new PhpDumper($container);

        $retval = sprintf(
            // "// auto-generated by ContainerConfigHandler\n" .
            // "// date: %s\n\n" .
            // "if (!class_exists(\$class, false)) {\n" .
            "%s\n" .
            // "}\n" .
            "\$class = '%s';\n" .
            "return \$class;\n\n",
            $dumper->dump(
                [
                    'class' => $class,
                    'base_class' => $this->parameterHolder->get('base_class')
                ]
            ),
            $class
        );

        return $retval;
    }
}