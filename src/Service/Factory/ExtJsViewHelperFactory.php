<?php

namespace KJSencha\Service\Factory;

use KJSencha\View\Helper\ExtJS;
use Laminas\Config\Config;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

use Laminas\View\Helper\HeadLink;
use Laminas\View\Helper\HeadScript;

class ExtJsViewHelperFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $config = $container->get(Config::class);

        $pluginManager = $container->get(AbstractPluginManager::class);

        /* @var $headLink HeadLink */
        $headLink = $pluginManager->get('headLink');
        /* @var $headScript HeadScript */
        $headScript = $pluginManager->get('headScript');

        return new ExtJS($config['kjsencha'], $headLink, $headScript);
    }
}