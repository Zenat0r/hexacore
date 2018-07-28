<?php

namespace App\Controller;

use Hexacore\Core\Controller;
use Hexacore\Core\Response\Response;

class indexController extends Controller
{
    public function index(int $num = 0): Response
    {
        //your logic
        if ($num === 42) {
            $message = "Answer to the univers $num";
        } else {
            $message = "Keep looking for the answer to the univers";
        }

        return new Response($message);
    }
}
