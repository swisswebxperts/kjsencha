<?php

namespace KJSencha\Service\Factory;

use KJSencha\View\Helper\LoaderConfig;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

use Laminas\View\Helper\BasePath;
use Laminas\View\Helper\HeadScript;
use KJSencha\Frontend\Bootstrap;

class kjSenchaLoaderConfigFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
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