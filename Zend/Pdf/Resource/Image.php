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
 * @package    Zend_Pdf
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Image.php 23775 2011-03-01 17:25:24Z ralph $
 */


/** Internally used classes */

/** Zend_Pdf_Element_Name */
require_once 'Zend/Pdf/Element/Name.php';


/** Zend_Pdf_Resource */
require_once 'Zend/Pdf/Resource.php';


/**
 * Image abstraction.
 *
 * @package    Zend_Pdf
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
abstract class Zend_Pdf_Resource_Image extends Zend_Pdf_Resource
{
    /**
     * Object constructor.
     */
    public function __construct()
    {
        parent::__construct('');

        $this->_resource->dictionary->Type    = new Zend_Pdf_Element_Name('XObject');
        $this->_resource->dictionary->Subtype = new Zend_Pdf_Element_Name('Image');
    }
    /**
     * get the height in pixels of the image
     *
     * @return integer
     */
    abstract public function getPixelHeight();

    /**
     * get the width in pixels of the image
     *
     * @return integer
     */
    abstract public function getPixelWidth();

    /**
     * gets an associative array of information about an image
     *
     * @return array
     */
    abstract public function getProperties();
}

