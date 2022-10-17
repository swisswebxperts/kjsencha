<?php

namespace KJSencha;

use KJSencha\View\Helper\ExtJS;
use KJSencha\View\Helper\Variables;
use KJSencha\View\Helper\LoaderConfig;
use KJSencha\View\Helper\DirectApi;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\PluginManagerInterface;
use Psr\Container\ContainerInterface;

use Laminas\View\Helper\HeadLink;
use Laminas\View\Helper\HeadScript;
use KJSencha\Frontend\Bootstrap;
use Laminas\View\Helper\BasePath;

return array(
    'factories' => array(
        'extJs' => function($pluginManager) {

            /** @var $pluginManager AbstractPluginManager  */
            $config = $pluginManager->getServiceLocator()->get("Config");

            /* @var $headLink HeadLink */
            $headLink = $pluginManager->get('headLink');
            /* @var $headScript HeadScript */
            $headScript = $pluginManager->get('headScript');

            return new ExtJS($config['kjsencha'], $headLink, $headScript);
        },
        'kjSenchaVariables' => function($pluginManager) {
            /* @var $headScript HeadScript */
            $headScript = $pluginManager->get('headScript');
            /* @var $bootstrap Bootstrap */
            $bootstrap = $pluginManager->getServiceLocator()->get('kjsencha.bootstrap');

            return new Variables($headScript, $bootstrap);
        },
        'kjSenchaLoaderConfig' => function($pluginManager) {
            /* @var $basePath BasePath */
            $basePath = $pluginManager->get('basePath');
            /* @var $headScript HeadScript */
            $headScript = $pluginManager->get('headScript');
            /* @var $bootstrap Bootstrap */
            $bootstrap = $pluginManager->getServiceLocator()->get('kjsencha.bootstrap');

            return new LoaderConfig($basePath, $headScript, $bootstrap);
        },
        'kjSenchaDirectApi' => function($pluginManager) {
            /* @var $headScript \Laminas\View\Helper\HeadScript */
            $headScript = $pluginManager->get('headScript');
            /* @var $bootstrap \KJSencha\Frontend\Bootstrap */
            $bootstrap = $pluginManager->getServiceLocator()->get('kjsencha.bootstrap');

            return new DirectApi($headScript, $bootstrap);
        },
    )
);