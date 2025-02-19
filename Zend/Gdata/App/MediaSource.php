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
 * @subpackage App
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: MediaSource.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * Interface for defining data that can be encoded and sent over the network.
 *
 * @category   Zend
 * @package    Zend_Gdata
 * @subpackage App
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
interface Zend_Gdata_App_MediaSource
{
    /**
     * Return a byte stream representation of this object.
     *
     * @return string
     */
    public function encode();

    /**
     * Set the content type for the file attached (example image/png)
     *
     * @param string $value The content type
     * @return Zend_Gdata_App_MediaFileSource Provides a fluent interface
     */
    public function setContentType($value);

    /**
     * The content type for the file attached (example image/png)
     *
     * @return string The content type
     */
    public function getContentType();

    /**
     * Sets the Slug header value.  Used by some services to determine the
     * title for the uploaded file.  A null value indicates no slug header.
     *
     * @var string The slug value
     * @return Zend_Gdata_App_MediaSource Provides a fluent interface
     */
    public function setSlug($value);

    /**
     * Returns the Slug header value.  Used by some services to determine the
     * title for the uploaded file.  Returns null if no slug should be used.
     *
     * @return string The slug value
     */
    public function getSlug();
}
