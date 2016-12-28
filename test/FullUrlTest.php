<?php

namespace MBtecZfFullUrl\Test;

use Zend\Mvc\Controller\Plugin\Url as MvcUrl;
use Zend\Router\Http\Segment;
use Zend\Router\RouteMatch;
use Zend\Router\SimpleRouteStack;
use PHPUnit_Framework_TestCase as TestCase;
use MBtecZfFullUrl\Mvc\Controller\Plugin\FullUrl as MvcFullUrl;
use MBtecZfFullUrl\View\Helper\FullUrl as ViewFullUrl;

/**
 * Class        UrlTest
 * @package     MBtecZfFullUrl\Test
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     GPL-2.0
 * @link        http://mb-tec.eu
 */
class FUllUrlTest extends TestCase
{
    protected $oRouter = null;
    protected $oRouteMatch = null;

    /**
     *
     */
    protected function setUp()
    {
        $this->oRouter = SimpleRouteStack::factory([
            'routes' => [
                'application' => [
                    'type' => Segment::class,
                    'options' => [
                        'route' => '/',
                    ],
                ],
            ],
        ]);

        $this->oRouteMatch = new RouteMatch([]);
    }

    /**
     *
     */
    public function testSSLMvcPluginFromPath()
    {
        $oPluginUrl = new MvcUrl();
        $sHost = 'www.example.com';
        $bAvailable = true;

        $oFullUrl = new MvcFullUrl($oPluginUrl, $sHost, $bAvailable);

        $sUrl = $oFullUrl->fromPath('/', true);

        $this->assertEquals('https://www.example.com/', $sUrl);
    }

    /**
     *
     */
    public function testNoSSLMvcPluginFromPath()
    {
        $oPluginUrl = new MvcUrl();
        $sHost = 'www.example.com';
        $bAvailable = false;

        $oFullUrl = new MvcFullUrl($oPluginUrl, $sHost, $bAvailable);

        $sUrl = $oFullUrl->fromPath('/', true);

        $this->assertEquals('http://www.example.com/', $sUrl);
    }

    /**
     *
     */
    public function testNoSSL2MvcPluginFromPath()
    {
        $oPluginUrl = new MvcUrl();
        $sHost = 'www.example.com';
        $bAvailable = false;

        $oFullUrl = new MvcFullUrl($oPluginUrl, $sHost, $bAvailable);

        $sUrl = $oFullUrl->fromPath('/', false);

        $this->assertEquals('http://www.example.com/', $sUrl);
    }

    /**
     *
     */
    public function testSSLViewHelperFromPath()
    {
        $oPluginUrl = new MvcUrl();
        $sHost = 'www.example.com';
        $bAvailable = true;

        $oFullUrl = new ViewFullUrl($oPluginUrl, $sHost, $bAvailable);

        $sUrl = $oFullUrl->fromPath('/', true);

        $this->assertEquals('https://www.example.com/', $sUrl);
    }

    /**
     *
     */
    public function testNoSSLViewHelperFromPath()
    {
        $oPluginUrl = new MvcUrl();
        $sHost = 'www.example.com';
        $bAvailable = false;

        $oFullUrl = new ViewFullUrl($oPluginUrl, $sHost, $bAvailable);

        $sUrl = $oFullUrl->fromPath('/', true);

        $this->assertEquals('http://www.example.com/', $sUrl);
    }

    /**
     *
     */
    public function testNoSSL2ViewHelperFromPath()
    {
        $oPluginUrl = new MvcUrl();
        $sHost = 'www.example.com';
        $bAvailable = false;

        $oFullUrl = new ViewFullUrl($oPluginUrl, $sHost, $bAvailable);

        $sUrl = $oFullUrl->fromPath('/', false);

        $this->assertEquals('http://www.example.com/', $sUrl);
    }

    /**
     *
     */
    public function testSSLMvcPluginFromRoute()
    {
        $oController = new TestController();
        $oEvent = $oController->getEvent();

        $oEvent
            ->setRouter($this->oRouter)
            ->setRouteMatch($this->oRouteMatch);

        $oPluginUrl = new MvcUrl();
        $oPluginUrl->setController($oController);

        $sHost = 'www.example.com';
        $bAvailable = true;

        $oFullUrl = new MvcFullUrl($oPluginUrl, $sHost, $bAvailable);

        $sUrl = $oFullUrl->fromRoute('application', true);

        $this->assertEquals('https://www.example.com/', $sUrl);
    }

    /**
     *
     */
    public function testSSLViewHelperFromRoute()
    {
        $oController = new TestController();
        $oEvent = $oController->getEvent();

        $oEvent
            ->setRouter($this->oRouter)
            ->setRouteMatch($this->oRouteMatch);

        $oPluginUrl = new MvcUrl();
        $oPluginUrl->setController($oController);

        $sHost = 'www.example.com';
        $bAvailable = true;

        $oFullUrl = new ViewFullUrl($oPluginUrl, $sHost, $bAvailable);

        $sUrl = $oFullUrl->fromRoute('application', true);

        $this->assertEquals('https://www.example.com/', $sUrl);
    }
}
