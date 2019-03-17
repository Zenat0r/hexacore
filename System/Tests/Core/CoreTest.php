<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 16/03/19
 * Time: 18:38
 */

namespace Hexacore\Tests\Core;

use Hexacore\Core\Core;
use Hexacore\Core\Event\Dispatcher\EventManager;
use Hexacore\Core\Request\Request;
use Hexacore\Core\Response\ResponseInterface;
use PHPUnit\Framework\TestCase;

class CoreTest extends TestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testHandle()
    {
        $_SERVER['HTTP_HOST'] = "website.com";
        $_SERVER['REQUEST_URI'] = "/resource";


        $request = Request::get();
        $core = Core::boot(new EventManager());

        $this->assertInstanceOf(ResponseInterface::class, $core->handle($request));
    }
}
