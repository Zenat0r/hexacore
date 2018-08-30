<?php

namespace Hexacore\Core;

use Hexacore\Core\Response\ResponseInterface;
use Hexacore\Core\Response\Response;

class View
{
    private $blocks;
    private $base;

    public function init(array $views, string $base): void
    {
        foreach ($views as $key => $view) {
            $this->blocks["block" . ucfirst(++$key)] = $view;
        }
        $this->base = $base;
    }

    public function create(): ResponseInterface
    {
        foreach ($this->blocks as $key => $block) {
            ob_start();

            require __DIR__ . "/../../App/src/views/" . $block;

            ${$key} = ob_get_clean();
        }

        ob_start();

        require __DIR__ . "/../../App/src/views/" . $this->base;

        $render = ob_get_clean();

        return new Response($render);
    }
}
