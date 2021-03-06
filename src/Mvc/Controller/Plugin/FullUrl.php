<?php

namespace MBtecZfFullUrl\Mvc\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Mvc\Controller\Plugin\Url as UrlPlugin;
use Zend\Uri\Uri;

/**
 * Class        FullUrl
 * @package     MBtecZfEmailObfuscator\Mvc\Controller\Plugin
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     GPL-2.0
 * @link        http://mb-tec.eu
 */
class FullUrl extends AbstractPlugin
{
    protected $oPluginUrl = null;
    protected $sHost = '';
    protected $bSslAvailable = false;

    /**
     * FullUrl constructor.
     *
     * @param UrlPlugin $oPluginUrl
     * @param String    $sHost
     * @param Bool      $bAvailable
     */
    public function __construct(UrlPlugin $oPluginUrl, $sHost, $bAvailable)
    {
        $this->oPluginUrl = $oPluginUrl;
        $this->sHost = $sHost;
        $this->bSslAvailable = $bAvailable;
    }

    /**
     * @param       $sRoute
     * @param bool  $bSecure
     * @param array $aParams
     * @param array $aOptions
     * @param bool  $bReuseMatchedParams
     *
     * @return string
     */
    public function fromRoute($sRoute, $bSecure = true, $aParams = [], $aOptions = [], $bReuseMatchedParams = false)
    {
        $sPath = $this->oPluginUrl->fromRoute($sRoute, $aParams, $aOptions, $bReuseMatchedParams);

        return $this->fromPath($sPath, $bSecure);
    }

    /**
     * @param      $sPath
     * @param bool $bSecure
     *
     * @return string
     */
    public function fromPath($sPath, $bSecure = true)
    {
        $sScheme = ($bSecure && $this->bSslAvailable)
            ? 'https'
            : 'http';

        $oUri = new Uri();
        $oUri
            ->setScheme($sScheme)
            ->setHost($this->sHost)
            ->setPath($sPath);

        return $oUri->toString();
    }
}
