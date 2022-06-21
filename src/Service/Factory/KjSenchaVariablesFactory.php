<?php

namespace KJSencha\Service\Factory;

use KJSencha\View\Helper\Variables;
use Laminas\Config\Config;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

use Laminas\View\Helper\HeadScript;
use KJSencha\Frontend\Bootstrap;

class KjSenchaVariablesFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {

        $pluginManager = $container->get(AbstractPluginManager::class);

        /* @var $headScript HeadScript */
        $headScript = $pluginManager->get('headScript');
        /* @var $bootstrap Bootstrap */
        $bootstrap = $pluginManager->get('kjsencha.bootstrap');

        return new Variables($headScript, $bootstrap);
    }
}