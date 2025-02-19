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
 * @subpackage Gdata
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Extension.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see Zend_Gdata_App_Extension
 */
require_once 'Zend/Gdata/App/Extension.php';

/**
 * Represents a Gdata extension
 *
 * @category   Zend
 * @package    Zend_Gdata
 * @subpackage Gdata
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Gdata_Extension extends Zend_Gdata_App_Extension
{

    protected $_rootNamespace = 'gd';

    public function __construct()
    {
        /* NOTE: namespaces must be registered before calling parent */
        $this->registerNamespace('gd',
                'https://schemas.google.com/g/2005');
        $this->registerNamespace('openSearch',
                'https://a9.com/-/spec/opensearchrss/1.0/', 1, 0);
        $this->registerNamespace('openSearch',
                'https://a9.com/-/spec/opensearch/1.1/', 2, 0);
        $this->registerNamespace('rss',
                'https://blogs.law.harvard.edu/tech/rss');

        parent::__construct();
    }

}
