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
 * @package    Zend_Form
 * @subpackage Decorator
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */

/** @see Zend_Form_Decorator_Abstract */
require_once 'Zend/Form/Decorator/Abstract.php';

/**
 * Word-based captcha decorator
 *
 * Adds hidden field for ID and text input field for captcha text
 *
 * @category   Zend
 * @package    Zend_Form
 * @subpackage Element
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Word.php 23775 2011-03-01 17:25:24Z ralph $
 */
class Zend_Form_Decorator_Captcha_Word extends Zend_Form_Decorator_Abstract
{
    /**
     * Render captcha
     *
     * @param  string $content
     * @return string
     */
    public function render($content)
    {
        $element = $this->getElement();
        $view    = $element->getView();
        if (null === $view) {
            return $content;
        }

        $name = $element->getFullyQualifiedName();

        $hiddenName = $name . '[id]';
        $textName   = $name . '[input]';

        $label = $element->getDecorator("Label");
        if($label) {
            $label->setOption("id", $element->getId()."-input");
        }

        $placement = $this->getPlacement();
        $separator = $this->getSeparator();

        $hidden = $view->formHidden($hiddenName, $element->getValue(), $element->getAttribs());
        $text   = $view->formText($textName, '', $element->getAttribs());
        switch ($placement) {
            case 'PREPEND':
                $content = $hidden . $separator . $text . $separator . $content;
                break;
            case 'APPEND':
            default:
                $content = $content . $separator . $hidden . $separator . $text;
        }
        return $content;
    }
}
