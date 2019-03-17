<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 17/03/19
 * Time: 11:37
 */

namespace Hexacore\Tests\Core;

use Hexacore\Core\Auth\Auth;
use Hexacore\Core\Request\Request;
use PHPUnit\Framework\TestCase;

/**
 * Class AuthTest
 * @package Hexacore\Tests\Core
 *
 * @runTestsInSeparateProcesses
 */
class AuthTest extends TestCase
{
    public function testAuthenticateWhenTokenExist()
    {
        $_SESSION["token"] = "mySecuredToken";

        $auth = new Auth();

        $request = Request::get();

        $auth->authenticate($request);

        $this->assertNotEmpty($_SESSION["USER_ROLE"]);
    }

    public function testAuthenticateWhenTokenDoesntExist()
    {
        $auth = new Auth();

        $request = Request::get();

        $auth->authenticate($request);

        $this->assertNotEmpty($_SESSION["USER_ROLE"]);
    }

    public function testIsGranted()
    {
        $auth = new Auth();

        $request = Request::get();

        $auth->authenticate($request);

        $this->assertTrue($auth->isGranted("ANONYMOUS"));
    }

    public function testGetToken()
    {
        $auth = new Auth();

        $request = Request::get();

        $auth->authenticate($request);

        $this->assertNotEmpty($auth->getToken());
    }
}
