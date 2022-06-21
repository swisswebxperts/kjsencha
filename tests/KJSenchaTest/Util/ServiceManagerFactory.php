<?php

namespace KJSenchaTest\Util;

use Laminas\ModuleManager\Listener\ServiceListenerInterface;
use Laminas\ModuleManager\ModuleManagerInterface;
use Laminas\Mvc\ApplicationInterface;
use Laminas\Mvc\Service\ServiceListenerFactory;
use Laminas\Mvc\Service\ServiceManagerConfig;
use Laminas\ServiceManager\ServiceManager;

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

        $array = isset(static::$config['service_manager']) ? static::$config['service_manager'] : [];

        $serviceManagerConfig = new ServiceManagerConfig($array);

        $serviceManager = new ServiceManager($array);
        $serviceManager->setService(ApplicationInterface::class, static::$config);
        $serviceManager->setFactory(ServiceListenerInterface::class, ServiceListenerFactory::class);

        $moduleManager = $serviceManager->getServiceLocator()->get(ModuleManagerInterface::class);
        $moduleManager->loadModules();

        return $serviceManager;
    }
}
