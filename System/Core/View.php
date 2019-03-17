<?php

namespace Hexacore\Core;

use Hexacore\Core\Response\Response;
use Hexacore\Core\Response\ResponseInterface;
use Hexacore\Helpers\Url;

class View
{
    private $blocks;
    private $data;
    private $base;
    private $url;

    public function __construct(Url $url)
    {
        $this->url = $url;        
    }

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
        return $this->url->baseUrl($resource);
    }

    public function publicUrl(string $path): string
    {
        return $this->url->publicUrl($path);
    }

    public function styleUrl(string $path): string
    {
        return $this->url->styleUrl($path);
    }

    public function scriptUrl(string $path): string
    {
        return $this->url->scriptUrl($path);
    }

    public function fontUrl(string $path): string
    {
        return $this->url->fontUrl($path);
    }

    public function imgUrl(string $path): string
    {
        return $this->url->publiimgUrlUrl($path);
    }

    public function videoUrl(string $path): string
    {
        return $this->url->videoUrl($path);
    }

    public function create(): ResponseInterface
    {
        $view = $this;
        foreach ($this->blocks as $_keyBlock => $_block) {
            $data = array_shift($this->data);
            if ($data != null) extract($data);

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
