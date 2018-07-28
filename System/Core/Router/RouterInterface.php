<?php

namespace Hexacore\Core\Router;

use Hexacore\Core\Request\RequestInterface;
use Hexacore\Core\Response\ResponseInterface;

interface RouterInterface
{
    public function match(RequestInterface $request): ResponseInterface;
}
