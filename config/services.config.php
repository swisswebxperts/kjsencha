<?php

namespace KJSencha;

use KJSencha\Direct\Remoting\Api\Factory\ApiBuilder;
use KJSencha\Frontend\Bootstrap;
use KJSencha\Direct\Remoting\Api\Factory\ModuleFactory;
use KJSencha\Direct\DirectManager;

use Laminas\Cache\Service\StorageAdapterFactoryInterface;
use Laminas\Code\Annotation\AnnotationManager;
use Laminas\Code\Annotation\Parser\DoctrineAnnotationParser;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\ServiceManager\ServiceManager;

return array(
    'factories' => array(

        /**
         * Produces a \KJSencha\Direct\Remoting\Api instance consumed by
         * the RPC services
         */
        'kjsencha.api'              => 'KJSencha\Service\ApiFactory',
        'kjsencha.componentmanager' => 'KJSencha\Service\ComponentManagerFactory',

        /**
         * Annotation manager used to discover features available for the RPC services
         */
        'kjsencha.annotationmanager' => function() {
            $doctrineParser = new DoctrineAnnotationParser();
            $doctrineParser->registerAnnotation('KJSencha\Annotation\Remotable');
            $doctrineParser->registerAnnotation('KJSencha\Annotation\Interval');
            $doctrineParser->registerAnnotation('KJSencha\Annotation\Formhandler');
            $doctrineParser->registerAnnotation('KJSencha\Annotation\Group');
            $annotationManager = new AnnotationManager();
            $annotationManager->attach($doctrineParser);
            return $annotationManager;
        },

        /**
         * Factory responsible for crawling module dirs and building APIs
         */
        'kjsencha.apibuilder' => function(ServiceLocatorInterface $sl) {
            /* @var $annotationManager AnnotationManager */
            $annotationManager = $sl->get('kjsencha.annotationmanager');
            /* @var $directManager DirectManager */
            $directManager = $sl->get('kjsencha.direct.manager');

            return new ApiBuilder($annotationManager, $directManager);
        },

        /**
         * Cache where the API will be stored once it is filled with data
         */
        'kjsencha.cache' => function(ServiceLocatorInterface $sl) {
            $config = $sl->get('Config');
            $storageFactory = $sl->get(StorageAdapterFactoryInterface::class);
            $storage = $storageFactory->createFromArrayConfiguration($config['kjsencha']['cache']);
            return $storage;
        },
        /**
         * Bootstrap service that allows rendering of the API into an output that the
         * ExtJs direct manager can understand
         */
        'kjsencha.bootstrap' => function(ServiceLocatorInterface $sl) {
            $config = $sl->get('Config');
            $bootstrap = new Bootstrap($config['kjsencha']['bootstrap']['default']);
            $bootstrap->addVariables(array(
                'App' => array(
                    'basePath' => $sl->get('Request')->getBasePath(),
                )
            ));
            $directApi = $sl->get('kjsencha.api');
            $bootstrap->setDirectApi($directApi);

            return $bootstrap;
        },

        /**
         * Direct manager, handles instantiation of requested services
         */
        'kjsencha.direct.manager' => function(ServiceManager $sm) {
            $directManager = new DirectManager();

            return $directManager;
        },

        /**
         * Echo service - registered by default with ExtJs's remoting provider to allow
         * simple verification that the module's features are active and working.
         */
        'kjsencha.echo' => function() {
            return new TestEchoService('Hello ');
        }
    )
);