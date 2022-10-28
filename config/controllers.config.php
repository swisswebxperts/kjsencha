<?php

namespace KJSencha;

use Laminas\ServiceManager\AbstractPluginManager;
use KJSencha\Controller\DirectController;

return array(
    'factories' => array(
        'kjsencha_direct' => function(AbstractPluginManager $pluginManager)
        {
            $sl = $pluginManager->getServiceLocator();
            return new DirectController($sl->get('kjsencha.direct.manager'));
        },
    )
);