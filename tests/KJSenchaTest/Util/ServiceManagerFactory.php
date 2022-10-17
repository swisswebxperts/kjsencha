<?php

namespace KJSenchaTest\Util;

use KJSencha\Util\DeveloperDebug;
use Laminas\ModuleManager\ModuleManagerInterface;
use Laminas\ServiceManager\ServiceManager;
use Laminas\ModuleManager\ModuleManager;

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

        $serviceManager = new ServiceManager(isset(static::$config['service_manager']) ? static::$config['service_manager'] : array());
        $serviceManager->setService('ApplicationConfig', static::$config);
        $serviceManager->setFactory('ServiceListener', 'Laminas\Mvc\Service\ServiceListenerFactory');

        /** @var $moduleManager ModuleManager */
        $moduleManager = $serviceManager->get(ModuleManagerInterface::class);

        $moduleManager->loadModules();

        return $serviceManager;
    }
}
