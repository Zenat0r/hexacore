<?php

namespace Hexacore\Tests\Core\Annotation;

use Hexacore\Core\Annotation\Parser\AnnotationParser;
use Hexacore\Core\Annotation\Type\AnnotationType;
use PHPUnit\Framework\TestCase;

/**
 * Class AnnotationParserTest
 * @package Hexacore\Tests\Core\Annotation
 */
class AnnotationParserTest extends TestCase
{

    /**
     * @throws \Exception
     * @uses   \Hexacore\Core\Annotation\Type\AnnotationType
     * @covers \Hexacore\Core\Annotation\Parser\AnnotationParser
     */
    public function testParse()
    {
        $comment = '/**
         * I\'m a lorem ipsum comment
         * @var string
         * @param string $str
         * @Void()
         * @Str("string")
         * @int("int")
         * @DoubleInt(1,2)
         * @DoubleString("1","2")
         * @DoubleMixed(1, "2")
         */';

        $annotationParser = new AnnotationParser();

        $expected = [
            "Void" => new AnnotationType("Void", null),
            "Str" => new AnnotationType("Str", "string"),
            "int" => new AnnotationType("int", "int"),
            "DoubleInt" => new AnnotationType("DoubleInt", [1, 2]),
            "DoubleString" => new AnnotationType("DoubleString", ["1", "2"]),
            "DoubleMixed" => new AnnotationType("DoubleMixed", [1, "2"]),
        ];

        $this->assertEquals($expected, $annotationParser->parse($comment));
    }
}
