<?php

namespace Hexacore\Core\Response\Redirect;

use Hexacore\Core\Response\Response;

class RedirectionResponse extends Response
{
    public function __construct(string $url)
    {
        $this->content = "";
        $this->headers = ["location" => $url];
        $this->code = $this::FOUND;
    }
}
