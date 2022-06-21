<?php

namespace KJSencha\View\Helper\Factory;

use KJSencha\View\Helper\DirectApi;
use Psr\Container\ContainerInterface;

use Laminas\View\Helper\HeadScript;
use KJSencha\Frontend\Bootstrap;

class DirectApiFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null) : ?DirectApi
    {
        /* @var $headScript HeadScript */
        $headScript = $container->get('headScript');
        /* @var $bootstrap Bootstrap */
        $bootstrap = $container->get('kjsencha.bootstrap');

        return new DirectApi($headScript, $bootstrap);
    }
}