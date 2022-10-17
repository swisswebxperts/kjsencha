<?php

namespace KJSenchaTest\Direct\Remoting\Api\Factory;

use KJSencha\Direct\Remoting\Api\Factory\ApiBuilder;
use KJSencha\Direct\Remoting\Api\Object\Action;
use KJSencha\Util\DeveloperDebug;
use KJSenchaTest\Util\ServiceManagerFactory;
use PHPUnit\Framework\TestCase;

class ApiBuilderTest extends TestCase
{
    /**
     * @var ApiBuilder
     */
    protected $apiBuilder;

    public function setUp(): void
    {
        $sl = ServiceManagerFactory::getServiceManager();

        $this->apiBuilder = $sl->get('kjsencha.apibuilder');
    }

    /**
     * @covers ApiBuilder::buildMethod
     */
    public function testMethodIgnoresConstructor()
    {
        /* @var $action Action */
        $action = $this->apiBuilder->buildAction('KJSenchaTestAsset\FooService');
        
        $this->assertTrue($action->hasMethod('getBar'));
        $this->assertFalse($action->hasMethod('__construct'));
    }

}
