<?php

namespace Hexacore\Tests\Core\Response;

use Hexacore\Core\Response\Json\JsonResponse;
use Hexacore\Core\Response\ResponseInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class JsonResponseTest
 * @package Hexacore\Tests\Core\Response
 * @covers \Hexacore\Core\Response\Json\JsonResponse
 */
class JsonResponseTest extends TestCase
{

    public function test__construct()
    {
        $this->assertInstanceOf(ResponseInterface::class, new JsonResponse("url"));
    }
}
