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
 * @subpackage DublinCore
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: DublinCore.php 23953 2011-05-03 05:47:39Z ralph $
 */

/**
 * @see Zend_Gdata
 */
require_once 'Zend/Gdata.php';

/**
 * Service class for interacting with the services which use the
 * DublinCore extensions.
 *
 * @category   Zend
 * @package    Zend_Gdata
 * @subpackage DublinCore
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Gdata_DublinCore extends Zend_Gdata
{

    /**
     * Namespaces used for Zend_Gdata_DublinCore
     *
     * @var array
     */
    public static $namespaces = array(
        array('dc', 'https://purl.org/dc/terms', 1, 0)
    );

    /**
     * Create Zend_Gdata_DublinCore object
     *
     * @param Zend_Http_Client $client (optional) The HTTP client to use when
     *          when communicating with the Google servers.
     * @param string $applicationId The identity of the app in the form of Company-AppName-Version
     */
    public function __construct($client = null, $applicationId = 'MyCompany-MyApp-1.0')
    {
        $this->registerPackage('Zend_Gdata_DublinCore');
        $this->registerPackage('Zend_Gdata_DublinCore_Extension');
        parent::__construct($client, $applicationId);
    }

}
