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
 * @version    $Id: Invalidate.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see Zend_Service_DeveloperGarden_Request_RequestAbstract
 */
require_once 'Zend/Service/DeveloperGarden/Request/RequestAbstract.php';

/**
 * @category   Zend
 * @package    Zend_Service
 * @subpackage DeveloperGarden
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @author     Marco Kaiser
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Service_DeveloperGarden_Request_SmsValidation_Invalidate
    extends Zend_Service_DeveloperGarden_Request_RequestAbstract
{
    /**
     * the number
     *
     * @var string
     */
    public $number = null;

    /**
     * create the class for validation a sms keyword
     *
     * @param integer $environment
     * @param string $keyword
     * @param string $number
     */
    public function __construct($environment, $number = null)
    {
        parent::__construct($environment);
        $this->setNumber($number);
    }

    /**
     * returns the number
     *
     * @return string $number
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * set a new number
     *
     * @param string $number
     * @return Zend_Service_DeveloperGarden_Request_SmsValidation_Validate
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }
}
