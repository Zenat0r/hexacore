<?php


namespace Hexacore\Core\Request\Annotation;


use Hexacore\Core\Annotation\AnnotationableInterface;
use Hexacore\Core\Annotation\Type\AnnotationType;
use Hexacore\Core\Request\Request;
use Hexacore\Core\Response\Response;

class RequestMethodChecker implements AnnotationableInterface
{
    const ANNOTATION_NAME = "Request\Method";
    const AUTHORIZED_METHOD = ["GET", "POST", "PUT", "DELETE", "UPDATE", "OPTIONS", "HEAD"];

    /**
     * Verify if the annotationType key is the same that the one given as parameter
     *
     * @param AnnotationType $annotationType
     * @return bool
     */
    public function isValidAnnotationType(AnnotationType $annotationType): bool
    {
        $value = $annotationType->getValue();

        if (!is_array($value)) {
            $value = [$value];
        }

        $isMethodValid = false;
        foreach ($value as $item) {
            if (in_array($item, self::AUTHORIZED_METHOD)) {
                $isMethodValid = true;
            }
        }

        return $annotationType->getKey() === $this->getAnnotationName() && $isMethodValid;
    }

    /**
     * Execute the specific behavior of the class when called using annotations.
     * AnnotationType can be used to retrieve values.
     *
     * @param AnnotationType $annotationType
     * @throws \Exception
     */
    public function process(AnnotationType $annotationType): void
    {
        $request = Request::get();

        $method = $annotationType->getValue();

        if (!is_array($method)) {
            $method = [$method];
        }

        if (!in_array($request->getMethod(), $method)) {
            throw new \Exception("Request method not allowed", Response::FORBIDDEN);
        }
    }

    /**
     * Return the name of the annotationType key compatible with the annotationable Class
     *
     * @return string
     */
    public function getAnnotationName(): string
    {
        return self::ANNOTATION_NAME;
    }
}