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
 * @package    Zend_Gdata
 * @subpackage Photos
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: AlbumId.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see Zend_Gdata_Extension
 */
require_once 'Zend/Gdata/Extension.php';

/**
 * @see Zend_Gdata_Photos
 */
require_once 'Zend/Gdata/Photos.php';

/**
 * Represents the gphoto:albumid element used by the API. This
 * class represents the ID of an album and is usually contained
 * within an instance of Zend_Gdata_Photos_AlbumEntry or CommentEntry.
 *
 * @category   Zend
 * @package    Zend_Gdata
 * @subpackage Photos
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Gdata_Photos_Extension_AlbumId extends Zend_Gdata_Extension
{

    protected $_rootNamespace = 'gphoto';
    protected $_rootElement = 'albumid';

    /**
     * Constructs a new Zend_Gdata_Photos_Extension_AlbumId object.
     *
     * @param string $text (optional) The value to use for the Album ID.
     */
    public function __construct($text = null)
    {
        $this->registerAllNamespaces(Zend_Gdata_Photos::$namespaces);
        parent::__construct();
        $this->setText($text);
    }

}
