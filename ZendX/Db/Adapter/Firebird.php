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
 * @category   ZendX
 * @package    ZendX_Db
 * @subpackage Adapter
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: $
 */

/**
 * @see Zend_Db_Adapter_Abstract
 */
require_once 'Zend/Db/Adapter/Abstract.php';

/**
 * @see Zend_Db_Profiler
 */
require_once 'Zend/Db/Profiler.php';

/**
 * @see Zend_Db_Select
 */
require_once 'Zend/Db/Select.php';

/**
 * @see Zend_Db_Statement_Firebird
 */
require_once 'ZendX/Db/Statement/Firebird.php';


/**
 * @category   ZendX
 * @package    ZendX_Db
 * @subpackage Adapter
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class ZendX_Db_Adapter_Firebird extends Zend_Db_Adapter_Abstract
{
    /**
     * Specifies whether the adapter automatically quotes identifiers.
     * If true, most SQL generated by Zend_Db classes applies
     * identifier quoting automatically.
     * If false, developer must quote identifiers themselves
     * by calling quoteIdentifier().
     *
     * @var bool
     */
    protected $_autoQuoteIdentifiers = true;

    /**
     * The transaction resource.
     *
     * @var transaction
     */
    protected $_transResource = null;

    /**
     * Return the status of current transaction.
     * @return bool
     */

    public function getTransaction()
    {
        return (is_resource($this->_transResource) ? $this->_transResource : null);
    }

    /**
     * Keys are UPPERCASE SQL datatypes or the constants
     * Zend_Db::INT_TYPE, Zend_Db::BIGINT_TYPE, or Zend_Db::FLOAT_TYPE.
     *
     * Values are:
     * 0 = 32-bit integer
     * 1 = 64-bit integer
     * 2 = float or decimal
     *
     * @var array Associative array of datatypes to values 0, 1, or 2.
     */
    protected $_numericDataTypes = array(
        Zend_Db::INT_TYPE    => Zend_Db::INT_TYPE,
        Zend_Db::BIGINT_TYPE => Zend_Db::BIGINT_TYPE,
        Zend_Db::FLOAT_TYPE  => Zend_Db::FLOAT_TYPE,
        'SMALLINT'           => Zend_Db::INT_TYPE,
        'INT'                => Zend_Db::INT_TYPE,
        'INTEGER'            => Zend_Db::INT_TYPE,
        'BIGINT'             => Zend_Db::BIGINT_TYPE,
        'INT64'              => Zend_Db::BIGINT_TYPE,
        'DECIMAL'            => Zend_Db::FLOAT_TYPE,
        'DOUBLE PRECISION'   => Zend_Db::FLOAT_TYPE,
        'DOUBLE'             => Zend_Db::FLOAT_TYPE,
        'NUMERIC'            => Zend_Db::FLOAT_TYPE,
        'FLOAT'              => Zend_Db::FLOAT_TYPE
    );

    /**
     * Quote a raw string.
     *
     * @param string $value     Raw string
     * @return string           Quoted string
     */
    protected function _quote($value)
    {
        if (is_int($value) || is_float($value)) {
            return $value;
        }
        $value = str_replace("'", "''", $value);
        return "'" . $value . "'";
    }

    /**
     * Returns a list of the tables in the database.
     *
     * @return array
     */
    public function listTables()
    {
        $data = $this->fetchCol('SELECT RDB$RELATION_NAME FROM RDB$RELATIONS WHERE RDB$SYSTEM_FLAG = 0');
        foreach($data as &$v)
            $v = trim($v);
        return $data;
    }

    /**
     * Returns the column descriptions for a table.
     *
     * The return value is an associative array keyed by the column name,
     * as returned by the RDBMS.
     *
     * The value of each array element is an associative array
     * with the following keys:
     *
     * SCHEMA_NAME      => string; name of database or schema
     * TABLE_NAME       => string;
     * COLUMN_NAME      => string; column name
     * COLUMN_POSITION  => number; ordinal position of column in table
     * DATA_TYPE        => string; SQL datatype name of column
     * DEFAULT          => string; default expression of column, null if none
     * NULLABLE         => boolean; true if column can have nulls
     * LENGTH           => number; length of CHAR/VARCHAR
     * SCALE            => number; scale of NUMERIC/DECIMAL
     * PRECISION        => number; precision of NUMERIC/DECIMAL
     * UNSIGNED         => boolean; unsigned property of an integer type
     * PRIMARY          => boolean; true if column is part of the primary key
     * PRIMARY_POSITION => integer; position of column in primary key
     * IDENTITY         => integer; true if column is auto-generated with unique values
     *
     * @param string $tableName
     * @param string $schemaName OPTIONAL
     * @return array
     */
    public function describeTable($tableName, $schemaName = null)
    {
        $fieldMaps = array(
            'TEXT'      => 'CHAR',
            'VARYING'   => 'VARCHAR',
            'SHORT'     => 'SMALLINT',
            'LONG'      => 'INTEGER',
            'FLOAT'     => 'FLOAT',
            'INT64'     => array(0 => 'BIGINT', 'NUMERIC', 'DECIMAL'),
            'DATE'      => 'DATE',
            'TIME'      => 'TIME',
            'BLOB'      => 'BLOB',
            'DOUBLE'    => 'DOUBLE PRECISION',
            'TIMESTAMP' => 'TIMESTAMP'
        );

        $sql = 'select
                    RF.RDB$RELATION_NAME, \'\', RF.RDB$FIELD_NAME, T.RDB$TYPE_NAME,
                    RF.RDB$DEFAULT_VALUE, RF.RDB$NULL_FLAG, RF.RDB$FIELD_POSITION,
                    F.RDB$CHARACTER_LENGTH, F.RDB$FIELD_SCALE, F.RDB$FIELD_PRECISION,
                    IXS.RDB$FIELD_POSITION, IXS.RDB$FIELD_POSITION, F.RDB$FIELD_SUB_TYPE
                from RDB$RELATION_FIELDS RF
                left join RDB$RELATION_CONSTRAINTS RC
                    on (RF.RDB$RELATION_NAME = RC.RDB$RELATION_NAME and RC.RDB$CONSTRAINT_TYPE = \'PRIMARY KEY\')
                left join RDB$INDEX_SEGMENTS IXS
                    on (IXS.RDB$FIELD_NAME = RF.RDB$FIELD_NAME and RC.RDB$INDEX_NAME = IXS.RDB$INDEX_NAME)
                inner join RDB$FIELDS F on (RF.RDB$FIELD_SOURCE = F.RDB$FIELD_NAME)
                inner join RDB$TYPES T on (T.RDB$TYPE = F.RDB$FIELD_TYPE and T.RDB$FIELD_NAME = \'RDB$FIELD_TYPE\')
                where ' . $this->quoteInto('(UPPER(RF.RDB$RELATION_NAME) = UPPER(?)) ', $tableName) . '
                order by RF.RDB$FIELD_POSITION';

        $stmt = $this->query($sql);

        /**
         * Use FETCH_NUM so we are not dependent on the CASE attribute of the PDO connection
         */
        $result = $stmt->fetchAll(Zend_Db::FETCH_NUM);

        $table_name      = 0;
        $owner           = 1;
        $column_name     = 2;
        $data_type       = 3;
        $data_default    = 4;
        $nullable        = 5;
        $column_id       = 6;
        $data_length     = 7;
        $data_scale      = 8;
        $data_precision  = 9;
        $constraint_type = 10;
        $position        = 11;
        $sub_type        = 12;

        $desc = array();
        foreach ($result as $key => $row) {
            list ($primary, $primaryPosition, $identity) = array(false, null, false);
            if (strlen($row[$constraint_type])) {
                $primary = true;
                $primaryPosition = $row[$position];
                /**
                 * Firebird does not support auto-increment keys.
                 */
                $identity = false;
            }

            $dataType = trim($row[$data_type]);
            $newType = $fieldMaps[$dataType];
            if (is_array($newType) && $dataType == 'INT64')
                $newType = $newType[$row[$sub_type]];
            $row[$data_type] = $newType;

            $desc[trim($row[$column_name])] = array(
                'SCHEMA_NAME'      => '',
                'TABLE_NAME'       => trim($row[$table_name]),
                'COLUMN_NAME'      => trim($row[$column_name]),
                'COLUMN_POSITION'  => $row[$column_id] +1,
                'DATA_TYPE'        => $row[$data_type],
                'DEFAULT'          => $row[$data_default],
                'NULLABLE'         => (bool) ($row[$nullable] != '1'),
                'LENGTH'           => $row[$data_length],
                'SCALE'            => ($row[$data_scale] == 0 ? null : $row[$data_scale]),
                'PRECISION'        => ($row[$data_precision] == 0 ? null : $row[$data_precision]),
                'UNSIGNED'         => false,
                'PRIMARY'          => $primary,
                'PRIMARY_POSITION' => ($primary ? $primaryPosition+1 : null),
                'IDENTITY'         => $identity
            );
        }
        return $desc;
    }


    /**
     * Format a connection string to connect to database
     *
     * @return void
     */
    protected function _formatDbConnString($host, $port, $dbname)
    {
        if (is_numeric($port))
            $port = '/' . (integer) $port;
        if ($dbname)
            $dbname = ':' . $dbname;

        return $host . $port . $dbname;

    }

    /**
     * Creates a connection to the database.
     *
     * @return void
     * @throws ZendX_Db_Adapter_Firebird_Exception
     */
    protected function _connect()
    {
        if (isset($this->_connection) && is_resource($this->_connection)) {
            return;
        }

        if (!extension_loaded('interbase')) {
            /**
             * @see ZendX_Db_Adapter_Firebird_Exception
             */
            require_once 'ZendX/Db/Adapter/Firebird/Exception.php';
            throw new ZendX_Db_Adapter_Firebird_Exception('The Interbase extension is required for this adapter but the extension is not loaded');
        }


        // Suppress connection warnings here.
        // Throw an exception instead.
        $this->_connection = @ibase_connect(
                                $this->_formatDbConnString($this->_config['host'],$this->_config['port'] ,$this->_config['dbname']),
                                $this->_config['username'],
                                $this->_config['password'],
                                $this->_config['charset'],
                                $this->_config['buffers'],
                                $this->_config['dialect'],
                                $this->_config['role']
                              );

        if ($this->_connection === false) {
            /**
             * @see ZendX_Db_Adapter_Firebird_Exception
             */
            require_once 'ZendX/Db/Adapter/Firebird/Exception.php';
            throw new ZendX_Db_Adapter_Firebird_Exception(ibase_errmsg());
        }
    }

    /**
     * Force the connection to close.
     *
     * @return void
     */
    public function closeConnection()
    {
        if (is_resource($this->_transResource)) {
            ibase_rollback($this->_transResource);
        }
        $this->_transResource = null;

        if (is_resource($this->_connection)) {
            unset($this->_connection);
        }
        //$this->_connection = false;
    }

    /**
     * Prepare a statement and return a Statement resource.
     *
     * @param  string  $sql  SQL query
     * @return ZendX_Db_Statement_Firebird
     */
    public function prepare($sql)
    {
        $this->_connect();

        $stmt = new ZendX_Db_Statement_Firebird($this, $sql);
        if ($stmt === false) {
            return false;
        }
        $stmt->setFetchMode($this->_fetchMode);
        return $stmt;
    }

    /**
     * Gets the last ID generated automatically by an IDENTITY/AUTOINCREMENT column.
     *
     * As a convention, on RDBMS brands that support sequences
     * (e.g. Firebird, Oracle, PostgreSQL, DB2), this method forms the name of a sequence
     * from the arguments and returns the last id generated by that sequence.
     * On RDBMS brands that support IDENTITY/AUTOINCREMENT columns, this method
     * returns the last value generated for such a column, and the table name
     * argument is disregarded.
     *
     * Firebird does not support IDENTITY columns, so if the sequence is not
     * specified, this method returns null.
     *
     * @param string $tableName   OPTIONAL Name of table.
     * @param string $primaryKey  OPTIONAL Name of primary key column.
     * @return string
     * @throws ZendX_Db_Adapter_Firebird_Exception
     */
    public function lastInsertId($tableName = null, $primaryKey = null)
    {
        if ($tableName !== null) {
            $sequenceName = $tableName;
            if ($primaryKey) {
                $sequenceName .= "_$primaryKey";
            }
            $sequenceName .= '_seq';
            return $this->lastSequenceId($sequenceName);
        }

        // No support for IDENTITY columns; return null
        return null;
    }

    /**
     * Begin a transaction.
     *
     * @return void
     */
    protected function _beginTransaction()
    {
        $this->_connect();
        if (is_resource($this->_transResource)){
            return;
        }

        $this->_transResource = ibase_trans(IBASE_DEFAULT, $this->_connection);
    }

    /**
     * Commit a transaction.
     *
     * @return void
     */
    protected function _commit()
    {
        if (false === ibase_commit(is_resource($this->_transResource) ? $this->_transResource : $this->_connection)) {
            /**
             * @see ZendX_Db_Adapter_Firebird_Exception
             */
            require_once 'ZendX/Db/Adapter/Firebird/Exception.php';
            throw new ZendX_Db_Adapter_Firebird_Exception(ibase_errmsg());
        }
        $this->_transResource = null;
    }

    /**
     * Roll-back a transaction.
     *
     * @return void
     */
    protected function _rollBack()
    {
        if (false === ibase_rollback(is_resource($this->_transResource) ? $this->_transResource : $this->_connection)) {
            /**
             * @see ZendX_Db_Adapter_Firebird_Exception
             */
            require_once 'ZendX/Db/Adapter/Firebird/Exception.php';
            throw new ZendX_Db_Adapter_Firebird_Exception(ibase_errmsg());
        }
        $this->_transResource = null;
    }

    /**
     * Set the fetch mode.
     *
     * @param int $mode
     * @return void
     */
    public function setFetchMode($mode)
    {
        switch ($mode) {
            case Zend_Db::FETCH_LAZY:
            case Zend_Db::FETCH_ASSOC:
            case Zend_Db::FETCH_NUM:
            case Zend_Db::FETCH_BOTH:
            case Zend_Db::FETCH_NAMED:
            case Zend_Db::FETCH_OBJ:
            case Zend_Db::FETCH_BOUND: // bound to PHP variable
                $this->_fetchMode = $mode;
                break;
            default:
                /**
                 * @see ZendX_Db_Adapter_Firebird_Exception
                 */
                require_once 'ZendX/Db/Adapter/Firebird/Exception.php';
                throw new ZendX_Db_Adapter_Firebird_Exception("Invalid fetch mode '$mode' specified");
        }
    }

    /**
     * Adds an adapter-specific LIMIT clause to the SELECT statement.
     *
     * @param string $sql
     * @param integer $count
     * @param integer $offset
     * @throws Zend_Db_Adapter_Exception
     * @return string
     */
    public function limit($sql, $count, $offset = 0)
    {
        $count = intval($count);
        if ($count <= 0) {
            /**
             * @see ZendX_Db_Adapter_Firebird_Exception
             */
            require_once 'ZendX/Db/Adapter/Firebird/Exception.php';
            throw new ZendX_Db_Adapter_Firebird_Exception("LIMIT argument count=$count is not valid");
        }

        $offset = intval($offset);
        if ($offset < 0) {
            /**
             * @see ZendX_Db_Adapter_Firebird_Exception
             */
            require_once 'ZendX/Db/Adapter/Firebird/Exception.php';
            throw new ZendX_Db_Adapter_Firebird_Exception("LIMIT argument offset=$offset is not valid");
        }

        if (trim($sql) == ''){
            //Only compatible with FB 2.0 or newer
            //ZF 1.5.0 don't support limit sql syntax that don't only append texto to sql, fixed in 1.5.1
            $sql .= " rows $count";
            if ($offset > 0)
                $sql .= " to $offset";
        }
        else
            $sql = substr_replace($sql, "select first $count skip $offset ", stripos($sql, 'select'), 6);

        return $sql;
    }

        /**
     * Quote a table identifier and alias.
     *
     * @param string|array|Zend_Db_Expr $ident The identifier or expression.
     * @param string $alias An alias for the table.
     * @param boolean $auto If true, heed the AUTO_QUOTE_IDENTIFIERS config option.
     * @return string The quoted identifier and alias.
     */
    public function quoteTableAs($ident, $alias = null, $auto=false)
    {
        // Firebird doesn't allow the 'AS' keyword between the table identifier/expression and alias.
        return $this->_quoteIdentifierAs($ident, $alias, $auto, ' ');
    }

    /**
     * Return the most recent value from the specified sequence in the database.
     * This is supported only on RDBMS brands that support sequences
     * (e.g. Firebird, Oracle, PostgreSQL, DB2).  Other RDBMS brands return null.
     *
     * @param string $sequenceName
     * @return string
     */
    public function lastSequenceId($sequenceName)
    {
        $this->_connect();
        $sql = 'SELECT GEN_ID('.$this->quoteIdentifier($sequenceName).', 0) FROM RDB$DATABASE';
        $value = $this->fetchOne($sql);
        return $value;
    }

    /**
     * Generate a new value from the specified sequence in the database, and return it.
     * This is supported only on RDBMS brands that support sequences
     * (e.g. Firebird, Oracle, PostgreSQL, DB2).  Other RDBMS brands return null.
     *
     * @param string $sequenceName
     * @return integer
     */
    public function nextSequenceId($sequenceName)
    {
        $this->_connect();
        $sql = 'SELECT GEN_ID('.$this->quoteIdentifier($sequenceName).', 1) FROM RDB$DATABASE';
        $value = $this->fetchOne($sql);
        return $value;
    }

    /**
     * Check if the adapter supports real SQL parameters.
     *
     * @param string $type 'positional' or 'named'
     * @return bool
     */
    public function supportsParameters($type)
    {
        switch ($type) {
            case 'positional':
                return true;
            case 'named':
            default:
                return false;
        }
    }

    /**
     * Test if a connection is active
     *
     * @return boolean
     */
    public function isConnected()
    {
        return ((bool) (is_resource($this->_connection)
                     && get_resource_type($this->_connection) == 'Firebird/InterBase link'));
    }

    /**
     * Retrieve server version in PHP style
     *
     * @return string
     */
    public function getServerVersion()
    {
        $this->_connect();
        $service = ibase_service_attach($this->_formatDbConnString($this->_config['host'], $this->_config['port'], ''), $this->_config['username'], $this->_config['password']);

        if ($service != FALSE) {
            $server_info  = ibase_server_info($service, IBASE_SVC_SERVER_VERSION);
            ibase_service_detach($service);
            $matches = null;
            if (preg_match('/((?:[0-9]{1,2}\.){1,3}[0-9]{1,2})/', $server_info, $matches)) {
                return $matches[1];
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}