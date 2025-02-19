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
 * @version     $Id: UiWidgetContainer.php 20745 2010-01-29 10:34:00Z beberlei $
 */

require_once "Zend/Form/Decorator/Abstract.php";

/**
 * Abstract Form Decorator for all jQuery UI Widget Containers
 *
 * @package    ZendX_JQuery
 * @subpackage Form
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
abstract class ZendX_JQuery_Form_Decorator_UiWidgetContainer extends Zend_Form_Decorator_Abstract
{
    /**
     * View helper
     * @var string
     */
    protected $_helper;

    /**
     * Element attributes
     * @var array
     */
    protected $_attribs;

    /**
     * jQuery option parameters
     * @var array
     */
    protected $_jQueryParams;

    /**
     * Get view helper for rendering container
     *
     * @return string
     */
    public function getHelper()
    {
        if (null === $this->_helper) {
            require_once 'Zend/Form/Decorator/Exception.php';
            throw new Zend_Form_Decorator_Exception('No view helper specified fo DijitContainer decorator');
        }
        return $this->_helper;
    }

    /**
     * Get element attributes
     *
     * @return array
     */
    public function getAttribs()
    {
        if (null === $this->_attribs) {
            $attribs = $this->getElement()->getAttribs();
            if (array_key_exists('jQueryParams', $attribs)) {
                $this->getJQueryParams();
                unset($attribs['jQueryParams']);
            }
            $this->_attribs = $attribs;
        }
        return $this->_attribs;
    }

    /**
     * Get jQuery option parameters
     *
     * @return array
     */
    public function getJQueryParams()
    {
        if (null === $this->_jQueryParams) {
            $this->_jQueryParams = array();
            if($attribs = $this->getElement()->getAttribs()) {
                if (array_key_exists('jQueryParams', $attribs)) {
                    $this->_jQueryParams = $attribs['jQueryParams'];
                }
            }

            if($options = $this->getOptions()) {
                if (array_key_exists('jQueryParams', $options)) {
                    $this->_jQueryParams = array_merge($this->_jQueryParams, $options['jQueryParams']);
                    $this->removeOption('jQueryParams');
                }
            }
        }

        return $this->_jQueryParams;
    }

    /**
     * Render an jQuery UI Widget element using its associated view helper
     *
     * Determine view helper from 'helper' option, or, if none set, from
     * the element type. Then call as
     * helper($element->getName(), $element->getValue(), $element->getAttribs())
     *
     * @param  string $content
     * @return string
     * @throws Zend_Form_Decorator_Exception if element or view are not registered
     */
    public function render($content)
    {
        $element = $this->getElement();
        $view    = $element->getView();
        if (null === $view) {
            return $content;
        }

        $jQueryParams = $this->getJQueryParams();
        $attribs     = $this->getOptions();

        $helper      = $this->getHelper();
        $id          = $element->getId() . '-container';

        return $view->$helper($id, $jQueryParams, $attribs);
    }
}