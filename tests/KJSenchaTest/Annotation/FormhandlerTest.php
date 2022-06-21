<?php

namespace KJSenchaTest\Annotation;

use KJSencha\Direct\Remoting\Api\Api;
use KJSencha\Direct\Remoting\Api\Factory\ApiBuilder;
use KJSenchaTest\Util\ServiceManagerFactory;
use KJSenchaTestAsset\Direct\Form\Profile;
use PHPUnit\Framework\TestCase;
use KJSencha\Annotation\Formhandler;
use KJSencha\Direct\Remoting\Api\Object\Action;

class FormhandlerTest extends TestCase
{

    /**
     * @var ApiBuilder
     */
    protected $apiBuilder;

    public function setUp(): void
    {

        $sl = ServiceManagerFactory::getServiceManager();

        $this->apiBuilder = $sl-> get('kjsencha.apibuilder');
    }

    /**
     * @covers Formhandler::decorateObject
     */
    public function testAnnotationDecoratesMethod()
    {
        /* @var $action Action */
        $action = $this->apiBuilder->buildAction(Profile::class);

        $this->assertTrue($action->hasMethod('updateBasicInfo'));
        $this->assertTrue($action->getMethod('updateBasicInfo')->getOption('formHandler'));
    }

    /**
     * @covers Formhandler::decorateObject
     */
    public function testAnnotationDoesNotDecorateOthers()
    {
        /* @var $action Action */
        $action = $this->apiBuilder->buildAction(Profile::class);

        $this->assertTrue($action->hasMethod('getBasicInfo'));
        $this->assertNull($action->getMethod('getBasicInfo')->getOption('formHandler'));
    }

    /**
     * @covers Formhandler::decorateObject
     */
    public function testServiceAnnotationDecoratesMethod()
    {
        /* @var $api Api */
        $api = $this->apiBuilder->buildApi(array(
            'services' => array(
                'Direct.Profile' => Profile::class,
            )
        ));

        /* @var $action Action */
        $action = $api->getAction('Direct.Profile');

        $this->assertTrue($action->hasMethod('updateBasicInfo'));
        $this->assertTrue($action->getMethod('updateBasicInfo')->getOption('formHandler'));
    }

    /**
     * @covers Formhandler::decorateObject
     */
    public function testServiceAnnotationDoesNotDecorateOthers()
    {
        /* @var $api Api */
        $api = $this->apiBuilder->buildApi(array(
            'services' => array(
                'Direct.Profile' => Profile::class,
            )
        ));

        /* @var $action Action */
        $action = $api->getAction('Direct.Profile');

        $this->assertTrue($action->hasMethod('getBasicInfo'));
        $this->assertNull($action->getMethod('getBasicInfo')->getOption('formHandler'));
    }

}
