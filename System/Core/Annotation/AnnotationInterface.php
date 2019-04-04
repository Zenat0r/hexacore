<?php


namespace Hexacore\Core\Annotation;

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
     * @return array
     */
    public function getClassAnnotations(string $class): array;

    /**
     * Return annotation from the php comment above the specific parameter.
     * Return as a array with key representing annotation name
     * and value the related value
     *
     * @param string $class
     * @param string $propriety
     * @return array
     */
    public function getPropertyAnnotations(string $class, string $propriety): array;

    /**
     * Return annotation from the php comment above the specific method.
     * Return as a array with key representing annotation name
     * and value the related value
     *
     * @param string $class
     * @param string $method
     * @return array
     */
    public function getMethodAnnotations(string $class, string $method): array;
}