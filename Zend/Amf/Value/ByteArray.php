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
 * @package    Zend_Amf
 * @subpackage Value
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: ByteArray.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * Wrapper class to store an AMF3 flash.utils.ByteArray
 *
 * @package    Zend_Amf
 * @subpackage Value
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Amf_Value_ByteArray
{
    /**
     * @var string ByteString Data
     */
    protected $_data = '';

    /**
     * Create a ByteArray
     *
     * @param  string $data
     * @return void
     */
    public function __construct($data)
    {
        $this->_data = $data;
    }

    /**
     * Return the byte stream
     *
     * @return string
     */
    public function getData()
    {
        return $this->_data;
    }
}
