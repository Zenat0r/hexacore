<?php


namespace Hexacore\Core\Annotation\Parser;

use Hexacore\Core\Annotation\Type\AnnotationType;

/**
 * Interface AnnotationParserInterface
 * @package Hexacore\Core\Annotation
 */
interface AnnotationParserInterface
{
    /**
     * Take a a string a parse it as an array using specific rules.
     *
     * @param string $comment
     * @return AnnotationType[]
     */
    public function parse(string $comment): array;
}