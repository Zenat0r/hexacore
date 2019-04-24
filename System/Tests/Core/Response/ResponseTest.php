<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 17/03/19
 * Time: 12:01
 */

namespace Hexacore\Tests\Core;

use Hexacore\Core\Request\Request;
use Hexacore\Core\Response\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testSend()
    {
        $response = new Response("my content");

        $request = Request::get();
        $response->send($request);

        $this->expectOutputString("my content");
    }
}
