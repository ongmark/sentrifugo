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
 * @package    Zend_Feed_Reader
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Entry.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see Zend_Feed_Reader
 */
require_once 'Zend/Feed/Reader.php';

/**
 * @see Zend_Feed_Reader_Extension_EntryAbstract
 */
require_once 'Zend/Feed/Reader/Extension/EntryAbstract.php';

/**
 * @category   Zend
 * @package    Zend_Feed_Reader
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Feed_Reader_Extension_WellFormedWeb_Entry
    extends Zend_Feed_Reader_Extension_EntryAbstract
{
    /**
     * Get the entry comment Uri
     *
     * @return string|null
     */
    public function getCommentFeedLink()
    {
        $name = 'commentRss';
        if (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        }

        $data = $this->_xpath->evaluate('string(' . $this->getXpathPrefix() . '/wfw:' . $name . ')');

        if (!$data) {
            $data = null;
        }

        $this->_data[$name] = $data;

        return $data;
    }

    /**
     * Register Slash namespaces
     *
     * @return void
     */
    protected function _registerNamespaces()
    {
        $this->_xpath->registerNamespace('wfw', 'https://wellformedweb.org/CommentAPI/');
    }
}
