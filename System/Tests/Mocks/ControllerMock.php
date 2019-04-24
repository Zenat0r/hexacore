<?php


namespace Hexacore\Tests\Mocks;


use Hexacore\Core\Controller;
use Hexacore\Core\Request\Request;
use Hexacore\Core\Response\Response;

class ControllerMock extends Controller
{
    public function update(Request $request, string $user): Response
    {
        return new Response("mock");
    }

    public function create(Request $request, int $a = 42): Response
    {
        return new Response("mock");
    }

    public function default(string $a = "mock"): Response
    {
        return new Response("mock");
    }

    public function request(Request $request): Response
    {
        return new Response("mock");
    }

    public function di(ControllerMock $ctrl): Response
    {
        return new Response("mock");
    }
}