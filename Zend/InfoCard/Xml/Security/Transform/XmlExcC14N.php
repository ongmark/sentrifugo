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
 * @package    Zend_InfoCard
 * @subpackage Zend_InfoCard_Xml_Security
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: XmlExcC14N.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * Zend_InfoCard_Xml_Security_Transform_Interface
 */
require_once 'Zend/InfoCard/Xml/Security/Transform/Interface.php';

/**
 * A Transform to perform C14n XML Exclusive Canonicalization
 *
 * @category   Zend
 * @package    Zend_InfoCard
 * @subpackage Zend_InfoCard_Xml_Security
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_InfoCard_Xml_Security_Transform_XmlExcC14N
    implements Zend_InfoCard_Xml_Security_Transform_Interface
{
    /**
     * Transform the input XML based on C14n XML Exclusive Canonicalization rules
     *
     * @throws Zend_InfoCard_Xml_Security_Transform_Exception
     * @param string $strXMLData The input XML
     * @return string The output XML
     */
    public function transform($strXMLData)
    {
        $dom = new DOMDocument();
        $dom->loadXML($strXMLData);

        if(method_exists($dom, 'C14N')) {
            return $dom->C14N(true, false);
        }

        require_once 'Zend/InfoCard/Xml/Security/Transform/Exception.php';
        throw new Zend_InfoCard_Xml_Security_Transform_Exception("This transform requires the C14N() method to exist in the DOM extension");
    }
}
