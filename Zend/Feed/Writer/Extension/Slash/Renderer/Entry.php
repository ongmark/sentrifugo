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
 * @package    Zend_Feed_Writer
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Entry.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see Zend_Feed_Writer_Extension_RendererAbstract
 */
require_once 'Zend/Feed/Writer/Extension/RendererAbstract.php';

/**
 * @category   Zend
 * @package    Zend_Feed_Writer
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Feed_Writer_Extension_Slash_Renderer_Entry
    extends Zend_Feed_Writer_Extension_RendererAbstract
{

    /**
     * Set to TRUE if a rendering method actually renders something. This
     * is used to prevent premature appending of a XML namespace declaration
     * until an element which requires it is actually appended.
     *
     * @var bool
     */
    protected $_called = false;

    /**
     * Render entry
     *
     * @return void
     */
    public function render()
    {
        if (strtolower($this->getType()) == 'atom') {
            return; // RSS 2.0 only
        }
        $this->_setCommentCount($this->_dom, $this->_base);
        if ($this->_called) {
            $this->_appendNamespaces();
        }
    }

    /**
     * Append entry namespaces
     *
     * @return void
     */
    protected function _appendNamespaces()
    {
        $this->getRootElement()->setAttribute('xmlns:slash',
            'https://purl.org/rss/1.0/modules/slash/');
    }

    /**
     * Set entry comment count
     *
     * @param  DOMDocument $dom
     * @param  DOMElement $root
     * @return void
     */
    protected function _setCommentCount(DOMDocument $dom, DOMElement $root)
    {
        $count = $this->getDataContainer()->getCommentCount();
        if (!$count) {
            return;
        }
        $tcount = $this->_dom->createElement('slash:comments');
        $tcount->nodeValue = $count;
        $root->appendChild($tcount);
        $this->_called = true;
    }
}
