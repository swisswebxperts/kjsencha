<?php

namespace KJSencha\Service;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class ApiFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        /* @var $config array */
        $config = $container->get('Config');
        $cache =  $container->get('kjsencha.cache');
        $router = $container->get('HttpRouter');
        $api = $cache->getItem($config['kjsencha']['cache_key'], $success);

        if (!$success) {
            $apiFactory = $container->get('kjsencha.apibuilder');
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