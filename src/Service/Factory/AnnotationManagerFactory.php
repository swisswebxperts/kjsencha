<?php

namespace KJSencha\Service\Factory;

use KJSencha\Annotation\Formhandler;
use KJSencha\Annotation\Interval;
use KJSencha\Annotation\Remotable;
use Laminas\Code\Annotation\AnnotationManager;
use Laminas\Code\Annotation\Parser\DoctrineAnnotationParser;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class AnnotationManagerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): ?DoctrineAnnotationParser
    {
        $doctrineParser = new DoctrineAnnotationParser();
        $doctrineParser->registerAnnotation(  Remotable::class);
        $doctrineParser->registerAnnotation(    Interval::class);
        $doctrineParser->registerAnnotation(Formhandler::class);
        $annotationManager = new AnnotationManager();
        $annotationManager->attach($doctrineParser);
        return $annotationManager;
    }
}