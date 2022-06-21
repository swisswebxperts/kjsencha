<?php

namespace KJSencha\View\Helper\Factory;

use KJSencha\View\Helper\LoaderConfig;
use Psr\Container\ContainerInterface;
use Laminas\View\Helper\BasePath;
use Laminas\View\Helper\HeadScript;
use KJSencha\Frontend\Bootstrap;

class LoaderConfigFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): ?LoaderConfig
    {
        /* @var $basePath BasePath */
        $basePath = $container->get('basePath');
        /* @var $headScript HeadScript */
        $headScript = $container->get('headScript');
        /* @var $bootstrap Bootstrap */
        $bootstrap = $container->get('kjsencha.bootstrap');

        return new LoaderConfig($basePath, $headScript, $bootstrap);
    }
}