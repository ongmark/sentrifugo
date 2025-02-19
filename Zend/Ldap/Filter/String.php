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
 * @package    Zend_Ldap
 * @subpackage Filter
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: String.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see Zend_Ldap_Filter_Abstract
 */
require_once 'Zend/Ldap/Filter/Abstract.php';

/**
 * Zend_Ldap_Filter_String provides a simple custom string filter.
 *
 * @category   Zend
 * @package    Zend_Ldap
 * @subpackage Filter
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Ldap_Filter_String extends Zend_Ldap_Filter_Abstract
{
    /**
     * The filter.
     *
     * @var string
     */
    protected $_filter;

    /**
     * Creates a Zend_Ldap_Filter_String.
     *
     * @param string $filter
     */
    public function __construct($filter)
    {
        $this->_filter = $filter;
    }

    /**
     * Returns a string representation of the filter.
     *
     * @return string
     */
    public function toString()
    {
        return '(' . $this->_filter . ')';
    }
}