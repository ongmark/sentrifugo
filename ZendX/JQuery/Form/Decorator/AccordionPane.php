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
 * @category    ZendX
 * @package     ZendX_JQuery
 * @subpackage  View
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (https://www.zend.com)
 * @license     https://framework.zend.com/license/new-bsd     New BSD License
 * @version     $Id: AccordionPane.php 20165 2010-01-09 18:57:56Z bkarwin $
 */

/**
 * @see ZendX_JQuery_Form_Decorator_UiWidgetContainer
 */
require_once "UiWidgetPane.php";

/**
 * Form Decorator for jQuery Accordion Pane View Helper
 *
 * @package    ZendX_JQuery
 * @subpackage Form
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class ZendX_JQuery_Form_Decorator_AccordionPane extends ZendX_JQuery_Form_Decorator_UiWidgetPane
{
    protected $_helper = "accordionPane";
}