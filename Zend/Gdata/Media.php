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
 * @subpackage Media
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Media.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see Zend_Gdata
 */
require_once 'Zend/Gdata.php';

/**
 * Service class for interacting with the services which use the media extensions
 * @link https://code.google.com/apis/gdata/calendar.html
 *
 * @category   Zend
 * @package    Zend_Gdata
 * @subpackage Media
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Gdata_Media extends Zend_Gdata
{

    /**
     * Namespaces used for Zend_Gdata_Photos
     *
     * @var array
     */
    public static $namespaces = array(
        array('media', 'https://search.yahoo.com/mrss/', 1, 0)
    );

    /**
     * Create Gdata_Media object
     *
     * @param Zend_Http_Client $client (optional) The HTTP client to use when
     *          when communicating with the Google Apps servers.
     * @param string $applicationId The identity of the app in the form of Company-AppName-Version
     */
    public function __construct($client = null, $applicationId = 'MyCompany-MyApp-1.0')
    {
        $this->registerPackage('Zend_Gdata_Media');
        $this->registerPackage('Zend_Gdata_Media_Extension');
        parent::__construct($client, $applicationId);
    }

}
