<?php

namespace Hexacore\Tests\Core\Response;

use Hexacore\Core\Request\Request;
use Hexacore\Core\Response\Error\ErrorResponse;
use Hexacore\Core\Response\ResponseInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class ErrorResponseTest
 * @package Hexacore\Tests\Core\Response
 * @covers \Hexacore\Core\Response\Error\ErrorResponse
 */
class ErrorResponseTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testSend()
    {
        $r = new ErrorResponse("content");

        $this->assertInstanceOf(ResponseInterface::class, $r->send(Request::get()));
    }
}
