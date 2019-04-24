<?php

namespace Hexacore\Tests\Core\Annotation;

use Hexacore\Core\Annotation\Type\AnnotationType;
use PHPUnit\Framework\TestCase;

class AnnotationTypeTest extends TestCase
{
    private $annotationType1;
    private $annotationType2;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->annotationType1 = new AnnotationType("key");
        $this->annotationType2 = new AnnotationType("key", "value");
    }

    /**
     * @covers \Hexacore\Core\Annotation\Type\AnnotationType::getKey
     */
    public function testGetKey()
    {
        $this->assertEquals("key", $this->annotationType1->getKey());
    }


    /**
     * @covers \Hexacore\Core\Annotation\Type\AnnotationType::getValue
     */
    public function testGetValue()
    {
        $this->assertEquals("value", $this->annotationType2->getValue());
    }

    /**
     * @covers \Hexacore\Core\Annotation\Type\AnnotationType
     */
    public function test__construct()
    {
        $annotationType = new AnnotationType("key", "value");

        $this->assertEquals("key", $annotationType->getKey());
        $this->assertEquals("value", $annotationType->getValue());
    }

    /**
     * @uses   \Hexacore\Core\Annotation\Type\AnnotationType
     * @covers \Hexacore\Core\Annotation\Type\AnnotationType::getKey
     * @covers \Hexacore\Core\Annotation\Type\AnnotationType::getValue
     */
    public function test__constructWithNullValue()
    {
        $annotationType = new AnnotationType("key", null);

        $this->assertEquals("key", $annotationType->getKey());
        $this->assertEmpty($annotationType->getValue());
    }

    /**
     * @covers \Hexacore\Core\Annotation\Type\AnnotationType::getKey
     * @covers \Hexacore\Core\Annotation\Type\AnnotationType::getValue
     */
    public function test__constructWithEmptyValue()
    {
        $this->assertEquals("key", $this->annotationType1->getKey());
        $this->assertEmpty($this->annotationType1->getValue());
    }
}
