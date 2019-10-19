<?php

namespace Hexacore\Helpers;

use Hexacore\Core\Request\Request;

class Url
{
    /**
     * @var string
     */
    private $version;

    public function __construct(string $version = '1.0')
    {
        $this->version = $version;
    }

    public function baseUrl(string $resource = null): string
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

        if (null === $resource) {
            return $url;
        } else {
            return $url .= "/{$resource}";
        }
    }

    public function publicUrl(string $path): string
    {
        return $this->baseUrl("$path");
    }

    public function styleUrl(string $path): string
    {
        return $this->baseUrl("css/$path?{$this->version}");
    }

    public function scriptUrl(string $path): string
    {
        return $this->baseUrl("js/$path?{$this->version}");
    }

    public function fontUrl(string $path): string
    {
        return $this->baseUrl("font/$path");
    }

    public function imgUrl(string $path): string
    {
        return $this->baseUrl("img/$path?{$this->version}");
    }

    public function videoUrl(string $path): string
    {
        return $this->baseUrl("vid/$path?{$this->version}");
    }
}
