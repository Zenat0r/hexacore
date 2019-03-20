<?php

namespace Hexacore\Core\Router;

use Hexacore\Core\Auth\AuthInterface;
use Hexacore\Core\Config\JsonConfig;
use Hexacore\Core\Controller;
use Hexacore\Core\DI\DIC;
use Hexacore\Core\Model\ManageableModelInterface;
use Hexacore\Core\Model\Repository\ModelRepository;
use Hexacore\Core\Request\Request;
use Hexacore\Core\Request\RequestInterface;
use Hexacore\Core\Response\Response;
use Hexacore\Core\Response\ResponseInterface;

class Router implements RouterInterface
{
    private $dic;

    private $auth;

    public function __construct(AuthInterface $auth)
    {
        $this->dic = DIC::start();
        $this->auth = $auth;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function match(RequestInterface $request): ResponseInterface
    {
        $url = $request->getQuery("_url");
        $items = explode("/", $url);

        if (empty($items[0])) {
            $items = [];
        }

        /* Default mapping */
        $controllerName = array_shift($items) ?? JsonConfig::get()["defaultController"];
        $actionName = array_shift($items) ?? JsonConfig::get()["defaultAction"];

        $controllerName = ucfirst(strtolower($controllerName)) . "Controller";
        $actionName = strtolower($actionName);

        $controllerPath = __DIR__ . "/../../../App/src/Controller/$controllerName.php";

        if (file_exists($controllerPath)) {
            $controllerNamespace = "\\App\\Controller\\$controllerName";

            $controller = $this->dic->get($controllerNamespace);

            if (!$controller instanceof Controller) {
                throw new \Exception("Controller not a child of Controller class", Response::INTERNAL_SERVER_ERROR);
            }

            $controller->initialize($this->dic, $this->auth);

            if (method_exists($controller, $actionName)) {
                $reflectedAction = new \ReflectionMethod($controller, $actionName);

                if (!$reflectedAction->isPublic()) throw new \Exception("Method is not public", Response::NOT_FOUND);

                $parameters = [];
                $reflectedParameters = $reflectedAction->getParameters();

                foreach ($reflectedParameters as $key => $param) {
                    if ($param->getClass()) {
                        $className = $param->getClass()->getName();

                        if (Request::class === $className) {
                            $parameters[] = $request;
                        } else {
                            $class = $this->dic->get($className);

                            if ($class instanceof ManageableModelInterface) {
                                $repository = $this->dic->get(ModelRepository::class);

                                $id = array_shift($items);

                                $parameters[] = $repository->setModel($className)->findById($id);
                            } else {
                                $parameters[] = $class;
                            }
                        }
                    } else {
                        $parameter = array_shift($items);

                        if ($parameter === null && $param->isDefaultValueAvailable()) {
                            $parameters[] = $param->getDefaultValue();
                        } elseif ($parameter === null) {
                            throw new \Exception("Missing getters", Response::NOT_FOUND);
                        } else {
                            $paramType = $param->getType()->getName();

                            if ($paramType === "int") {
                                $parameters[] = (int)$parameter;
                            } elseif ($paramType === "double") {
                                $parameters[] = (double)$parameter;
                            } elseif ($paramType === "float") {
                                $parameters[] = (float)$parameter;
                            } else {
                                $parameters[] = $parameter;
                            }
                        }
                    }
                }

                if (!empty($items)) {
                    throw new \Exception("Too many getters", Response::NOT_FOUND);
                }

                $actionReturn = $reflectedAction->invokeArgs($controller, $parameters);

                if ($actionReturn instanceof ResponseInterface) {
                    return $actionReturn;
                } else {
                    throw new \Exception("Contoller's action does return a valid response", Response::INTERNAL_SERVER_ERROR);
                }
            } else {
                throw new \Exception("Action does not exist", Response::NOT_FOUND);
            }
        } else {
            throw new \Exception("Controller file does not exist", Response::NOT_FOUND);
        }
    }
}
