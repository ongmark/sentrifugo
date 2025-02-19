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
 * @version    $Id: ParticipantStatus.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see Zend_Validate_Ip
 */
require_once 'Zend/Validate/Ip.php';

/**
 * @category   Zend
 * @package    Zend_Service
 * @subpackage DeveloperGarden
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @author     Marco Kaiser
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Service_DeveloperGarden_ConferenceCall_ParticipantStatus
{
    /**
     * @var string
     */
    public $name = null;

    /**
     * @var string
     */
    public $value = null;

    /**
     * constructor for participant status object
     *
     * @param string $vame
     * @param string $value
     */
    public function __construct($name, $value = null)
    {
        $this->setName($name)
             ->setValue($value);
    }

    /**
     * returns the value of $name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * sets $name
     *
     * @param string $name
     * @return Zend_Service_DeveloperGarden_ConferenceCall_ParticipantStatus
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * returns the value of $value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * sets $value
     *
     * @param string $value
     * @return Zend_Service_DeveloperGarden_ConferenceCall_ParticipantStatus
     */
    public function setValue($value = null)
    {
        $this->value = $value;
        return $this;
    }
}
