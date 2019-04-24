<?php

namespace Hexacore\Tests\Core\Router;

use Hexacore\Core\DI\DIC;
use Hexacore\Core\Request\Request;
use Hexacore\Core\Router\ActionParamTransformer;
use Hexacore\Tests\Mocks\ControllerMock;
use PHPUnit\Framework\TestCase;

class ActionParamTransformerTest extends TestCase
{

    private function getReflexionParams(string $name)
    {
        $class = new ControllerMock();
        $reflecMethod = new \ReflectionMethod($class, $name);

        return $reflecMethod->getParameters();
    }

    /**
     * @uses   \Hexacore\Core\DI\DIC
     * @covers \Hexacore\Core\Router\ActionParamTransformer::__construct
     */
    public function test__construct()
    {
        $obj = new ActionParamTransformer(DIC::start());

        $this->assertInstanceOf(ActionParamTransformer::class, $obj);
    }

    /**
     * @throws \ReflectionException
     * @uses   \Hexacore\Core\DI\DIC
     * @covers \Hexacore\Core\Router\ActionParamTransformer
     */
    public function testGetParamsWithDI()
    {
        $reflecParam = $this->getReflexionParams("di");

        $actionClassTransform = new ActionParamTransformer(DIC::start());

        $this->assertInstanceOf(ControllerMock::class, $actionClassTransform->getParams($reflecParam, [])[0]);
    }

    /**
     * @param int $a
     * @throws \ReflectionException
     * @uses   \Hexacore\Core\DI\DIC
     * @covers \Hexacore\Core\Router\ActionParamTransformer
     */
    public function testGetParamsWithDefaultValue(int $a = 42)
    {
        $class = new ActionParamTransformerTest();
        $reflecMethod = new \ReflectionMethod($class, "testGetParamsWithDefaultValue");

        $reflecParam = $reflecMethod->getParameters();

        $actionClassTransform = new ActionParamTransformer(DIC::start());

        $this->assertEquals(42, $actionClassTransform->getParams($reflecParam, [])[0]);
    }

    /**
     * @throws \ReflectionException
     * @uses   \Hexacore\Core\DI\DIC
     * @uses   \Hexacore\Core\Request\Request
     * @covers \Hexacore\Core\Router\ActionParamTransformer
     */
    public function testGetParamsWithDefaultValueAndDI()
    {
        $reflecParam = $this->getReflexionParams("create");

        $actionClassTransform = new ActionParamTransformer(DIC::start());

        $this->assertInstanceOf(Request::class, $actionClassTransform->getParams($reflecParam, [])[0]);
        $this->assertEquals(42, $actionClassTransform->getParams($reflecParam, [])[1]);
    }

    /**
     * @throws \ReflectionException
     * @uses   \Hexacore\Core\DI\DIC
     * @uses   \Hexacore\Core\Request\Request
     * @covers \Hexacore\Core\Router\ActionParamTransformer
     */
    public function testGetParamsWithoutDefaultValueAndDI()
    {
        $reflecParam = $this->getReflexionParams("update");

        $actionClassTransform = new ActionParamTransformer(DIC::start());

        $items = ["mock"];
        $result = $actionClassTransform->getParams($reflecParam, $items);

        $this->assertInstanceOf(Request::class, $result[0]);
        $this->assertEquals("mock", $result[1]);
    }

    /**
     * @throws \ReflectionException
     * @uses   \Hexacore\Core\DI\DIC
     * @covers \Hexacore\Core\Router\ActionParamTransformer
     */
    public function testGetParamsWithDefaultValueString()
    {
        $reflecParam = $this->getReflexionParams("default");

        $actionClassTransform = new ActionParamTransformer(DIC::start());

        $result = $actionClassTransform->getParams($reflecParam, []);

        $this->assertEquals("mock", $result[0]);
    }
}
