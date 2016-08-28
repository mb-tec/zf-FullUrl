<?php

namespace MBtecZfFullUrl;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * Class        Module
 * @package     MBtecZfFullUrl
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     GNU General Public License
 * @link        http://mb-tec.eu
 */
class Module implements AutoloaderProviderInterface, ServiceProviderInterface
{
    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/autoload_classmap.php',
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
                'fullUrl' => function ($oPluginManager) {
                    $oServiceLocator = $oPluginManager->getServiceLocator();
                    $aConfig = (array)$oServiceLocator->get('config')['mbtec']['zf-fullurl'];
                    $oUrlPlugin = $oPluginManager->get('url');

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
