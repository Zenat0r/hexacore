<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 16/03/19
 * Time: 16:50
 */

namespace Hexacore\Tests\Core;

use Hexacore\Core\Request\Request;
use Hexacore\Core\Storage\Cookie\CookieInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class RequestTest
 * @package Hexacore\Tests\Core
 * @runTestsInSeparateProcesses
 */
class RequestTest extends TestCase
{
    /**
     *  Because request is a singleton we need to change global variable before
     * the instantiation
     */
    private function setInitGlobalVariables()
    {
        $_SERVER['HTTPS'] = "on";
        $_SERVER['HTTP_HOST'] = "website.com";
        $_SERVER['REQUEST_URI'] = "/resource";
        $_SERVER['REQUEST_METHOD'] = "POST";
        $_SERVER['HTTP_ACCEPT_ENCODING'] = "UTF-8";

        $_GET['var'] = 'var';
        $_POST['var'] = 'var';
    }

    public function testGetFullRequest()
    {
        $this->setInitGlobalVariables();

        $request = Request::get();

        $this->assertSame('https://website.com/resource', $request->getFullRequest());
    }

    public function testGetMethod()
    {
        $this->setInitGlobalVariables();

        $request = Request::get();

        $this->assertContains($request->getMethod(), ["POST", "GET", "PUT", "DELETE", "HEAD", "OPTIONS"]);
    }

    public function testGetHeader()
    {
        $this->setInitGlobalVariables();

        $request = Request::get();

        $this->assertSame('UTF-8', $request->getHeader()->get("ACCEPT_ENCODING"));
    }

    public function testGetQuery()
    {
        $this->setInitGlobalVariables();

        $request = Request::get();

        $this->assertSame('var', $request->getQuery('var'));
    }

    public function testGetPost()
    {
        $this->setInitGlobalVariables();

        $request = Request::get();

        $this->assertSame('var', $request->getPost('var'));
    }

    public function testGetServer()
    {
        $this->setInitGlobalVariables();

        $request = Request::get();

        $this->assertSame('website.com', $request->getServer('HTTP_HOST'));
    }

    public function testGetCookie()
    {
        $this->setInitGlobalVariables();

        $request = Request::get();

        $this->assertInstanceOf(CookieInterface::class, $request->getCookie());
    }
}