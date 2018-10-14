<?php

namespace Hexacore\Core;

use Hexacore\Core\Response\ResponseInterface;
use Hexacore\Core\Response\Response;
use Hexacore\Core\Request\Request;

class View
{
    private $blocks;
    private $data;
    private $base;

    public function init(array $views, array $data, string $base): void
    {
        foreach ($views as $key => $view) {
            if (is_int($key)) {
                $this->blocks["block" . ucfirst(++$key)] = $view;
            } else {
                $this->blocks[$key] = $view;
            }
        }
        $this->data = $data;
        $this->base = $base;
    }

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

    public function create(): ResponseInterface
    {
        foreach ($this->blocks as $_keyBlock => $_block) {
            $data = array_shift($this->data);
            extract($data);

            ob_start();

            require __DIR__ . "/../../App/src/views/" . $_block;

            ${$_keyBlock} = ob_get_clean();
        }

        ob_start();

        require __DIR__ . "/../../App/src/views/" . $this->base;

        $render = ob_get_clean();

        return new Response($render);
    }
}
