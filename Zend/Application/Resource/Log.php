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
 * @version    $Id: Log.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see Zend_Application_Resource_ResourceAbstract
 */
require_once 'Zend/Application/Resource/ResourceAbstract.php';


/**
 * Resource for initializing the locale
 *
 * @uses       Zend_Application_Resource_ResourceAbstract
 * @category   Zend
 * @package    Zend_Application
 * @subpackage Resource
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Application_Resource_Log
    extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * @var Zend_Log
     */
    protected $_log;

    /**
     * Defined by Zend_Application_Resource_Resource
     *
     * @return Zend_Log
     */
    public function init()
    {
        return $this->getLog();
    }

    /**
     * Attach logger
     *
     * @param  Zend_Log $log
     * @return Zend_Application_Resource_Log
     */
    public function setLog(Zend_Log $log)
    {
        $this->_log = $log;
        return $this;
    }

    public function getLog()
    {
        if (null === $this->_log) {
            $options = $this->getOptions();
            $log = Zend_Log::factory($options);
            $this->setLog($log);
        }
        return $this->_log;
    }
}
