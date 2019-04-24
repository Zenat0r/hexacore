<?php

namespace Hexacore\Tests\Helpers;

use Hexacore\Core\Auth\AuthInterface;
use Hexacore\Core\DI\DIC;
use PHPUnit\Framework\TestCase;

class DICTest extends TestCase
{

    /**
     * @covers \Hexacore\Core\DI\DIC::start
     */
    public function testStart()
    {
        $dic = DIC::start();

        $this->assertInstanceOf(DIC::class, $dic);
    }

    /**
     * @covers \Hexacore\Core\DI\DIC::start
     * @covers \Hexacore\Core\DI\DIC::get
     * @covers \Hexacore\Core\DI\DIC::instantiate
     */
    public function testGet()
    {
        $dic = DIC::start();

        $this->assertInstanceOf(DICTest::class, $dic->get(DICTest::class));
    }

    /**
     * @uses   \Hexacore\Core\Auth\Auth
     * @covers \Hexacore\Core\DI\DIC::start
     * @covers \Hexacore\Core\DI\DIC::get
     * @covers \Hexacore\Core\DI\DIC::instantiate
     * @covers \Hexacore\Core\Config\JsonConfig
     */
    public function testGetInterface()
    {
        $dic = DIC::start();

        $this->assertInstanceOf(AuthInterface::class, $dic->get(AuthInterface::class));
    }
}
