<?php

namespace KJSencha\Direct;

use Laminas\ServiceManager\AbstractPluginManager;

/**
 * Manages the creation of Direct classes
 */
class DirectManager extends AbstractPluginManager
{
    /**
     * {@inheritDoc}
     */
    public function validatePlugin($plugin)
    {
    }
}
