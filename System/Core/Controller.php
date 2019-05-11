<?php

namespace Hexacore\Core;

use Hexacore\Core\Auth\AuthInterface;
use Hexacore\Core\DI\DIC;
use Hexacore\Core\Request\ForwardRequest;
use Hexacore\Core\Response\Response;
use Hexacore\Core\Response\ResponseInterface;
use Hexacore\Core\Router\Router;
use mysql_xdevapi\Exception;


abstract class Controller
{
    /**
     * @var AuthInterface
     */
    private $auth;

    /**
     * @var DIC
     */
    protected $injector;

    public function initialize(DIC $dic, AuthInterface $auth)
    {
        $this->injector = $dic;
        $this->auth = $auth;
    }

    protected function isGranted(string $role): bool
    {
        return $this->auth->isGranted($role);
    }

    protected function render($view, array $data = null, array $options = null): ResponseInterface
    {
        if ($options == null || empty($options["baseView"])) {
            $options["baseView"] = "base.php";
        }

        if (is_string($view)) {
            $view = [$view];
            $data = [$data];
        }

        $viewCls = $this->injector->get(View::class);

        $viewCls->init($view, $data, $options["baseView"]);

        return $viewCls->create();
    }

    /**
     * @param string $controller
     * @param string $action
     * @param array $options
     * @param string $method
     * @return ResponseInterface
     */
    protected function forward(string $controller, string $action, $options = [], string $method = "GET"): ResponseInterface
    {
        $fwdRequest = new ForwardRequest();

        if (empty($options)) {
            $parameters = "";
        } else {
            $parameters = "/" . implode("/", $options);
        }

        $fwdRequest->setQueries(["_url" => "$controller/$action" . $parameters])
            ->setMethod($method);

        $router = new Router($this->auth);

        try {
            return $router->match($fwdRequest);
        } catch (\Throwable $e) {
            throw new Exception($e->getMessage(), Response::INTERNAL_SERVER_ERROR);
        }
    }
}
