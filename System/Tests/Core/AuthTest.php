<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 17/03/19
 * Time: 11:37
 */

namespace Hexacore\Tests\Core;

use Hexacore\Core\Auth\Auth;
use Hexacore\Core\Auth\AuthInterface;
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
    private function authenticate(): AuthInterface
    {
        $auth = new Auth();

        $request = Request::get();

        $auth->authenticate($request);

        return $auth;
    }

    public function testAuthenticateWhenTokenExist()
    {
        $_SESSION["token"] = "mySecuredToken";

        $this->authenticate();

        $this->assertNotEmpty($_SESSION["USER_ROLE"]);
    }

    public function testAuthenticateWhenTokenDoesntExist()
    {
        $this->authenticate();

        $this->assertNotEmpty($_SESSION["USER_ROLE"]);
    }

    public function testIsGranted()
    {
        $auth = $this->authenticate();

        $this->assertTrue($auth->isGranted("ANONYMOUS"));
    }

    public function testGetToken()
    {
        $auth = $this->authenticate();

        $this->assertNotEmpty($auth->getToken());
    }
}
