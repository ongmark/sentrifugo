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
 * @version    $Id: Resource.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * Interface for bootstrap resources
 *
 * @category   Zend
 * @package    Zend_Application
 * @subpackage Resource
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
interface Zend_Application_Resource_Resource
{
    /**
     * Constructor
     *
     * Must take an optional single argument, $options.
     *
     * @param  mixed $options
     * @return void
     */
    public function __construct($options = null);

    /**
     * Set the bootstrap to which the resource is attached
     *
     * @param  Zend_Application_Bootstrap_Bootstrapper $bootstrap
     * @return Zend_Application_Resource_Resource
     */
    public function setBootstrap(Zend_Application_Bootstrap_Bootstrapper $bootstrap);

    /**
     * Retrieve the bootstrap to which the resource is attached
     *
     * @return Zend_Application_Bootstrap_Bootstrapper
     */
    public function getBootstrap();

    /**
     * Set resource options
     *
     * @param  array $options
     * @return Zend_Application_Resource_Resource
     */
    public function setOptions(array $options);

    /**
     * Retrieve resource options
     *
     * @return array
     */
    public function getOptions();

    /**
     * Strategy pattern: initialize resource
     *
     * @return mixed
     */
    public function init();
}
