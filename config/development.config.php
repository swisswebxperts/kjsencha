<?php

namespace KJSencha;

use KJSencha\Controller\Factory\KjSenchaDataFactory;
use KJSencha\Controller\Factory\KjSenchaDirectFactory;
use KJSencha\Service\ApiFactory;
use KJSencha\Service\ComponentManagerFactory;
use KJSencha\Service\Factory\AnnotationManagerFactory;
use KJSencha\Service\Factory\ApiBuilderFactory;
use KJSencha\Service\Factory\DirectManagerFactory;
use KJSencha\Service\Factory\ExtJsViewHelperFactory;
use KJSencha\Service\Factory\KjSenchaBootstrapFactory;
use KJSencha\Service\Factory\KjSenchaCacheFactory;
use KJSencha\Service\Factory\KjSenchaDirectApiFactory;
use KJSencha\Service\Factory\kjSenchaLoaderConfigFactory;
use KJSencha\Service\Factory\kjSenchaVariablesFactory;

return [
    "factories" => [
        'kjsencha_direct' => KjSenchaDirectFactory::class,
        'kjsencha_data' => KjSenchaDataFactory::class,

        /**
         * Produces a \KJSencha\Direct\Remoting\Api instance consumed by
         * the RPC services
         */
        'kjsencha.api'              => ApiFactory::class,
        'kjsencha.componentmanager' => ComponentManagerFactory::class,

        /**
         * Annotation manager used to discover features available for the RPC services
         */
        'kjsencha.annotationmanager' => AnnotationManagerFactory::class,

        /**
         * Factory responsible for crawling module dirs and building APIs
         */
        'kjsencha.apibuilder' => ApiBuilderFactory::class,

        /**
         * Cache where the API will be stored once it is filled with data
         */
        'kjsencha.cache' => KjSenchaCacheFactory::class,
        /**
         * Bootstrap service that allows rendering of the API into an output that the
         * ExtJs direct manager can understand
         */
        'kjsencha.bootstrap' => KjSenchaBootstrapFactory::class,

        /**
         * Direct manager, handles instantiation of requested services
         */
        'kjsencha.direct.manager' => DirectManagerFactory::class,

        /**
         * Echo service - registered by default with ExtJs's remoting provider to allow
         * simple verification that the module's features are active and working.
         */
        'kjsencha.echo' => \KJSencha\Service\Factory\KjSenchaEchoFactory::class,


        // VIEW HELPERS SERVICES
        'extJs' => ExtJsViewHelperFactory::class,
        'kjSenchaVariables' => kjSenchaVariablesFactory::class,
        'kjSenchaLoaderConfig' => kjSenchaLoaderConfigFactory::class,
        'kjSenchaDirectApi' => KjSenchaDirectApiFactory::class,
    ]
];