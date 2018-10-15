<?php

namespace Hexacore\Helpers;

use Hexacore\Core\Request\Request;

class Url
{
    public function baseUrl(string $resource): string
    {
        $request = Request::get();
        if ($request->getServer("SERVEUR_PORT") !== 80) {
            $port = $request->getServer("SERVEUR_PORT");
        }

        if (null == $request->getServer("HTTPS")) {
            $url = "http://";
        } else {
            $url = "https://";
        }

        $url .= "{$request->getServer("SERVER_NAME")}";

        if (isset($port)) {
            $url .= ":{$port}";
        }

        return $url .= "/{$resource}";
    }

    public function publicUrl(string $path): string
    {
        return $this->baseUrl("public/$path");
    }

    public function styleUrl(string $path): string
    {
        return $this->baseUrl("public/css/$path");
    }

    public function scriptUrl(string $path): string
    {
        return $this->baseUrl("public/js/$path");
    }

    public function fontUrl(string $path): string
    {
        return $this->baseUrl("public/font/$path");
    }

    public function imgUrl(string $path): string
    {
        return $this->baseUrl("public/assets/img/$path");
    }

    public function videoUrl(string $path): string
    {
        return $this->baseUrl("public/assets/vid/$path");
    }
}
