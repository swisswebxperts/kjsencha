<?php

namespace KJSenchaTest\Frontend;

use KJSencha\Frontend\Component;
use PHPUnit\Framework\TestCase;

class ComponentTest extends TestCase
{
    /**
     * @covers Component::__construct
     */
    public function testSetComponentNameInConstructor()
    {
        $name = 'Ext.Component';

        $component = new Component($name);

        $this->assertEquals($name, $component->getClassName());

        $component = new Component(array(
            'className' => $name
        ));

        $this->assertEquals($name, $component->getClassName());

        $component = new Component($name, array(
            'extend' => 'Ext.Panel'
        ));

        $this->assertEquals($name, $component->getClassName());
    }
}
