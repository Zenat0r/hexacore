<?php

namespace Hexacore\Core;

use Hexacore\Core\Request\RequestInterface;
use Hexacore\Core\DI\DIC;
use Hexacore\Core\Auth\AuthInterface;
use Hexacore\Core\Response\ResponseInterface;

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

    protected function isGranted(StorageInterface $storage, string $role): bool
    {
        return $this->auth->isGranted($storage, $role);
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
        }

        $viewCls = $this->injector->get(View::class);

        $viewCls->init($view, $options["baseView"]);

        return $viewCls->create();
    }
}
