<?php

namespace Hexacore\Core\Response\Json;

use Hexacore\Core\Response\Response;

class JsonResponse extends Response
{
    public function __construct($content)
    {
        $this->content = json_encode($content);
        $this->headers = ["content-type" => "text/json"];
        $this->code = 200;
    }
}