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
    private $url;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->url = new Url();
    }

    /**
     * @uses   \Hexacore\Core\Request\Request::get
     * @uses   \Hexacore\Core\Request\Request::getServer
     * @covers \Hexacore\Helpers\Url::baseUrl
     */
    public function testBaseURl()
    {
        $this->assertRegExp('/resource$/', $this->url->baseUrl("resource"));
    }

    /**
     * @uses   \Hexacore\Core\Request\Request::get
     * @uses   \Hexacore\Core\Request\Request::getServer
     * @covers \Hexacore\Helpers\Url::baseUrl
     * @covers \Hexacore\Helpers\Url::publicUrl
     */
    public function testPublicUrl()
    {
        $this->assertRegExp('/path$/', $this->url->publicUrl("path"));
    }

    /**
     * @uses   \Hexacore\Core\Request\Request::get
     * @uses   \Hexacore\Core\Request\Request::getServer
     * @covers \Hexacore\Helpers\Url::baseUrl
     * @covers \Hexacore\Helpers\Url::styleUrl
     */
    public function testStyleUrl()
    {
        $this->assertRegExp('/css\/path$/', $this->url->styleUrl("path"));
    }

    /**
     * @uses   \Hexacore\Core\Request\Request::get
     * @uses   \Hexacore\Core\Request\Request::getServer
     * @covers \Hexacore\Helpers\Url::baseUrl
     * @covers \Hexacore\Helpers\Url::scriptUrl
     */
    public function testScriptUrl()
    {
        $this->assertRegExp('/js\/path$/', $this->url->scriptUrl("path"));
    }

    /**
     * @uses   \Hexacore\Core\Request\Request::get
     * @uses   \Hexacore\Core\Request\Request::getServer
     * @covers \Hexacore\Helpers\Url::baseUrl
     * @covers \Hexacore\Helpers\Url::fontUrl
     */
    public function testFontUrl()
    {
        $this->assertRegExp('/font\/path$/', $this->url->fontUrl("path"));
    }

    /**
     * @uses   \Hexacore\Core\Request\Request::get
     * @uses   \Hexacore\Core\Request\Request::getServer
     * @covers \Hexacore\Helpers\Url::baseUrl
     * @covers \Hexacore\Helpers\Url::imgUrl
     */
    public function testImgUrl()
    {
        $this->assertRegExp('/assets\/img\/path$/', $this->url->imgUrl("path"));
    }

    /**
     * @uses   \Hexacore\Core\Request\Request::get
     * @uses   \Hexacore\Core\Request\Request::getServer
     * @covers \Hexacore\Helpers\Url::baseUrl
     * @covers \Hexacore\Helpers\Url::videoUrl
     */
    public function testVideoUrl()
    {
        $this->assertRegExp('/assets\/vid\/path$/', $this->url->videoUrl("path"));
    }
}