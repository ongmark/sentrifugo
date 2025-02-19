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
 * @version    $Id: ChangeQuotaPool.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @category   Zend
 * @package    Zend_Service
 * @subpackage DeveloperGarden
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @author     Marco Kaiser
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Service_DeveloperGarden_Request_BaseUserService_ChangeQuotaPool
{
    /**
     * string module id
     *
     * @var string
     */
    public $moduleId = null;

    /**
     * integer >= 0 to set new user quota
     *
     * @var integer
     */
    public $quotaMax = 0;

    /**
     * constructor give them the module id
     *
     * @param string $moduleId
     * @param integer $quotaMax
     * @return Zend_Service_Developergarde_Request_ChangeQuotaPool
     */
    public function __construct($moduleId = null, $quotaMax = 0)
    {
        $this->setModuleId($moduleId)
             ->setQuotaMax($quotaMax);
    }

    /**
     * sets a new moduleId
     *
     * @param integer $moduleId
     * @return Zend_Service_Developergarde_Request_ChangeQuotaPool
     */
    public function setModuleId($moduleId = null)
    {
        $this->moduleId = $moduleId;
        return $this;
    }

    /**
     * returns the moduleId
     *
     * @return string
     */
    public function getModuleId()
    {
        return $this->moduleId;
    }

    /**
     * sets new QuotaMax value
     *
     * @param integer $quotaMax
     * @return Zend_Service_Developergarde_Request_ChangeQuotaPool
     */
    public function setQuotaMax($quotaMax = 0)
    {
        $this->quotaMax = $quotaMax;
        return $this;
    }

    /**
     * returns the quotaMax value
     *
     * @return integer
     */
    public function getQuotaMax()
    {
        return $this->quotaMax;
    }
}
