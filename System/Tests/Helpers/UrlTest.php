<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 16/03/19
 * Time: 15:50
 */

namespace Hexacore\Tests\Helpers;

use Hexacore\Helpers\Url;
use PHPUnit\Framework\TestCase;


class UrlTest extends TestCase
{
    public function testBaseURl()
    {
        $this->assertRegExp('/resource$/', (new Url())->baseUrl("resource"));
    }

    public function testPublicUrl()
    {
        $this->assertRegExp('/public\/path$/', (new Url())->publicUrl("path"));
    }

    public function testStyleUrl()
    {
        $this->assertRegExp('/public\/css\/path$/', (new Url())->styleUrl("path"));
    }

    public function testScriptUrl()
    {
        $this->assertRegExp('/public\/js\/path$/', (new Url())->scriptUrl("path"));
    }

    public function testFontUrl()
    {
        $this->assertRegExp('/public\/font\/path$/', (new Url())->fontUrl("path"));
    }

    public function testImgUrl()
    {
        $this->assertRegExp('/public\/assets\/img\/path$/', (new Url())->imgUrl("path"));
    }

    public function testVideoUrl()
    {
        $this->assertRegExp('/public\/assets\/vid\/path$/', (new Url())->videoUrl("path"));
    }
}