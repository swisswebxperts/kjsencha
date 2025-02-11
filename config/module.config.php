<?php

use KJSencha\Frontend as Ext;

return array(

    /**
     * Ext JS Configuration
     */
    'kjsencha' => array(
        // Path from which ExtJs should be loaded
        'library_path'   => 'https://cdn.sencha.com/ext/gpl/4.1.1/',
        'js'             => array(
            'ext' => 'ext-all.js',
        ),
        'css'            => array(
            'ext' => 'resources/css/ext-all.css',
        ),
        'direct' => array(
            'services' => array(
                //'KJSencha.echo' => 'kjsencha.echo',
            ),
        ),

        'bootstrap' => array(
            'default' => array(
                'modules' => array(
                ),
                'paths' => array(
                    // Path is relative since it has been mapped in the asset resolvers
                    'KJSencha' => 'js/classes/KJSencha',
                ),
                'requires' => array(
                    'KJSencha.direct.ModuleRemotingProvider',
                ),
            ),
        ),

        /**
         * Cache configuration
         */
        'cache' => array(
            'adapter' => \Laminas\Cache\Storage\Adapter\Memory::class,
            'options' => [
                'memory_limit' => -1, // Directory in which to put swapped memory blocks
            ],
            'plugins' => [
                [
                    'name' => 'serializer',
                    'options' => []
                ]
            ]
        ),

        'cache_key' => 'module_api',

        /**
         * Debug mode is used to show more information when server exceptions occur
         */
        'debug_mode' => true,
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view/'
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),

    /**
     * Router
     */
    'router' => array(
        'routes' => array(
            'kjsencha-direct' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/kjsencha/rpc/',
                    'defaults' => array(
                        'controller' => 'kjsencha_direct',
                    ),
                ),
            ),
            'kjsencha-data' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/kjsencha/data/[:action]',
                    'defaults' => array(
                        'controller' => 'kjsencha_data',
                    ),
                ),
            ),
        ),
    ),

    /**
     * AssetManager config to allow serving files from the `public` dir in this module
     */
    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                'KJSencha' => __DIR__ . '/../public',
            ),
        ),
    ),
);