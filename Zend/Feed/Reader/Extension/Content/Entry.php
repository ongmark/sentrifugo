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
 * @see Zend_Feed_Reader_Entry_EntryAbstract
 */
require_once 'Zend/Feed/Reader/Extension/EntryAbstract.php';

/**
 * @category   Zend
 * @package    Zend_Feed_Reader
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Feed_Reader_Extension_Content_Entry
    extends Zend_Feed_Reader_Extension_EntryAbstract
{

    public function getContent()
    {
        if ($this->getType() !== Zend_Feed_Reader::TYPE_RSS_10
            && $this->getType() !== Zend_Feed_Reader::TYPE_RSS_090
        ) {
            $content = $this->_xpath->evaluate('string('.$this->getXpathPrefix().'/content:encoded)');
        } else {
            $content = $this->_xpath->evaluate('string('.$this->getXpathPrefix().'/content:encoded)');
        }
        return $content;
    }

    /**
     * Register RSS Content Module namespace
     */
    protected function _registerNamespaces()
    {
        $this->_xpath->registerNamespace('content', 'https://purl.org/rss/1.0/modules/content/');
    }
}
