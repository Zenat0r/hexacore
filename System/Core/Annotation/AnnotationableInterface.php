<?php


namespace Hexacore\Core\Annotation;


use Hexacore\Core\Annotation\Type\AnnotationType;

/**
 * Class that implement this interface are allowed to be used as annotation in any controller's action.
 *
 * Interface AnnotationableInterface
 * @package Hexacore\Core\Annotation
 */
interface AnnotationableInterface
{
    /**
     * Verify if the annotationType has the right specification.
     * Those are defined by the developer.
     *
     * @param AnnotationType $annotationType
     * @return bool
     */
    public function isValidAnnotationType(AnnotationType $annotationType): bool;

    /**
     * Execute the specific behavior of the class when called using annotations.
     * AnnotationType can be used to retrieve values.
     *
     * @param AnnotationType $annotationType
     */
    public function process(AnnotationType $annotationType): void;

    /**
     * Return the name of the annotationType key compatible with the annotationable Class.
     * This value is the name used as annotation in the controller's action.
     *
     * e.g : @myAnnotation()
     * getAnnotationName should then return myAnnotation
     *
     * @return string
     */
    public function getAnnotationName(): string;
}