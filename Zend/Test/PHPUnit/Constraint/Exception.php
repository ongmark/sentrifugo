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
 * @package    Zend_Test
 * @subpackage PHPUnit
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Exception.php 23775 2011-03-01 17:25:24Z ralph $
 */

/** @see PHPUnit_Framework_ExpectationFailedException */
require_once 'PHPUnit/Framework/ExpectationFailedException.php';

/**
 * Zend_Test_PHPUnit_Constraint_Exception
 *
 * @uses       PHPUnit_Framework_ExpectationFailedException
 * @category   Zend
 * @package    Zend_Test
 * @subpackage PHPUnit
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Test_PHPUnit_Constraint_Exception extends PHPUnit_Framework_ExpectationFailedException
{
}
