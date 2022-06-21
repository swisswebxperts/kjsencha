<?php

namespace KJSencha;

use KJSencha\Controller\DataController;
use KJSencha\Controller\Factory\KjSenchaDataFactory;
use KJSencha\Controller\Factory\KjSenchaDirectFactory;
use KJSencha\Controller\DirectController;
use KJSencha\Direct\DirectManager;
use KJSencha\Direct\Remoting\Api\Builder\ApiBuilder;
use KJSencha\Frontend\Bootstrap;
use KJSencha\Service\ComponentManager;
use KJSencha\Service\ComponentManagerFactory;
use KJSencha\Service\Factory\AnnotationManagerFactory;
use KJSencha\Service\Factory\ApiBuilderFactory;
use KJSencha\Service\Factory\ApiFactory;
use KJSencha\Service\Factory\DirectManagerFactory;
use KJSencha\Service\Factory\ExtJsViewHelperFactory;
use KJSencha\Service\Factory\KjSenchaBootstrapFactory;
use KJSencha\Service\Factory\KjSenchaCacheFactory;
use KJSencha\Service\Factory\KjSenchaDirectApiFactory;
use KJSencha\Service\Factory\KjSenchaEchoFactory;
use KJSencha\Service\Factory\kjSenchaLoaderConfigFactory;
use KJSencha\Service\TestEchoService;
use KJSencha\View\Helper\DirectApi;
use KJSencha\View\Helper\ExtJS;
use KJSencha\View\Helper\Factory\DirectApiFactory;
use KJSencha\View\Helper\Factory\ExtJsFactory;
use KJSencha\View\Helper\Factory\KjSenchaVariablesFactory;
use KJSencha\View\Helper\Factory\LoaderConfigFactory;
use KJSencha\View\Helper\LoaderConfig;
use KJSencha\View\Helper\Variables;

use KJSencha\Direct\Remoting\Api\Api;
use Laminas\Cache\Storage\StorageInterface;
use Laminas\Code\Annotation\Parser\DoctrineAnnotationParser;

class ConfigProvider
{
    /**
     * Return configuration for this component.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
        ];
    }

    /**
     * Return dependency mappings for this component.
     *
     * @return array
     */
    public function getDependencyConfig()
    {
        return [
            // Legacy Zend Framework aliases
            'aliases'  => [
                // Controllers
                'kjsencha_direct' => DirectController::class,
                'kjsencha_data' => DataController::class,

                // View Helpers
                'extJs' => ExtJS::class,
                'kjSenchaVariables' => Variables::class,
                'kjSenchaLoaderConfig' => LoaderConfig::class,
                'kjSenchaDirectApi' => DirectApi::class,

                // Services
                'kjsencha.api' => Api::class,
                'kjsencha.annotationmanager' => DoctrineAnnotationParser::class,
                'kjsencha.componentmanager' => ComponentManager::class,
                'kjsencha.apibuilder' => ApiBuilder::class,
                'kjsencha.cache' => StorageInterface::class,
                'kjsencha.bootstrap' => Bootstrap::class,
                'kjsencha.direct.manager' => DirectManager::class,
                'kjsencha.echo' => TestEchoService::class

            ],
            'abstract_factories' => [

            ],
            'factories' => [
                // Controllers
                DirectController::class => KjSenchaDirectFactory::class,
                DataController::class => KjSenchaDataFactory::class,

                // View Helpers
                ExtJS::class => ExtJsFactory::class,
                Variables::class => KjSenchaVariablesFactory::class,
                LoaderConfig::class => LoaderConfigFactory::class,
                DirectApi::class => DirectApiFactory::class,

                // Services
                /**
                 * Produces a \KJSencha\Direct\Remoting\Api instance consumed by
                 * the RPC services
                 */
                 Api::class           => ApiFactory::class,
                ComponentManager::class => ComponentManagerFactory::class,

                /**
                 * Annotation manager used to discover features available for the RPC services
                 */
                DoctrineAnnotationParser::class => AnnotationManagerFactory::class,

                /**
                 * Factory responsible for crawling module dirs and building APIs
                 */
                 ApiBuilder::class => ApiBuilderFactory::class,

                /**
                 * Cache where the API will be stored once it is filled with data
                 */
                 StorageInterface::class  => KjSenchaCacheFactory::class,
                /**
                 * Bootstrap service that allows rendering of the API into an output that the
                 * ExtJs direct manager can understand
                 */
                 Bootstrap::class => KjSenchaBootstrapFactory::class,

                /**
                 * Direct manager, handles instantiation of requested services
                 */
                 DirectManager::class  => DirectManagerFactory::class,

                /**
                 * Echo service - registered by default with ExtJs's remoting provider to allow
                 * simple verification that the module's features are active and working.
                 */
                TestEchoService::class => KjSenchaEchoFactory::class

            ],
            'invokables' => [

            ]
        ];
    }
}