<?php

namespace Hexacore\Core\Router;

use Hexacore\Core\Auth\AuthInterface;
use Hexacore\Core\Config\JsonConfig;
use Hexacore\Core\Controller;
use Hexacore\Core\DI\DIC;
use Hexacore\Core\Exception\Router\RouterException;
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
     * @param Controller $controller
     * @param \ReflectionMethod $reflectedAction
     * @param array $items
     * @return ResponseInterface
     * @throws \Exception
     */
    private function getResponse(Controller $controller, \ReflectionMethod $reflectedAction, array $items): ResponseInterface
    {
        $reflectedParameters = $reflectedAction->getParameters();

        $actionParamTransformer = new ActionParamTransformer($this->dic);
        $parameters = $actionParamTransformer->getParams($reflectedParameters, $items);

        return $reflectedAction->invokeArgs($controller, $parameters);
    }

    /**
     * @param Controller $controller
     * @param string $actionName
     * @return \ReflectionMethod
     * @throws \ReflectionException
     * @throws \Exception
     */
    private function getAction(Controller $controller, string $actionName): \ReflectionMethod
    {
        if (method_exists($controller, $actionName)) {
            $reflectedAction = new \ReflectionMethod($controller, $actionName);

            if (!$reflectedAction->isPublic()) {
                throw new RouterException("Method is not public", Response::NOT_FOUND);
            }

            $actionAnnotationInterpreter = $this->dic->get(ActionAnnotationInterpreter::class);
            $actionAnnotationInterpreter->interpret(get_class($controller), $actionName);

            return $reflectedAction;
        } else {
            throw new RouterException("Action does not exist", Response::NOT_FOUND);
        }
    }

    /**
     * @param string $controllerName
     * @return Controller
     * @throws \Exception
     */
    private function getController(string $controllerName): Controller
    {
        $controllerPath = __DIR__ . "/../../../App/src/Controller/$controllerName.php";

        if (file_exists($controllerPath)) {
            $controllerNamespace = "\\App\\Controller\\$controllerName";

            $controller = $this->dic->get($controllerNamespace);

            if (!$controller instanceof Controller) {
                throw new RouterException("Controller not a child of Controller class", Response::INTERNAL_SERVER_ERROR);
            }

            $controller->initialize($this->dic, $this->auth);

            return $controller;
        } else {
            throw new RouterException("Controller file does not exist", Response::NOT_FOUND);
        }
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

        $controllerName = array_shift($items) ?? JsonConfig::get()["defaultController"];
        $actionName = array_shift($items) ?? JsonConfig::get()["defaultAction"];

        $controllerName = ucfirst(strtolower($controllerName)) . "Controller";
        $actionName = strtolower($actionName);

        $controller = $this->getController($controllerName);
        $action = $this->getAction($controller, $actionName);
        $response = $this->getResponse($controller, $action, $items);

        return $response;
    }
}
