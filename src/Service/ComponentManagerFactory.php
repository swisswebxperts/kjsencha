<?php

namespace KJSencha\Service;

use Laminas\Mvc\Service\ServiceManagerConfig;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\Stdlib\ArrayUtils;
use Psr\Container\ContainerInterface;

/**
 * ComponentManager Factory
 *
 * The factory will look through the currently loaded modules and checks for every module
 * if the method `getComponentConfig()` exists. It merges the results from all modules and
 * uses this as configuration for the ServiceManager
 */
class ComponentManagerFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return \KJSencha\Service\ComponentManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceConfig = $this->createConfig($serviceLocator);
        $componentManager = new ComponentManager($serviceConfig);
        $componentManager->addPeeringServiceManager($serviceLocator);
        return $componentManager;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return ServiceManagerConfig
     */
    public function createConfig(ServiceLocatorInterface $serviceLocator)
    {
        $config = array();
        $moduleManager = $serviceLocator->get('ModuleManager');

        foreach ($moduleManager->getLoadedModules() as $module) {
            if (!is_callable(array($module, 'getComponentConfig'))
            ) {
                continue;
            }

            $config = ArrayUtils::merge($config, $module->getComponentConfig());
        }

        return new ServiceManagerConfig($config);
    }

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        // TODO: Implement __invoke() method.
    }
}