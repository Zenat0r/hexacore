<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 17/03/19
 * Time: 11:37
 */

namespace Hexacore\Tests\Core;

use Hexacore\Core\Annotation\Type\AnnotationType;
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
    private function authenticate()
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

    public function testGetAnnotationName()
    {
        $auth = $this->authenticate();

        $this->assertEquals("Auth", $auth->getAnnotationName());
    }

    public function testValidAnnotationType()
    {
        $annotationType = new AnnotationType("Auth");

        $auth = $this->authenticate();

        $this->assertFalse($auth->isValidAnnotationType($annotationType));
    }

    public function testUnvalidAnnotationType()
    {
        $annotationType = new AnnotationType("test");

        $auth = $this->authenticate();

        $this->assertFalse($auth->isValidAnnotationType($annotationType));
    }

    public function testProcessRoleDoesntExist()
    {
        $annotationType = new AnnotationType("Auth", "TEST_USER");

        $auth = $this->authenticate();

        $this->expectExceptionMessage("Role doesn't exist");
        $this->expectExceptionCode(401);

        $auth->process($annotationType);
    }

    public function testProcessRoleExist()
    {
        $annotationType = new AnnotationType("Auth", "ADMIN_USER");

        $auth = $this->authenticate();

        $this->expectExceptionMessage("Connection unauthorized");
        $this->expectExceptionCode(403);

        $auth->process($annotationType);
    }
}
