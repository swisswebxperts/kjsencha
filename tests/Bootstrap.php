<?php

use Laminas\Mvc\Application;

error_reporting( E_ALL | E_STRICT );

/**
 * Unittest bootstrap
 */
class Bootstrap
{
    public static $serviceManager;

    public static function go()
    {
        if  (
            !($loader = @include __DIR__ . '/../vendor/autoload.php')
        ) {
            throw new RuntimeException('vendor/autoload.php could not be found. Did you run `php composer.phar install`?');
        }

        // use ModuleManager to load this module and it's dependencies
        $config = array(
            'modules' => array(
                'KJSencha'
            ),
            'module_listener_options' => array(
                'config_glob_paths'    => array(
                    __DIR__ . '/config/autoload/{,*.}{global,local}.php',
                ),
                'config_cache_enabled' => false,
            ),
        );

        $app = Application::init($config);
        self::$serviceManager = $app->getServiceManager();
    }

    public static function getServiceManager()
    {
        return self::$serviceManager;
    }
}

// Load the user-defined test configuration file, if it exists; otherwise, load
// the default configuration.
if (is_readable(__DIR__ . DIRECTORY_SEPARATOR . 'TestConfiguration.php')) {
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'TestConfiguration.php';
} else {
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'TestConfiguration.php.dist';
}

Bootstrap::go();