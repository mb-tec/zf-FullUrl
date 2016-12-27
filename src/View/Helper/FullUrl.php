<?php

namespace MBtecZfFullUrl\View\Helper;

use Zend\Mvc\Controller\Plugin\Url as UrlPlugin;
use Zend\View\Helper as ZendHelper;
use Zend\Uri\Uri;

/**
 * Class        FullUrl
 * @package     MBtecZfFullUrl\View\Helper
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     GNU General Public License
 * @link        http://mb-tec.eu
 */
class FullUrl extends ZendHelper\AbstractHelper
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
     * @param       $bSecure
     * @param array $aParams
     * @param array $aOptions
     * @param bool  $bReuseMatchedParams
     *
     * @return string
     */
    public function __invoke($sRoute, $bSecure, $aParams = [], $aOptions = [], $bReuseMatchedParams = false)
    {
        return $this->fromRoute($sRoute, $bSecure, $aParams, $aOptions, $bReuseMatchedParams);
    }

    /**
     * @param       $sRoute
     * @param       $bSecure
     * @param array $aParams
     * @param array $aOptions
     * @param bool  $bReuseMatchedParams
     *
     * @return string
     */
    public function fromRoute($sRoute, $bSecure, $aParams = [], $aOptions = [], $bReuseMatchedParams = false)
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

        $oUriOut = new Uri();
        $oUriOut
            ->setScheme($sScheme)
            ->setHost($this->sHost)
            ->setPath($sPath);

        return $oUriOut->toString();
    }
}
