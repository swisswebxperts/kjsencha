<?php

namespace KJSenchaTest\Direct\Remoting\Api\Factory;

use KJSencha\Direct\Remoting\Api\Object\Action;
use KJSenchaTest\Util\ServiceManagerFactory;
use PHPUnit\Framework\TestCase;
use KJSencha\Direct\Remoting\Api\Factory\ApiBuilder;

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
