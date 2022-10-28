<?php

namespace KJSencha\Service;

use KJSencha\Direct\Remoting\Api\CachedApi;
use KJSencha\Direct\Remoting\Api\ModuleApi;
use Laminas\Cache\Storage\StorageInterface;
use Laminas\Router\Http\RouteInterface;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Psr\Container\ContainerInterface;

class ModuleApiFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return ModuleApi
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        /* @var $apiFactory \KJSencha\Direct\Remoting\Api\Factory\ModuleFactory */
        $apiFactory = $serviceLocator->get('kjsencha.modulefactory');
        /* @var $cache StorageInterface */
        $cache = $serviceLocator->get('kjsencha.cache');
        /* @var $router RouteInterface */
        $router = $serviceLocator->get('Router');

        if ($cache->hasItem('module_api')) {
            $api = $this->buildFromArray($cache->getItem('module_api'));
        } else {
            $api = $apiFactory->buildApi($config['kjsencha']['direct']);
            $this->saveToCache($api, $cache);
        }

        // Setup the correct url from where to request data
        $api->setUrl($router->assemble(
            array('action'  => 'rpc'),
            array('name'    => 'kjsencha-direct')
        ));

        return $api;
    }

    /**
     * @param array $fetched
     * @return ModuleApi
     */
    protected function buildFromArray(array $fetched)
    {
        $api = new ModuleApi();

        foreach ($fetched as $name => $cachedModule) {
            $api->addModule($name, new CachedApi($cachedModule['config']));
        }

        return $api;
    }

    /**
     * @param ModuleApi $moduleApi
     * @param StorageInterface $cache
     */
    protected function saveToCache(ModuleApi $moduleApi, StorageInterface $cache)
    {
        $toStore = array();

        foreach ($moduleApi->getModules() as $name => $api) {
            $toStore[$name] = array(
                'config' => $api->toArray(),
            );
        }

        $cache->setItem('module_api', $toStore);
    }

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        // TODO: Implement __invoke() method.
    }
}