<?php

namespace Hexacore\Core\Response\Error;

use Hexacore\Core\Response\Response;
use Hexacore\Core\Response\ResponseInterface;
use Hexacore\Core\Request\RequestInterface;

class ErrorResponse extends Response
{
    public function send(RequestInterface $request): ResponseInterface
    {
        header($request->getServer("SERVER_PROTOCOL") . " " . $this->code . " " . self::$status[$this->code]);

        include "error_view.php";

        return $this;
    }
}
