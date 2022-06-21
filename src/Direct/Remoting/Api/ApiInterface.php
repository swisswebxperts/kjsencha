<?php

namespace KJSencha\Direct\Remoting\Api;

use KJSencha\Direct\Remoting\Api\Object\Action;
use KJSencha\Frontend\Direct\RemotingProvider;

interface ApiInterface
{

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @param string $url
     */
    public function setUrl($url);

    /**
     * Retrieves a single Action by its name
     *
     * @param  string                                      $name
     * @return Action
     */
    public function getAction($name);

    /**
     * Retrieves all Actions in this API
     *
     * @return Action[]
     */
    public function getActions();

    /**
     * Checks if the API contains a given action
     *
     * @param  string $name
     * @return bool
     */
    public function hasAction($name);

    /**
     * Retrieves an array serialization of the API that is compatible with the frontend rendered JS
     *
     * @return array
     */
    public function toApiArray();

    /**
     * @return RemotingProvider
     */
    public function buildRemotingProvider();
}
