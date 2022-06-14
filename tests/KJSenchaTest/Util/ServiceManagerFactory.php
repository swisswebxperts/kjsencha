<?php

namespace KJSenchaTest\Util;

use Laminas\ModuleManager\Listener\ServiceListener;
use Laminas\ModuleManager\ModuleManager;
use Laminas\Mvc\Service\ServiceListenerFactory;
use Laminas\ServiceManager\Config;
use Laminas\ServiceManager\ServiceManager;
use Laminas\Mvc\Service\ServiceManagerConfig;

/**
 * Utility used to retrieve a freshly bootstrapped application's service manager
 *
 * @author  Marco Pivetta <ocramius@gmail.com>
 */
class ServiceManagerFactory
{
    /**
     * @var array
     */
    protected static $config;

    /**
     * @param array $config
     */
    public static function setConfig(array $config)
    {
        static::$config = $config;
    }

    /**
     * Builds a new service manager
     */
    public static function getServiceManager()
    {

        $config = include __DIR__.'/../../../config/services.config.php';

        $serviceManagerConfig = new Config($config);
        $serviceManager = new ServiceManager();
        $serviceManager->setAllowOverride(true);
        $serviceManagerConfig->configureServiceManager($serviceManager);
        $serviceManager->setService('config', $config);

        /** @var $moduleManager ModuleManager */
        //$moduleManager = $serviceManager->get(ModuleManager::class);
        // $moduleManager->loadModules();

        return $serviceManager;
    }
}
