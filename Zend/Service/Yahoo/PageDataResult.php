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
 * @subpackage Yahoo
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: PageDataResult.php 23775 2011-03-01 17:25:24Z ralph $
 */


/**
 * @see Zend_Service_Yahoo_Result
 */
require_once 'Zend/Service/Yahoo/Result.php';


/**
 * @category   Zend
 * @package    Zend_Service
 * @subpackage Yahoo
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Service_Yahoo_PageDataResult extends Zend_Service_Yahoo_Result
{
    /**
     * Web result namespace
     *
     * @var string
     */
    protected $_namespace = 'urn:yahoo:srch';


    /**
     * Initializes the web result
     *
     * @param  DOMElement $result
     * @return void
     */
    public function __construct(DOMElement $result)
    {
        $this->_fields = array();
        parent::__construct($result);
    }
}
