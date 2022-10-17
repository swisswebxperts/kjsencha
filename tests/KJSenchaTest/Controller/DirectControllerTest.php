<?php

namespace KJSenchaTest\Controller;

use KJSencha\Controller\DirectController;
use KJSencha\Direct\DirectManager;
use KJSenchaTest\Util\ServiceManagerFactory;
use Laminas\Http\Response;
use Laminas\View\Model\JsonModel;
use PHPUnit\Framework\TestCase;
use Laminas\Http\PhpEnvironment\Request;
use Laminas\Mvc\MvcEvent;
use Laminas\Router\RouteMatch;
use Laminas\Stdlib\Parameters;

use KJSencha\Direct\Remoting\Api\Api;

class DirectControllerTest extends TestCase
{
    /**
     * @var DirectController
     */
    protected $controller;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var RouteMatch
     */
    protected $routeMatch;

    /**
     * @var MvcEvent
     */
    protected $event;

    public function setUp(): void
    {
        // Used by \KJSencha\Service\ApiFactory::createService
        $sl = ServiceManagerFactory::getServiceManager();

        /* @var $manager DirectManager */
        $manager = $sl->get('kjsencha.direct.manager');
        /* @var $apiFactory Api */
        $api = $sl->get('kjsencha.api');

        $this->controller = new DirectController($manager, $api);
        $this->request = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'kjsencha_direct'));
        $this->event = new MvcEvent();
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
    }

    /**
     * @covers DirectController::isForm
     * @covers DirectController::getRPC
     * @covers DirectController::dispatchRPCS
     */
    function testValidFormResponse()
    {
        $this->request->setPost(new Parameters(array(
            'extAction' => 'KJSenchaTestAsset.Direct.form.Profile',
            'extMethod' => 'getBasicInfo',
            'extTID'    => 0,
            'extModule' => null,
        )));

        $result = $this->controller->dispatch($this->request);

        $this->assertTrue($this->controller->isForm());
        $this->assertInstanceOf(JsonModel::class, $result);
        $this->assertTrue(is_array($result->result));
        $this->assertEquals('rpc', $result->type);
        $this->assertTrue($result->result['success']);
    }

    /**
     * @covers DirectController::buildFormUploadResponse
     * @covers DirectController::isUpload
     * @covers DirectController::isForm
     * @covers DirectController::getRPC
     * @covers DirectController::dispatchRPCS
     */
    function testValidUploadResponse()
    {
        $this->request->setPost(new Parameters(array(
            'extAction' => 'KJSenchaTestAsset.Direct.form.Upload',
            'extMethod' => 'emptyUpload',
            'extUpload' => 'true',
            'extTID'    => 0,
            'extModule' => null,
        )));

        $result = $this->controller->dispatch($this->request);

        $this->assertTrue($this->controller->isUpload());
        $this->assertTrue($this->controller->isForm());
        $this->assertInstanceOf(Response::class, $result);


        $expectedResult = array(
            'type'      => 'rpc',
            'tid'       => 0,
            'action'    => 'KJSenchaTestAsset.Direct.form.Upload',
            'method'    => 'emptyUpload',
            'result'    => array(),
        );

        /**
         * This matcher checks the following pattern
         * <html><body><textarea>(content)</textarea></body></html>
         */
        $matcher = array(
            'tag' => 'html',
            'descendant' => array(
                'tag' => 'body',
                'children' => array(
                    'count' => 1,
                ),
                'descendant' => array(
                    'tag' => 'textarea',
                    'content' => json_encode($expectedResult)
                )
            )
        );

        $this->assertTag($matcher, $result->getContent());
    }

    /**
     * @covers DirectController::setDebugMode
     * @covers DirectController::isDebugMode
     */
    function testHiddenErrorResponseWhenDebugModeIsOff()
    {
        $this->request->setPost(new Parameters(array(
            'extAction' => 'KJSenchaTestAsset.Direct.ErrorGenerator',
            'extMethod' => 'throwException',
            'extTID'    => 0,
            'extModule' => null,
        )));

        $result = $this->controller->dispatch($this->request);

        $this->assertEquals('exception', $result->type);
        $this->assertEmpty($result->where);
    }

    /**
     * @covers \KJSencha\Controller\DirectController::setDebugMode
     * @covers \KJSencha\Controller\DirectController::isDebugMode
     */
    function testShowErrorResponseWhenDebugModeIsOn()
    {
        $this->request->setPost(new Parameters(array(
            'extAction' => 'KJSenchaTestAsset.Direct.ErrorGenerator',
            'extMethod' => 'throwException',
            'extTID'    => 0,
            'extModule' => null,
        )));

        $this->controller->setDebugMode(true);

        $result = $this->controller->dispatch($this->request);

        $this->assertEquals('exception', $result->type);
        $this->assertEquals('Exception!', $result->message);
        $this->assertNotEmpty($result->where);
    }

    /**
     * Test if objects are being passed the service locator
     */
    function testServiceLocatorAwareMustBeGivenServiceLocator()
    {
        $this->request->setPost(new Parameters(array(
            'extAction' => 'KJSenchaTestAsset.Direct.ServiceAction',
            'extMethod' => 'getServiceResult',
            'extTID'    => 0,
            'extModule' => null,
        )));

        $this->controller->setDebugMode(true);

        $result = $this->controller->dispatch($this->request);

        $this->assertEquals('pong!', $result->result);
    }
}
