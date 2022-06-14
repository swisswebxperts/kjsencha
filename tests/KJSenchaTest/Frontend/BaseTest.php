<?php

namespace KJSenchaTest\Frontend;

use KJSencha\Frontend\Base;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    /**
     * @covers Base::__construct
     */
    public function testConstructorOverloading()
    {
        $component = new Base('Ext.Component');

        $this->assertEmpty($component->toArray());

        $title = 'Test Title';

        $component = new Base('Ext.Component', array(
            'title' => $title
        ));

        $this->assertArrayHasKey('title', $component->toArray());
        $this->assertEquals($title, $component['title']);

        $component = new Base(array(
            'title' => $title
        ));

        $this->assertArrayHasKey('title', $component->toArray());
        $this->assertEquals($title, $component['title']);
    }
}
