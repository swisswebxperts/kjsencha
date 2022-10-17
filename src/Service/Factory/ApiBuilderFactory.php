<?php

namespace KJSencha\Service\Factory;

use KJSencha\Direct\DirectManager;
use KJSencha\Direct\Remoting\Api\Factory\ApiBuilder;
use Laminas\Code\Annotation\AnnotationManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class ApiBuilderFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): ?ApiBuilder
    {
        /* @var $annotationManager AnnotationManager */
        $annotationManager = $container->get('kjsencha.annotationmanager');
        /* @var $directManager DirectManager */
        $directManager = $container->get('kjsencha.direct.manager');

        return new ApiBuilder($annotationManager, $directManager);
    }
}