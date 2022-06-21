<?php

namespace KJSencha\Controller\Factory;

use KJSencha\Controller\DataController;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

use KJSencha\Service\ComponentManager;

class KjSenchaDataFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        /* @var $componentManager ComponentManager */
        $componentManager = $container->get('kjsencha.componentmanager');
        return new DataController($componentManager);
    }
}