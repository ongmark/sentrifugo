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
 * @version    $Id: Hex.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see Zend_Validate_Abstract
 */
require_once 'Zend/Validate/Abstract.php';

/**
 * @category   Zend
 * @package    Zend_Validate
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Validate_Hex extends Zend_Validate_Abstract
{
    const INVALID = 'hexInvalid';
    const NOT_HEX = 'notHex';

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID => "Invalid type given. String expected",
        self::NOT_HEX => "'%value%' has not only hexadecimal digit characters",
    );

    /**
     * Defined by Zend_Validate_Interface
     *
     * Returns true if and only if $value contains only hexadecimal digit characters
     *
     * @param  string $value
     * @return boolean
     */
    public function isValid($value)
    {
        if (!is_string($value) && !is_int($value)) {
            $this->_error(self::INVALID);
            return false;
        }

        $this->_setValue($value);
        if (!ctype_xdigit((string) $value)) {
            $this->_error(self::NOT_HEX);
            return false;
        }

        return true;
    }

}
