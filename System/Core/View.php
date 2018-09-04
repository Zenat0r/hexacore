<?php

namespace Hexacore\Core;

use Hexacore\Core\Response\ResponseInterface;
use Hexacore\Core\Response\Response;

class View
{
    private $blocks;
    private $data;
    private $base;

    public function init(array $views,array $data, string $base): void
    {
        foreach ($views as $key => $view) {
            if(is_int($key)) $this->blocks["block" . ucfirst(++$key)] = $view;
            else $this->blocks[$key] = $view;
        }
        $this->data = $data;
        $this->base = $base;
    }

    public function create(): ResponseInterface
    {
        foreach ($this->blocks as $key => $block) {
            $data = array_shift($this->data);
            extract($data);

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
