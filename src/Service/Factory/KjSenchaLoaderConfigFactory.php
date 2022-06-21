<?php

namespace KJSencha\Service\Factory;

use KJSencha\View\Helper\LoaderConfig;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

use Laminas\View\Helper\BasePath;
use Laminas\View\Helper\HeadScript;
use KJSencha\Frontend\Bootstrap;

class KjSenchaLoaderConfigFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): ?LoaderConfig
    {

        $pluginManager = $container->get(AbstractPluginManager::class);

        /* @var $basePath BasePath */
        $basePath = $pluginManager->get('basePath');

        /* @var $headScript HeadScript */
        $headScript = $pluginManager->get('headScript');

        /* @var $bootstrap Bootstrap */
        $bootstrap = $pluginManager->get('kjsencha.bootstrap');

        return new LoaderConfig($basePath, $headScript, $bootstrap);
    }
}