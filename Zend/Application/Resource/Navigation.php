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
 * @version    $Id: Navigation.php 24114 2011-06-04 01:51:02Z freak $
 */

/**
 * @see Zend_Application_Resource_ResourceAbstract
 */
require_once 'Zend/Application/Resource/ResourceAbstract.php';


/**
 * Resource for setting navigation structure
 *
 * @uses       Zend_Application_Resource_ResourceAbstract
 * @category   Zend
 * @package    Zend_Application
 * @subpackage Resource
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @author     Dolf Schimmel
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Application_Resource_Navigation
    extends Zend_Application_Resource_ResourceAbstract
{
    const DEFAULT_REGISTRY_KEY = 'Zend_Navigation';

    /**
     * @var Zend_Navigation
     */
    protected $_container;

    /**
     * Defined by Zend_Application_Resource_Resource
     *
     * @return Zend_Navigation
     */
    public function init()
    {
        if (!$this->_container) {
            $options = $this->getOptions();

            if(isset($options['defaultPageType'])) {
                Zend_Navigation_Page::setDefaultPageType($options['defaultPageType']);
            }
            
            $pages = isset($options['pages']) ? $options['pages'] : array();
            $this->_container = new Zend_Navigation($pages);
        }

        $this->store();
        return $this->_container;
    }

    /**
     * Stores navigation container in registry or Navigation view helper
     *
     * @return void
     */
    public function store()
    {
        $options = $this->getOptions();
        if (isset($options['storage']['registry']) &&
            $options['storage']['registry'] == true) {
            $this->_storeRegistry();
        } else {
            $this->_storeHelper();
        }
    }

    /**
     * Stores navigation container in the registry
     *
     * @return void
     */
    protected function _storeRegistry()
    {
        $options = $this->getOptions();
        if(isset($options['storage']['registry']['key']) &&
           !is_numeric($options['storage']['registry']['key'])) // see ZF-7461
        {
           $key = $options['storage']['registry']['key'];
        } else {
            $key = self::DEFAULT_REGISTRY_KEY;
        }

        Zend_Registry::set($key,$this->getContainer());
    }

    /**
     * Stores navigation container in the Navigation helper
     *
     * @return void
     */
    protected function _storeHelper()
    {
        $this->getBootstrap()->bootstrap('view');
        $view = $this->getBootstrap()->view;
        $view->getHelper('navigation')->navigation($this->getContainer());
    }

    /**
     * Returns navigation container
     *
     * @return Zend_Navigation
     */
    public function getContainer()
    {
        return $this->_container;
    }
}
