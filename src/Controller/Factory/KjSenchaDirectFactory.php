<?php

namespace KJSencha\Controller\Factory;

use KJSencha\Controller\DirectController;
use Laminas\Config\Config;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

use KJSencha\Direct\DirectManager;
use KJSencha\Direct\Remoting\Api\Api;

class KjSenchaDirectFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {

        $config = $container->get(Config::class);

        /* @var $manager DirectManager */
        $manager = $config->get('kjsencha.direct.manager');

        /* @var $apiFactory Api */
        $apiFactory = $container->get('kjsencha.api');

        $controller = new DirectController($manager, $apiFactory);
        $controller->setDebugMode($config['kjsencha']['debug_mode']);

        return $controller;
    }
}