<?php

namespace Hexacore\Core\Router;

use Hexacore\Core\Request\RequestInterface;

interface RouterInterface
{
    public function match(RequestInterface $request);
}
