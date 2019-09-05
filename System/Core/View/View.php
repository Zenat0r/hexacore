<?php

namespace Hexacore\Core\View;

use Hexacore\Core\Response\Response;
use Hexacore\Core\Response\ResponseInterface;
use Hexacore\Core\View\ViewInterface;
use Hexacore\Helpers\Url;

class View implements ViewInterface
{
    private $blocks;
    private $data;
    private $base;
    private $url;

    public function __construct(Url $url)
    {
        $this->url = $url;
    }

    public function init(array $options = null): void
    {
        if ($options === null || empty($options['baseView'])) {
            $this->base = 'base.php';
        } else {
            $this->base = $options['baseView'];
        }

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

    public function create(string $viewPath, array $data = []): ResponseInterface
    {
        if (!empty($data)) {
            extract($this->data);
        }

        ob_start();

        require __DIR__ . "/../../../App/src/views/" . $viewPath;

        $view = ob_get_clean();

        ob_start();

        require __DIR__ . "/../../../App/src/views/" . $this->base;

        $render = ob_get_clean();

        return new Response($render);
    }
}
