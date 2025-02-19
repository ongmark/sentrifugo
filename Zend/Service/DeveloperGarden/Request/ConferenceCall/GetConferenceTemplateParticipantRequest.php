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
 * @version    $Id: GetConferenceTemplateParticipantRequest.php 23775 2011-03-01 17:25:24Z ralph $
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
class Zend_Service_DeveloperGarden_Request_ConferenceCall_GetConferenceTemplateParticipantRequest
    extends Zend_Service_DeveloperGarden_Request_RequestAbstract
{
    /**
     * the template id
     *
     * @var string
     */
    public $templateId = null;

    /**
     * the participant id
     *
     * @var string
     */
    public $participantId = null;

    /**
     * constructor
     *
     * @param integer $environment
     * @param string $templateId
     * @param string $participantId
     */
    public function __construct($environment, $templateId, $participantId)
    {
        parent::__construct($environment);
        $this->setTemplateId($templateId)
             ->setParticipantId($participantId);
    }

    /**
     * set the template id
     *
     * @param string $templateId
     * @return Zend_Service_DeveloperGarden_Request_ConferenceCall_GetConferenceTemplateParticipantRequest
     */
    public function setTemplateId($templateId)
    {
        $this->templateId = $templateId;
        return $this;
    }

    /**
     * set the participant id
     *
     * @param string $participantId
     * @return Zend_Service_DeveloperGarden_Request_ConferenceCall_GetConferenceTemplateParticipantRequest
     */
    public function setParticipantId($participantId)
    {
        $this->participantId = $participantId;
        return $this;
    }
}
