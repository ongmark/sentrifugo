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
 * @version    $Id: TearDownCall.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see Zend_Service_DeveloperGarden_VoiceButler_VoiceButlerAbstract
 */
require_once 'Zend/Service/DeveloperGarden/Request/VoiceButler/VoiceButlerAbstract.php';

/**
 * @category   Zend
 * @package    Zend_Service
 * @subpackage DeveloperGarden
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @author     Marco Kaiser
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Service_DeveloperGarden_Request_VoiceButler_TearDownCall
    extends Zend_Service_DeveloperGarden_Request_VoiceButler_VoiceButlerAbstract
{
    /**
     * the session id
     *
     * @var string
     */
    public $sessionId = null;

    /**
     * constructor give them the environment and the sessionId
     *
     * @param integer $environment
     * @param string $sessionId
     * @return Zend_Service_DeveloperGarden_Request_RequestAbstract
     */
    public function __construct($environment, $sessionId)
    {
        parent::__construct($environment);
        $this->setSessionId($sessionId);
    }

    /**
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * sets new sessionId
     *
     * @param string $sessionId
     * @return Zend_Service_DeveloperGarden_Request_VoiceButler_TearDownCall
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
        return $this;
    }
}
