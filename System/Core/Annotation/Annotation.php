<?php


namespace Hexacore\Core\Annotation;


use Hexacore\Core\Annotation\Parser\AnnotationParserInterface;

class Annotation implements AnnotationInterface
{
    /**
     * @var AnnotationParserInterface
     */
    private $annotationParser;

    /**
     * Annotation constructor.
     * @param AnnotationParserInterface $annotationParser
     */
    public function __construct(AnnotationParserInterface $annotationParser)
    {
        $this->annotationParser = $annotationParser;
    }

    /**
     * {@inheritDoc}
     * @throws \ReflectionException
     */
    public function getClassAnnotations(string $class): array
    {
        $reflexionCLass = new \ReflectionClass($class);

        $comment = $reflexionCLass->getDocComment();

        return $this->annotationParser->parse($comment);
    }

    /**
     * {@inheritDoc}
     * @throws \ReflectionException
     */
    public function getPropertyAnnotations(string $class, string $property): array
    {
        $reflexionCLass = new \ReflectionClass($class);

        $comment = $reflexionCLass
            ->getProperty($property)
            ->getDocComment();

        return $this->annotationParser->parse($comment);
    }

    /**
     * {@inheritDoc}
     * @throws \ReflectionException
     */
    public function getMethodAnnotations(string $class, string $method): array
    {
        $reflexionCLass = new \ReflectionClass($class);

        $comment = $reflexionCLass
            ->getMethod($method)
            ->getDocComment();

        return $this->annotationParser->parse($comment);
    }
}