<?php

namespace KJSencha\Service;

use Interop\Container\ContainerInterface;
use Laminas\ModuleManager\ModuleManager;
use Laminas\Mvc\Service\ServiceManagerConfig;
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

        $config = array();
        $moduleManager = $container->get(ModuleManager::class);

        foreach ($moduleManager->getLoadedModules() as $module) {
            if (!is_callable(array($module, 'getComponentConfig'))) {
                continue;
            }

            $config = ArrayUtils::merge($config, $module->getComponentConfig());
        }

        $serviceConfig = new ServiceManagerConfig($config);
        $componentManager = new ComponentManager($serviceConfig);

        return $componentManager;
    }


}
