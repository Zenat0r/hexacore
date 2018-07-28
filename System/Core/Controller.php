<?php

namespace Hexacore\Core;

use Hexacore\Core\Request\RequestInterface;
use Hexacore\Core\DI\DIC;
use Hexacore\Core\Auth\AuthInterface;
use Hexacore\Core\Storage\Session\SessionInterface;

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
}
