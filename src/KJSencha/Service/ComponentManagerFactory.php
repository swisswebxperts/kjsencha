<?php

namespace KJSencha\Service;

use Interop\Container\ContainerInterface;
use Laminas\ModuleManager\ModuleManager;
use Laminas\Mvc\Service\ServiceManagerConfig;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\Stdlib\ArrayUtils;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * ComponentManager Factory
 *
 * The factory will look through the currently loaded modules and checks for every module
 * if the method `getComponentConfig()` exists. It merges the results from all modules and
 * uses this as configuration for the ServiceManager
 */
class ComponentManagerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
       $this->createService($container);
    }

    /**
     * @param ContainerInterface $container
     * @return \KJSencha\Service\ComponentManager
     */
    public function createService(ContainerInterface $container)
    {
        $serviceConfig = $this->createConfig($container);
        $componentManager = new ComponentManager($serviceConfig);
        //$componentManager->addPeeringServiceManager($container);
        return $componentManager;
    }

    /**
     * @param ContainerInterface $container
     * @return ServiceManagerConfig
     */
    public function createConfig(ContainerInterface $container)
    {
        $config = array();
        $moduleManager = $container->get(ModuleManager::class);

        foreach ($moduleManager->getLoadedModules() as $module) {
            if (!is_callable(array($module, 'getComponentConfig'))
            ) {
                continue;
            }

            $config = ArrayUtils::merge($config, $module->getComponentConfig());
        }

        return new ServiceManagerConfig($config);
    }
}
