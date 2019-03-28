<?php

namespace Hexacore\Core;

use Hexacore\Core\Auth\AuthInterface;
use Hexacore\Core\DI\DIC;
use Hexacore\Core\Response\ResponseInterface;


abstract class Controller
{
    private $auth;

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
}
