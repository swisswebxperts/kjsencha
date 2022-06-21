<?php

namespace KJSencha\View\Helper\Factory;

use KJSencha\View\Helper\ExtJS;
use Laminas\View\Helper\HeadLink;
use Laminas\View\Helper\HeadScript;
use Psr\Container\ContainerInterface;

class ExtJsFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): ?ExtJS
    {
        $config = $container->get('Config');
        /* @var $headLink HeadLink */
        $headLink = $config->get('headLink');
        /* @var $headScript HeadScript */
        $headScript = $config->get('headScript');

        return new ExtJS($config['kjsencha'], $headLink, $headScript);
    }
}