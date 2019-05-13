<?php


namespace Hexacore\Core\Router;


use Hexacore\Core\Annotation\Annotation;
use Hexacore\Core\Annotation\AnnotationableInterface;
use Hexacore\Core\Auth\AuthInterface;
use Hexacore\Core\Config\JsonConfig;
use Hexacore\Core\DI\DIC;

/**
 * Class ActionAnnotationInterpreter
 * @package Hexacore\Core\Router
 */
class ActionAnnotationInterpreter
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
     * ActionAnnotationInterpreter constructor.
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
     * Load any annotationalbeClass
     * @param string $className
     */
    private function loadAnnotationableClass(string $className): void
    {
        $annotationable = $this->dic->get($className);

        if ($annotationable instanceof AnnotationableInterface) {
            $this->annotationableClasses[$annotationable->getAnnotationName()] = $annotationable;
        }
    }

    /**
     * Load all hexacore annotationableClass from the framework
     */
    private function loadFrameworkAnnotationableClass(): void
    {
        $this->loadAnnotationableClass(AuthInterface::class);
    }

    /**
     * Load all custom annotationableCLass from the developer
     */
    private function loadCustomAnnotationableClass(): void
    {
        try {
            $annotationableServices = JsonConfig::get("annotation");

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
    public function interpret(string $class, string $method): void
    {
        $annotationArray = $this->annotation->getMethodAnnotations($class, $method);

        foreach ($this->annotationableClasses as $annotationableClass) {
            $annotationSupportedName = $annotationableClass->getAnnotationName();

            if (array_key_exists($annotationSupportedName, $annotationArray)) {
                $this->annotationableClasses[$annotationSupportedName]->process($annotationArray[$annotationSupportedName]);
            }
        }
    }
}