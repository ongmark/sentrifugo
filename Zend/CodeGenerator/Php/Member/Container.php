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
 * @package    Zend_CodeGenerator
 * @subpackage PHP
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Container.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @category   Zend
 * @package    Zend_CodeGenerator
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_CodeGenerator_Php_Member_Container extends ArrayObject
{

    /**#@+
     * @param const string
     */
    const TYPE_PROPERTY = 'property';
    const TYPE_METHOD   = 'method';
    /**#@-*/

    /**
     * @var const|string
     */
    protected $_type = self::TYPE_PROPERTY;

    /**
     * __construct()
     *
     * @param const|string $type
     */
    public function __construct($type = self::TYPE_PROPERTY)
    {
        $this->_type = $type;
        parent::__construct(array(), self::ARRAY_AS_PROPS);
    }

}