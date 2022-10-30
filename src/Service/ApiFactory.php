<?php

namespace KJSencha\Service;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\ServiceManager\ServiceManager;
use Psr\Container\ContainerInterface;

class ApiFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $this->createService($container->get(ServiceManager::class));
    }

    /**
     * Create service
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $config array */
        $config = $serviceLocator->get('Config');
        $cache = $serviceLocator->get('kjsencha.cache');
        $router = $serviceLocator->get('HttpRouter');
        $api = $cache->getItem($config['kjsencha']['cache_key'], $success);

        if (!$success) {
            $apiFactory = $serviceLocator->get('kjsencha.apibuilder');
            $request = $serviceLocator->get('Request');
            $api = $apiFactory->buildApi($config['kjsencha']['direct']);
            $url = $request->getBasePath() . $router->assemble(
                    array('action' => 'rpc'),
                    array('name'   => 'kjsencha-direct')
                );
            $api->setUrl($url);
            $cache->setItem($config['kjsencha']['cache_key'], $api);
        }

        return $api;
    }

}