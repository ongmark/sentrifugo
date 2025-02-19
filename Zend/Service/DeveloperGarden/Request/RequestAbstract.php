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
 * @package    Zend_Service
 * @subpackage DeveloperGarden
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: RequestAbstract.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @category   Zend
 * @package    Zend_Service
 * @subpackage DeveloperGarden
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @author     Marco Kaiser
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
abstract class Zend_Service_DeveloperGarden_Request_RequestAbstract
{
    /**
     * environment value
     *
     * @var integer
     */
    public $environment = null;

    /**
     * constructor give them the environment
     *
     * @param integer $environment
     * @return Zend_Service_DeveloperGarden_Request_RequestAbstract
     */
    public function __construct($environment)
    {
        $this->setEnvironment($environment);
    }

    /**
     * sets a new moduleId
     *
     * @param integer $environment
     * @return Zend_Service_DeveloperGarden_Request_RequestAbstract
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
        return $this;
    }

    /**
     * the current configured environment value
     *
     * @return integer
     */
    public function getEnvironment()
    {
        return $this->environment;
    }
}
