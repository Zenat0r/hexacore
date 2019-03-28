<?php

namespace App\Controller;

use Hexacore\Core\Controller;
use Hexacore\Core\Response\Response;

class IndexController extends Controller
{
    public function index(int $num = 0): Response
    {
        return $this->render([
            "main" => "index/index.php",
            "context" => "index/index2.php"
        ], [
            ["num" => $num],
            ["num" => 1337]
        ]);
    }
}
