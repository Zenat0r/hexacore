<?php

namespace Hexacore\Tests\Core\Annotation;

use Hexacore\Core\Annotation\Annotation;
use Hexacore\Core\Annotation\Parser\AnnotationParser;
use Hexacore\Core\Annotation\Type\AnnotationType;
use PHPUnit\Framework\TestCase;

/**
 * Class AnnotationTest
 * @package Hexacore\Tests\Core\Annotation
 * @Test("test")
 */
class AnnotationTest extends TestCase
{
    private $annotation;

    /**
     * @Test("test")
     */
    private $test;

    private $expected;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $annotationParser = new AnnotationParser();
        $this->annotation = new Annotation($annotationParser);

        $this->expected = [
            "Test" => new AnnotationType("Test", "test")
        ];
    }

    /**
     * @uses   \Hexacore\Core\Annotation\Parser\AnnotationParser
     * @covers \Hexacore\Core\Annotation\Annotation::__construct
     */
    public function test__construct()
    {
        $this->assertObjectHasAttribute("annotationParser", new Annotation(new AnnotationParser()));
    }

    /**
     * @throws \ReflectionException
     * @uses   \Hexacore\Core\Annotation\Type\AnnotationType
     * @covers \Hexacore\Core\Annotation\Annotation::getClassAnnotations
     * @covers \Hexacore\Core\Annotation\Parser\AnnotationParser::filter
     * @covers \Hexacore\Core\Annotation\Parser\AnnotationParser::parse
     * @covers \Hexacore\Core\Annotation\Parser\AnnotationParser::parseAnnotationValue
     * @covers \Hexacore\Core\Annotation\Parser\AnnotationParser::parseAnnotations
     */
    public function testGetClassAnnotations()
    {
        $annotationValue = $this->annotation->getClassAnnotations(AnnotationTest::class);

        $this->assertEquals($this->expected, $annotationValue);
    }

    /**
     * @throws \ReflectionException
     * @uses   \Hexacore\Core\Annotation\Type\AnnotationType
     * @covers \Hexacore\Core\Annotation\Annotation::getPropertyAnnotations
     * @covers \Hexacore\Core\Annotation\Parser\AnnotationParser
     */
    public function testGetPropertyAnnotations()
    {
        $annotationValue = $this->annotation->getPropertyAnnotations(AnnotationTest::class, "test");

        $this->assertEquals($this->expected, $annotationValue);
    }

    /**
     * @Test("test")
     * @throws \ReflectionException
     * @uses   \Hexacore\Core\Annotation\Type\AnnotationType
     * @covers \Hexacore\Core\Annotation\Annotation::getMethodAnnotations
     * @covers \Hexacore\Core\Annotation\Parser\AnnotationParser
     */
    public function testGetMethodAnnotations()
    {
        $annotationValue = $this->annotation->getMethodAnnotations(AnnotationTest::class, "testGetMethodAnnotations");

        $this->assertEquals($this->expected, $annotationValue);
    }
}
