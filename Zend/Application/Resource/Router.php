<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Application
 * @subpackage Resource
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Router.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see Zend_Application_Resource_ResourceAbstract
 */
require_once 'Zend/Application/Resource/ResourceAbstract.php';


/**
 * Resource for initializing the locale
 *
 * @uses       Zend_Application_Resource_Base
 * @category   Zend
 * @package    Zend_Application
 * @subpackage Resource
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Application_Resource_Router
    extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * @var Zend_Controller_Router_Rewrite
     */
    protected $_router;

    /**
     * Defined by Zend_Application_Resource_Resource
     *
     * @return Zend_Controller_Router_Rewrite
     */
    public function init()
    {
        return $this->getRouter();
    }

    /**
     * Retrieve router object
     *
     * @return Zend_Controller_Router_Rewrite
     */
    public function getRouter()
    {
        if (null === $this->_router) {
            $bootstrap = $this->getBootstrap();
            $bootstrap->bootstrap('FrontController');
            $this->_router = $bootstrap->getContainer()->frontcontroller->getRouter();

            $options = $this->getOptions();
            if (!isset($options['routes'])) {
                $options['routes'] = array();
            }

            if (isset($options['chainNameSeparator'])) {
                $this->_router->setChainNameSeparator($options['chainNameSeparator']);
            }

            if (isset($options['useRequestParametersAsGlobal'])) {
                $this->_router->useRequestParametersAsGlobal($options['useRequestParametersAsGlobal']);
            }

            $this->_router->addConfig(new Zend_Config($options['routes']));
        }

        return $this->_router;
    }
}
