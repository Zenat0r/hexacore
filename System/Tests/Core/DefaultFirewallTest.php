<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 17/03/19
 * Time: 13:11
 */

namespace Hexacore\Tests\Core;

use Hexacore\Core\Firewall\DefaultFirewall;
use Hexacore\Core\Request\Request;
use PHPUnit\Framework\TestCase;

class DefaultFirewallTest extends TestCase
{

    public function testCheck()
    {
        $_SERVER["HTTPS"] == "off";

        $request = Request::get();
        $firewall = new DefaultFirewall();
        $this->assertTrue($firewall->check($request));
    }
}
