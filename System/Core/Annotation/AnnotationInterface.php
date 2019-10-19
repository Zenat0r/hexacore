<?php


namespace Hexacore\Core\Annotation;

use Hexacore\Core\Annotation\Type\AnnotationType;

/**
 * Interface AnnotationInterface
 * @package Hexacore\Core\Annotation
 */
interface AnnotationInterface
{
    /**
     * Return annotation from the php comment above the class.
     * Return as a array with key representing annotation name
     * and value the related value
     *
     * @param string $class
     * @return AnnotationType[]
     */
    public function getClassAnnotations(string $class): array;

    /**
     * Return annotation from the php comment above the specific parameter.
     * Return as a array with key representing annotation name
     * and value the related value
     *
     * @param string $class
     * @param string $propriety
     * @return AnnotationType[]
     */
    public function getPropertyAnnotations(string $class, string $propriety): array;

    /**
     * Return annotation from the php comment above the specific method.
     * Return as a array with key representing annotation name
     * and value the related value
     *
     * @param string $class
     * @param string $method
     * @return AnnotationType[]
     */
    public function getMethodAnnotations(string $class, string $method): array;
}