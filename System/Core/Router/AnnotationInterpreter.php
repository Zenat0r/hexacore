<?php


namespace Hexacore\Core\Router;


use Hexacore\Core\Annotation\Annotation;
use Hexacore\Core\Annotation\AnnotationableInterface;
use Hexacore\Core\Annotation\Type\AnnotationType;
use Hexacore\Core\Auth\AuthInterface;
use Hexacore\Core\Config\JsonConfig;
use Hexacore\Core\DI\DIC;
use Hexacore\Core\Exception\Annotation\MalformedAnnotationTypeException;
use Hexacore\Core\Request\Annotation\RequestMethodChecker;

/**
 * Class AnnotationInterpreter
 * @package Hexacore\Core\Router
 */
class AnnotationInterpreter
{
    /**
     * @var DIC
     */
    private $dic;

    /**
     * @var Annotation
     */
    private $annotation;

    /**
     * @var AnnotationableInterface[]
     */
    private $annotationableClasses;

    /**
     * AnnotationInterpreter constructor.
     * @param Annotation $annotation
     */
    public function __construct(Annotation $annotation)
    {
        $this->dic = DIC::start();
        $this->annotation = $annotation;
        $this->loadFrameworkAnnotationableClass();
        $this->loadCustomAnnotationableClass();
    }

    /**
     * Load any annotationableClass
     * @param string $className
     */
    private function loadAnnotationableClass(string $className): void
    {
        $annotationable = $this->dic->get($className);

        if ($annotationable instanceof AnnotationableInterface) {
            $this->annotationableClasses[] = $annotationable;
        }
    }

    /**
     * Load all hexacore annotationableClass from the framework
     */
    private function loadFrameworkAnnotationableClass(): void
    {
        $this->loadAnnotationableClass(AuthInterface::class);
        $this->loadAnnotationableClass(RequestMethodChecker::class);
    }

    /**
     * Load all custom annotationableCLass from the developer
     */
    private function loadCustomAnnotationableClass(): void
    {
        try {
            $annotationableServices = JsonConfig::getInstance()->setFile('annotation')->toArray();

            foreach ($annotationableServices as $service) {
                $this->loadAnnotationableClass($service);
            }
        } catch (\Exception $e) {
            return;
        }
    }

    /**
     * First parse the comment of the controller's action using annotation parser.
     * Then search for the annotation key that match both the annotation and the annotationable object
     * "annotationName"
     *
     * @param string $class
     * @param string $method
     * @throws \ReflectionException
     */
    public function interpret(string $class, string $method = null): void
    {
        $annotationArray = null === $method ? $this->annotation->getClassAnnotations($class) : $this->annotation->getMethodAnnotations($class, $method);

        $annotationArrayAssoc = [];

        /** @var AnnotationType $annotation */
        foreach ($annotationArray as $annotation) {
            $annotationArrayAssoc[$annotation->getKey()] = $annotation;
        }

        foreach ($this->annotationableClasses as $annotationableClass) {
            $annotationSupportedName = $annotationableClass->getAnnotationName();

            if (array_key_exists($annotationSupportedName, $annotationArrayAssoc)) {
                $annotationType = $annotationArrayAssoc[$annotationSupportedName];

                if ($annotationableClass->isValidAnnotationType($annotationType)) {
                    $annotationableClass->process($annotationType);
                } else {
                    throw new MalformedAnnotationTypeException("Annotation for $annotationSupportedName malformed");
                }
            }
        }
    }
}