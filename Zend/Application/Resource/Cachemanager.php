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
 * @version    $Id: Cachemanager.php 23775 2011-03-01 17:25:24Z ralph $
 */

require_once 'Zend/Application/Resource/ResourceAbstract.php';

/**
 * Cache Manager resource
 *
 * @category   Zend
 * @package    Zend_Application
 * @subpackage Resource
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Application_Resource_Cachemanager extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * @var Zend_Cache_Manager
     */
    protected $_manager = null;

    /**
     * Initialize Cache_Manager
     *
     * @return Zend_Cache_Manager
     */
    public function init()
    {
        return $this->getCacheManager();
    }

    /**
     * Retrieve Zend_Cache_Manager instance
     *
     * @return Zend_Cache_Manager
     */
    public function getCacheManager()
    {
        if (null === $this->_manager) {
            $this->_manager = new Zend_Cache_Manager;

            $options = $this->getOptions();
            foreach ($options as $key => $value) {
                if ($this->_manager->hasCacheTemplate($key)) {
                    $this->_manager->setTemplateOptions($key, $value);
                } else {
                    $this->_manager->setCacheTemplate($key, $value);
                }
            }
        }

        return $this->_manager;
    }
}
