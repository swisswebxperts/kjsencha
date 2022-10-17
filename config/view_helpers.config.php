<?php

namespace KJSencha;

use KJSencha\View\Helper\ExtJS;
use KJSencha\View\Helper\Variables;
use KJSencha\View\Helper\LoaderConfig;
use KJSencha\View\Helper\DirectApi;
use Psr\Container\ContainerInterface;

use Laminas\View\Helper\HeadLink;
use Laminas\View\Helper\HeadScript;
use KJSencha\Frontend\Bootstrap;

return array(
    'factories' => array(
        'extJs' => function($pluginManager, ContainerInterface $container) {

            $config = $container->get("Config");

            /* @var $headLink HeadLink */
            $headLink = $pluginManager->get('headLink');
            /* @var $headScript HeadScript */
            $headScript = $pluginManager->get('headScript');

            return new ExtJS($config['kjsencha'], $headLink, $headScript);
        },
        'kjSenchaVariables' => function($pluginManager, ContainerInterface $container) {
            /* @var $headScript HeadScript */
            $headScript = $pluginManager->get('headScript');
            /* @var $bootstrap Bootstrap */
            $bootstrap = $container->get('kjsencha.bootstrap');

            return new Variables($headScript, $bootstrap);
        },
        'kjSenchaLoaderConfig' => function($pluginManager, ContainerInterface $container) {
            /* @var $basePath \Laminas\View\Helper\BasePath */
            $basePath = $pluginManager->get('basePath');
            /* @var $headScript \Laminas\View\Helper\HeadScript */
            $headScript = $pluginManager->get('headScript');
            /* @var $bootstrap \KJSencha\Frontend\Bootstrap */
            $bootstrap = $container->get('kjsencha.bootstrap');

            return new LoaderConfig($basePath, $headScript, $bootstrap);
        },
        'kjSenchaDirectApi' => function($pluginManager, ContainerInterface $container) {
            /* @var $headScript \Laminas\View\Helper\HeadScript */
            $headScript = $pluginManager->get('headScript');
            /* @var $bootstrap \KJSencha\Frontend\Bootstrap */
            $bootstrap = $container->get('kjsencha.bootstrap');

            return new DirectApi($headScript, $bootstrap);
        },
    )
);