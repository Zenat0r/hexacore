<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 17/03/19
 * Time: 12:10
 */

namespace Hexacore\Tests\Core;

use Hexacore\Core\Auth\Auth;
use Hexacore\Core\Request\Request;
use Hexacore\Core\Response\ResponseInterface;
use Hexacore\Core\Router\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @throws \Exception
     * @runInSeparateProcess
     */
    public function testMatch()
    {
        $request = Request::get();

        $router = new Router(new Auth());

        $this->assertInstanceOf(ResponseInterface::class, $router->match($request));
    }
}
