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
 * @package    Zend_Validate
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: AdapterInterface.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @category   Zend
 * @package    Zend_Validate
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
interface Zend_Validate_Barcode_AdapterInterface
{
    /**
     * Checks the length of a barcode
     *
     * @param  string $value  The barcode to check for proper length
     * @return boolean
     */
    public function checkLength($value);

    /**
     * Checks for allowed characters within the barcode
     *
     * @param  string $value The barcode to check for allowed characters
     * @return boolean
     */
    public function checkChars($value);

    /**
     * Validates the checksum
     *
     * @param string $value The barcode to check the checksum for
     * @return boolean
     */
    public function checksum($value);

    /**
     * Returns if barcode uses a checksum
     *
     * @return boolean
     */
    public function getCheck();

    /**
     * Sets the checksum validation
     *
     * @param  boolean $check
     * @return Zend_Validate_Barcode_Adapter Provides fluid interface
     */
    public function setCheck($check);
}
