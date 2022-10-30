<?php

namespace KJSencha;

use KJSencha\View\Helper\ExtJS;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\View\Helper\BasePath;
use Laminas\View\Helper\HeadLink;
use Laminas\View\Helper\HeadScript;
use KJSencha\View\Helper\Variables;
use KJSencha\View\Helper\LoaderConfig;
use KJSencha\View\Helper\DirectApi;


return array(
    'factories' => array(
        'extJs' => function($pluginManager) {
            $config = $pluginManager->getServiceLocator()->get('Config');

            $headLink = $pluginManager->get(HeadLink::class);

            $headScript = $pluginManager->get(HeadScript::class);

            return new ExtJS($config['kjsencha'], $headLink, $headScript);
        },
        'kjSenchaVariables' => function(AbstractPluginManager $pluginManager) {
            $headScript = $pluginManager->get(HeadScript::class);

            $bootstrap = $pluginManager->getServiceLocator()->get('kjsencha.bootstrap');

            return new Variables($headScript, $bootstrap);
        },
        'kjSenchaLoaderConfig' => function(AbstractPluginManager $pluginManager) {
            $basePath = $pluginManager->get(BasePath::class);

            $headScript = $pluginManager->get(HeadScript::class);

            $bootstrap = $pluginManager->getServiceLocator()->get('kjsencha.bootstrap');

            return new LoaderConfig($basePath, $headScript, $bootstrap);
        },
        'kjSenchaDirectApi' => function(AbstractPluginManager $pluginManager) {

            $headScript = $pluginManager->get(HeadScript::class);

            $bootstrap = $pluginManager->getServiceLocator()->get('kjsencha.bootstrap');

            return new DirectApi($headScript, $bootstrap);
        },
    )
);