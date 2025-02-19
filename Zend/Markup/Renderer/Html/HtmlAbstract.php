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
 * @package    Zend_Markup
 * @subpackage Renderer_Html
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: HtmlAbstract.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see Zend_Markup_Renderer_TokenConverterInterface
 */
require_once 'Zend/Markup/Renderer/TokenConverterInterface.php';

/**
 * Tag interface
 *
 * @category   Zend
 * @package    Zend_Markup
 * @subpackage Renderer_Html
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
abstract class Zend_Markup_Renderer_Html_HtmlAbstract implements Zend_Markup_Renderer_TokenConverterInterface
{

    /**
     * The HTML renderer
     *
     * @var Zend_Markup_Renderer_Html
     */
    protected $_renderer;


    /**
     * Set the HTML renderer instance
     *
     * @param Zend_Markup_Renderer_Html $renderer
     *
     * @return Zend_Markup_Renderer_Html_HtmlAbstract
     */
    public function setRenderer(Zend_Markup_Renderer_Html $renderer)
    {
        $this->_renderer = $renderer;
    }

    /**
     * Get the HTML renderer instance
     *
     * @return Zend_Markup_Renderer_Html
     */
    public function getRenderer()
    {
        return $this->_renderer;
    }
}
