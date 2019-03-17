<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 17/03/19
 * Time: 12:17
 */

namespace Hexacore\Tests\Core;

use Hexacore\Core\Storage\Session\Session;
use PHPUnit\Framework\TestCase;

/**
 * Class SessionTest
 * @package Hexacore\Tests\Core
 *
 * @runTestsInSeparateProcesses
 */
class SessionTest extends TestCase
{

    public function testGet()
    {
        $session = new Session();

        $_SESSION["var"] = "var";

        $this->assertSame("var", $session->get("var"));
    }

    public function testAdd()
    {
        $session = new Session();
        $session->add("var", "var");

        $this->assertNotEmpty($_SESSION["var"]);
    }

    public function testRemove()
    {
        $session = new Session();

        $_SESSION["var"] = "var";
        $session->remove("var");

        $this->assertEmpty($_SESSION["var"]);
    }
}
