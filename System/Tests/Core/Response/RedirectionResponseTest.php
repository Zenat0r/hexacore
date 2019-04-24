<?php

namespace Hexacore\Tests\Core\Response;

use Hexacore\Core\Response\Redirect\RedirectionResponse;
use Hexacore\Core\Response\ResponseInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class RedirectionResponseTest
 * @package Hexacore\Tests\Core\Response
 * @covers \Hexacore\Core\Response\Redirect\RedirectionResponse
 */
class RedirectionResponseTest extends TestCase
{

    public function test__construct()
    {
        $this->assertInstanceOf(ResponseInterface::class, new RedirectionResponse("url"));
    }
}
