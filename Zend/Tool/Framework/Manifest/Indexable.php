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
 * @package    Zend_Tool
 * @subpackage Framework
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Indexable.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @category   Zend
 * @package    Zend_Tool
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
interface Zend_Tool_Framework_Manifest_Indexable extends Zend_Tool_Framework_Manifest_Interface
{

    /**
     * getActions()
     *
     * Should either return a single action, or an array
     * of actions
     *
     * @return array|Zend_Tool_Framework_Action_Interface
     */
    public function getIndex();

}
