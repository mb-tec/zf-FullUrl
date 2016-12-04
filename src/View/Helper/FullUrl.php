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
    protected $_oPluginUrl = null;
    protected $_sHost = '';
    protected $_bSslAvailable = false;

    /**
     * FullUrl constructor.
     *
     * @param UrlPlugin $oPluginUrl
     * @param String    $sHost
     * @param Bool      $bAvailable
     */
    public function __construct(UrlPlugin $oPluginUrl, $sHost, $bAvailable)
    {
        $this->_oPluginUrl = $oPluginUrl;
        $this->_sHost = $sHost;
        $this->_bSslAvailable = $bAvailable;
    }

    /**
     * @param string $sRoute
     * @param bool   $bSecure
     * @param array  $params
     * @param array  $options
     * @param bool   $reuseMatchedParams
     *
     * @return string
     */
    public function __invoke($sRoute, $bSecure = true, $params = [], $options = [], $reuseMatchedParams = false)
    {
        $sPath = $this->_oPluginUrl->fromRoute($sRoute, $params, $options, $reuseMatchedParams);

        return $this->_fromPath($sPath, $bSecure);
    }

    /**
     * @param      $sPath
     * @param bool $bSecure
     *
     * @return string
     */
    protected function _fromPath($sPath, $bSecure = true)
    {
        $sScheme = ($bSecure && $this->_bSslAvailable)
            ? 'https'
            : 'http';

        $oUriOut = new Uri();
        $oUriOut
            ->setScheme($sScheme)
            ->setHost($this->_sHost)
            ->setPath($sPath);

        return $oUriOut->toString();
    }
}
