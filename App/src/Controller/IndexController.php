<?php

namespace App\Controller;

use Hexacore\Core\Controller;
use Hexacore\Core\Response\Response;

class indexController extends Controller
{
    public function index(int $num = 0): Response
    {
        return $this->render("index/index.php", [
            "num" => $num
        ]);
    }
}
