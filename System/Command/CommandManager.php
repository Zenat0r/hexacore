<?php


namespace Hexacore\Command;


use Hexacore\Command\IO\ConsoleIO;
use Hexacore\Core\Annotation\Annotation;
use Hexacore\Core\Annotation\Type\AnnotationType;
use Hexacore\Core\DI\DIC;

class CommandManager
{
    const NOT_COMMAND_ERROR = 200;
    const MALFORMED_ARG_ERROR = 201;
    const COMMAND_FILE_NOT_FOUND_ERROR = 202;
    const DEFAULT_ERROR = 242;
    const COMMAND_SUCCESS = 100;
    const COMMAND_HELP = 118;
    const COMMAND_METHOD_NOT_FOUND_ERROR = 204;
    const MISSING_ARGUMENT_ERROR = 104;

    public static function run(int &$argc, array &$argv) : int
    {
        if (1 >= $argc) {
            return self::NOT_COMMAND_ERROR;
        }

        array_shift($argv);

        $commandArg = array_shift($argv);

        if (1 !== substr_count($commandArg, ':')){
            return self::MALFORMED_ARG_ERROR;
        }

        $arrayArg = explode(':', $commandArg);

        $commandName = ucfirst($arrayArg[0]);
        $methodName = strtolower($arrayArg[1]);

        $commandPath = __DIR__ . "/../../App/src/Command/{$commandName}Command.php";

        if (file_exists($commandPath)) {
            $commandNamespace = "App\\Command\\{$commandName}Command";

            $dic = DIC::start();

            /** @var CommandInterface $command */
            $command = $dic->get($commandNamespace);

            if (method_exists($command, $methodName)) {
                if ('--help' === $argv[0] || '-h' === $argv[0]) {
                    /** @var Annotation $annotation */
                    $annotation = $dic->get(Annotation::class);

                    $annotationTypes = $annotation->getMethodAnnotations($commandNamespace, $methodName);

                    /** @var AnnotationType $annotationType */
                    foreach ($annotationTypes as $annotationType) {
                        if ('Description' === $annotationType->getKey()) {
                            ConsoleIO::writeLn('DESCRIPTION : ' . $annotationType->getValue() . "\n");
                        } else if ('Argument\Required' === $annotationType->getKey()) {
                            ConsoleIO::writeLn('Argument required : ' . $annotationType->getValue() . "\n");
                        } else if ('Argument\Optional' === $annotationType->getKey()) {
                            ConsoleIO::writeLn('Argument optional : ' . $annotationType->getValue() . "\n");
                        } else if ('Example' === $annotationType->getKey()) {
                            ConsoleIO::writeLn('Example : ' . $annotationType->getValue() . "\n");
                        }
                    }

                    return self::COMMAND_HELP;
                }

                try {
                    $argumentParamTransformer = new ArgumentParamTransformer($dic);

                    $reflexionMethod = new \ReflectionMethod($command, $methodName);

                    $transformedParameters = $argumentParamTransformer->getParams($reflexionMethod->getParameters(), $argv);

                    $reflexionMethod->invokeArgs($command, $transformedParameters);
                    return self::COMMAND_SUCCESS;
                } catch (\Exception $e) {
                    fwrite(STDOUT, 'Error message : ' . $e->getMessage() . "\n");
                    return 0 === $e->getCode() ? self::DEFAULT_ERROR : $e->getCode();
                }
            } else {
                $commandReflexion = new \ReflectionClass($commandNamespace);

                $methods = $commandReflexion->getMethods();

                ConsoleIO::writeLn("Available command for $commandName :");

                /** @var \ReflectionMethod $method */
                foreach ($methods as $method) {
                    $methodName = $method->getName();
                    ConsoleIO::writeLn("$commandName:$methodName");
                }

                ConsoleIO::writeLn("For more information on these methods type php System/console.php $commandName:method --help");

                return self::COMMAND_METHOD_NOT_FOUND_ERROR;
            }
        } else {
            return self::COMMAND_FILE_NOT_FOUND_ERROR;
        }
    }
}