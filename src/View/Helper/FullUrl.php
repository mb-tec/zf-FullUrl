<?php

namespace MBtecZfFullUrl\View\Helper;

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
     * @param $bAvailable
     *
     * @return $this
     */
    public function setSslAvailable($bAvailable)
    {
        $this->_bSslAvailable = $bAvailable;

        return $this;
    }

    /**
     * @param $sHost
     *
     * @return $this
     */
    public function setHost($sHost)
    {
        $this->_sHost = $sHost;

        return $this;
    }


    /**
     * @param $oPluginUrl
     *
     * @return $this
     */
    public function setUrlPlugin(ZendHelper\Url $oPluginUrl)
    {
        $this->_oPluginUrl = $oPluginUrl;

        return $this;
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
        $sScheme = ($bSecure && $this->_bSslAvailable)
            ? 'https'
            : 'http';

        $oUriOut = new Uri();
        $oUriOut
            ->setScheme($sScheme)
            ->setHost($this->_sHost)
            ->setPath($this->_oPluginUrl->__invoke($sRoute, $params, $options, $reuseMatchedParams));

        return $oUriOut->toString();
    }
}
