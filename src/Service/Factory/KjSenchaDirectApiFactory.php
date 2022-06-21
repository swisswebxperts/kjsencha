<?php

namespace KJSencha\Service\Factory;

use KJSencha\View\Helper\DirectApi;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\Config;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\Helper\HeadScript;
use Psr\Container\ContainerInterface;
use KJSencha\Frontend\Bootstrap;

class KjSenchaDirectApiFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {

        $pluginManager = $container->get(AbstractPluginManager::class);

        $config = $container->get(Config::class);

        /* @var $headScript HeadScript */
        $headScript = $pluginManager->get('headScript');

        /* @var $bootstrap Bootstrap */
        $bootstrap = $container->get('kjsencha.bootstrap');

        return new DirectApi($headScript, $bootstrap);
    }
}