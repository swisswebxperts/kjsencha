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
        /* @var $cache \Zend\Cache\Storage\StorageInterface */
        $cache = $serviceLocator->get('kjsencha.cache');
        /* @var $router \Zend\Mvc\Router\Http\RouteInterface */
        $router = $serviceLocator->get('HttpRouter');
        /* @var $api \KJSencha\Direct\Remoting\Api\Api */
        $api = $cache->getItem($config['kjsencha']['cache_key'], $success);

        if (!$success) {
            /* @var $apiFactory \KJSencha\Direct\Remoting\Api\Factory\ApiBuilder */
            $apiFactory = $serviceLocator->get('kjsencha.apibuilder');
            /* @var $request \Zend\Http\PhpEnvironment\Request */
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