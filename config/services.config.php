<?php

namespace KJSencha;

use KJSencha\Frontend\Bootstrap;
use KJSencha\Direct\Remoting\Api\Factory\ModuleFactory;
use KJSencha\Direct\DirectManager;

use Laminas\Cache\Service\StorageAdapterFactoryInterface;
use Laminas\Code\Annotation\AnnotationManager;
use Laminas\Code\Annotation\Parser\DoctrineAnnotationParser;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\ServiceManager\ServiceManager;

return array(
    'aliases' => array(
        'kjsencha.api' => 'kjsencha.api.module',
    ),
    'factories' => array(
        'kjsencha.config' => 'KJSencha\Service\ModuleConfigurationFactory',

        'kjsencha.api.module' => 'KJSencha\Service\ModuleApiFactory',

        'kjsencha.annotationmanager' => function(ServiceLocatorInterface $sl) {
            $doctrineParser = new DoctrineAnnotationParser();
            $doctrineParser->registerAnnotation('KJSencha\Annotation\Remotable');
            $doctrineParser->registerAnnotation('KJSencha\Annotation\Interval');
            $doctrineParser->registerAnnotation('KJSencha\Annotation\Formhandler');
            $doctrineParser->registerAnnotation('KJSencha\Annotation\Group');
            $annotationManager = new AnnotationManager();
            $annotationManager->attach($doctrineParser);

            return $annotationManager;
        },

        'kjsencha.modulefactory' => function(ServiceLocatorInterface $sl) {
            return new ModuleFactory($sl->get('kjsencha.annotationmanager'));
        },

        'kjsencha.cache' => function(ServiceLocatorInterface $sl) {
            $config = $sl->get('Config');

            /** @var StorageAdapterFactoryInterface $storageFactory */
            $storageFactory = $sl->get(StorageAdapterFactoryInterface::class);

            $storage = $storageFactory->createFromArrayConfiguration($config['kjsencha']['cache']);

            return $storage;
        },

        'kjsencha.bootstrap' => function(ServiceLocatorInterface $sl) {
            $config = $sl->get('Config');
            $bootstrap = new Bootstrap($config['kjsencha']['bootstrap']['default']);
            $bootstrap->addVariables(array(
                'App' => array(
                    'basePath' => $sl->get('Request')->getBasePath(),
                )
            ));
            $bootstrap->setDirectApi($sl->get('kjsencha.api'));

            return $bootstrap;
        },

        'kjsencha.direct.manager' => function(ServiceManager $sm) {
            $directManager = new DirectManager();
            $directManager->addPeeringServiceManager($sm);

            return $directManager;
        },
    )
);