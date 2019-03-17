<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 17/03/19
 * Time: 12:33
 */

namespace Hexacore\Tests\Core;

use Hexacore\Core\Storage\Cookie\Cookie;
use PHPUnit\Framework\TestCase;

/**
 * Class CookieTest
 * @package Hexacore\Tests\Core
 *
 * @runTestsInSeparateProcesses
 */
class CookieTest extends TestCase
{

    public function testAdd()
    {
        $cookie = new Cookie();

        $cookie->add("cookie", "value");

        $this->assertNotEmpty($_COOKIE["cookie"]);
    }

    public function testGet()
    {
        $_COOKIE["cookie"] = "value";

        $cookie = new Cookie();

        $this->assertSame("value", $cookie->get("cookie"));
    }

    public function testRemove()
    {
        $_COOKIE["cookie"] = "value";

        $cookie = new Cookie();

        $cookie->remove("cookie");

        $this->assertEmpty($_COOKIE["cookie"]);
    }
}
