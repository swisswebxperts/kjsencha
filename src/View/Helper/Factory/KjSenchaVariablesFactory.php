<?php

namespace KJSencha\View\Helper\Factory;

use KJSencha\View\Helper\Variables;
use Psr\Container\ContainerInterface;
use Laminas\View\Helper\HeadScript;
use KJSencha\Frontend\Bootstrap;

class KjSenchaVariablesFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): ?Variables
    {
        /* @var $headScript HeadScript */
        $headScript = $container->get('headScript');
        /* @var $bootstrap Bootstrap */
        $bootstrap = $container->get('kjsencha.bootstrap');

        return new Variables($headScript, $bootstrap);

    }
}