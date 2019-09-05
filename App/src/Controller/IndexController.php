<?php

namespace App\Controller;

use Hexacore\Core\Controller;
use Hexacore\Core\Response\Response;

class IndexController extends Controller
{
    public function index(int $num = 0): \Hexacore\Core\Response\ResponseInterface
    {
        return $this->render("index/index.php");
    }
}
