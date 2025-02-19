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
 * @package    Zend_Feed_Pubsubhubbub
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: ModelAbstract.php 23775 2011-03-01 17:25:24Z ralph $
 */


/** @see Zend_Db_Table */
require_once 'Zend/Db/Table.php';

/**
 * @see Zend_Registry
 * Seems to fix the file not being included by Zend_Db_Table...
 */
require_once 'Zend/Registry.php';

/**
 * @category   Zend
 * @package    Zend_Feed_Pubsubhubbub
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Feed_Pubsubhubbub_Model_ModelAbstract
{
    /**
     * Zend_Db_Table instance to host database methods
     *
     * @var Zend_Db_Table
     */
    protected $_db = null;

    /**
     * Constructor
     *
     * @param  array $data
     * @param  Zend_Db_Table_Abstract $tableGateway
     * @return void
     */
    public function __construct(Zend_Db_Table_Abstract $tableGateway = null)
    {
        if ($tableGateway === null) {
            $parts = explode('_', get_class($this));
            $table = strtolower(array_pop($parts));
            $this->_db = new Zend_Db_Table($table);
        } else {
            $this->_db = $tableGateway;
        }
    }

}
