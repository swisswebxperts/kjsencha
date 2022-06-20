<?php

namespace KJSencha\Service;

use Interop\Container\ContainerInterface;
use Laminas\Cache\Storage\StorageInterface;
use Laminas\Config\Config;
use Laminas\Router\Http\RouteInterface;
use KJSencha\Direct\Remoting\Api\Api;
use Laminas\Http\PhpEnvironment\Request;
use KJSencha\Direct\Remoting\Api\Factory\ApiBuilder;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ApiFactory implements FactoryInterface
{

    /**
     * {@inheritDoc}
     *
     * @return Api
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /* @var $config array */
        $config = $container->get(Config::class);
        /* @var $cache StorageInterface */
        $cache = $container->get('kjsencha.cache');
        /* @var $router RouteInterface */
        $router = $container->get(RouteInterface::class);
        /* @var $api Api */
        $api = $cache->getItem($config['kjsencha']['cache_key'], $success);

        if (!$success) {
            /* @var $apiFactory ApiBuilder */
            $apiFactory = $container->get('kjsencha.apibuilder');
            /* @var $request Request */
            $request = $container->get('Request');
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
