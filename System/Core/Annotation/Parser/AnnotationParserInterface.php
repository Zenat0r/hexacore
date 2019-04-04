<?php


namespace Hexacore\Core\Annotation\Parser;

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
     * @return array
     */
    public function parse(string $comment): array;
}