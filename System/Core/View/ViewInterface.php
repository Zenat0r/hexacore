<?php


namespace Hexacore\Core\View;


use Hexacore\Core\Response\ResponseInterface;

interface ViewInterface
{
    public function init(array $options = null) : void;

    public function create(string $view, array $data = []) : ResponseInterface;
}