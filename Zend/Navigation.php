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
 * @category  Zend
 * @package   Zend_Navigation
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Navigation.php 23953 2011-05-03 05:47:39Z ralph $
 */

/**
 * @see Zend_Navigation_Container
 */
require_once 'Zend/Navigation/Container.php';

/**
 * A simple container class for {@link Zend_Navigation_Page} pages
 *
 * @category  Zend
 * @package   Zend_Navigation
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Navigation extends Zend_Navigation_Container
{
    /**
     * Creates a new navigation container
     *
     * @param array|Zend_Config $pages    [optional] pages to add
     * @throws Zend_Navigation_Exception  if $pages is invalid
     */
    public function __construct($pages = null)
    {
        if (is_array($pages) || $pages instanceof Zend_Config) {
            $this->addPages($pages);
        } elseif (null !== $pages) {
            require_once 'Zend/Navigation/Exception.php';
            throw new Zend_Navigation_Exception(
                    'Invalid argument: $pages must be an array, an ' .
                    'instance of Zend_Config, or null');
        }
    }
}
