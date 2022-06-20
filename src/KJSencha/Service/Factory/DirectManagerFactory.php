<?php

namespace KJSencha\Service\Factory;

use KJSencha\Direct\DirectManager;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class DirectManagerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $directManager = new DirectManager();
        //$directManager->addPeeringServiceManager($sm);

        return $directManager;
    }
}