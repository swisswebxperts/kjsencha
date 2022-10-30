<?php

namespace KJSencha;

use KJSencha\View\Helper\ExtJS;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\View\Helper\HeadLink;
use Laminas\View\Helper\HeadScript;


return array(
    'factories' => array(
        'extJs' => function($pluginManager) {
            $config = $pluginManager->getServiceLocator()->get('Config');

            return new ExtJS(
                $config['kjsencha']['library_path'],
                $pluginManager->get(HeadLink::class),
                $pluginManager->get(HeadScript::class)
            );
        },
    )
);