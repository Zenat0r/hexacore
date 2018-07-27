<?php

namespace Hexacore\Core\Router;

use Hexacore\Core\Request\RequestInterface;
use Hexacore\Core\Config\JsonConfig;

class Router implements RouterInterface
{
    public function match(RequestInterface $request)
    {
        $url = $request->getQuery("_url");
        $items = explode("/", $url);

        if (empty($items[0])) {
            $items = [];
        }
        
        /* Default mapping */
        $controllerName = $items[0] ?? JsonConfig::get()["defaultController"];
        $actionName = $items[1] ?? JsonConfig::get()["defaultAction"];

        $controllerPath = __DIR__ . "/../../../App/src/Controller/$controllerName.php";

        if (file_exists($controllerPath)) {
            $controllerNamespace = "\\App\\Controller\\$controllerName";

            $controller = new $controllerNamespace();
            if (method_exists($controller, $actionName)) {
                $responce = $controller->{$actionName}();
                return $responce;
            } else {
                //throw
            }
        } else {
        }
    }
}
