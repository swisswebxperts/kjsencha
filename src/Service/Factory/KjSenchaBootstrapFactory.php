<?php

namespace KJSencha\Service\Factory;

use KJSencha\Frontend\Bootstrap;
use Laminas\Config\Config;
use Laminas\Http\Request;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

class KjSenchaBootstrapFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $config = $container->get(Config::class);
        $bootstrap = new Bootstrap($config['kjsencha']['bootstrap']['default']);
        $bootstrap->addVariables(array(
            'App' => array(
                'basePath' => $container->get(Request::class)->getBasePath(),
            )
        ));
        /* @var $directApi \KJSencha\Direct\Remoting\Api\Api */
        $directApi = $container->get('kjsencha.api');
        $bootstrap->setDirectApi($directApi);

        return $bootstrap;
    }
}