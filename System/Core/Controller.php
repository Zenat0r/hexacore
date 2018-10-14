<?php

namespace Hexacore\Core;

use Hexacore\Core\Request\RequestInterface;
use Hexacore\Core\DI\DIC;
use Hexacore\Core\Auth\AuthInterface;
use Hexacore\Core\Response\ResponseInterface;
use Hexacore\Core\Storage\StorageInterface;

abstract class Controller
{
    protected $request;

    protected $injector;

    private $auth;

    public function initialize(RequestInterface $request, DIC $dic, AuthInterface $auth)
    {
        $this->request = $request;
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
            $options = [
                "baseView" => "base.php"
            ];
        }

        if (is_string($view)) {
            $view = [$view];
            $data = [$data];
        }        

        $viewCls = $this->injector->get(View::class);

        $viewCls->init($view, $data, $options["baseView"]);

        return $viewCls->create();
    }
}
