<?php

namespace KJSenchaTestAsset\Direct;

use KJSenchaTestAsset\Service\EchoService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Psr\Container\ContainerInterface;

/**
 * Service Action which has access to the service layer
 */
class ServiceAction implements FactoryInterface
{
    protected $sl;

    public function __construct()
    {

    }

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $this->sl = $container->get(ServiceLocatorInterface::class);
    }

    public function getServiceLocator()
    {
        return $this->sl;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->sl = $serviceLocator;
    }


    public function getServiceResult()
    {

        /* @var $echoService EchoService */
        $echoService = $this->getServiceLocator()->get('echo');

        return $echoService->ping();
    }


}