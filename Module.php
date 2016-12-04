<?php

namespace MBtecZfFullUrl;

use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\ModuleManager\Feature\ControllerPluginProviderInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * Class        Module
 * @package     MBtecZfFullUrl
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     GNU General Public License
 * @link        http://mb-tec.eu
 */
class Module implements ViewHelperProviderInterface, ControllerPluginProviderInterface
{
    /**
     * @return array
     */
    public function getViewHelperConfig()
    {
        return [
            'factories' => [
                'fullUrl' => function (ServiceManager $oSm) {
                    $aConfig = $oSm->get('config');
                    $oUrlPlugin = $oSm->get('ControllerPluginManager')->get('Url');

                    $bSslAvailable = (isset($aConfig['ssl_available']))
                        ? (bool)$aConfig['ssl_available']
                        : false;

                    $sHost = (isset($aConfig['host']))
                        ? (string)$aConfig['host']
                        : '';

                    return new View\Helper\FullUrl($oUrlPlugin, $sHost, $bSslAvailable);
                },
            ],
        ];
    }

    /**
     * @return array
     */
    public function getControllerPluginConfig()
    {
        return [
            'factories' => [
                'fullUrl' => function (ServiceManager $oSm) {
                    $aConfig = (array)$oSm->get('config')['mbtec']['zf-fullurl'];
                    $oUrlPlugin = $oSm->get('ControllerPluginManager')->get('Url');

                    $bSslAvailable = (isset($aConfig['ssl_available']))
                        ? (bool)$aConfig['ssl_available']
                        : false;

                    $sHost = (isset($aConfig['host']))
                        ? (string)$aConfig['host']
                        : '';

                    return new Mvc\Controller\Plugin\FullUrl($oUrlPlugin, $sHost, $bSslAvailable);
                },
            ],
        ];
    }
}
