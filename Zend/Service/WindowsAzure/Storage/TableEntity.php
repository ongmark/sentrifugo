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
 * @package    Zend_Service_WindowsAzure
 * @subpackage Storage
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: TableEntity.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see Zend_Service_WindowsAzure_Exception
 */
require_once 'Zend/Service/WindowsAzure/Exception.php';


/**
 * @category   Zend
 * @package    Zend_Service_WindowsAzure
 * @subpackage Storage
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Service_WindowsAzure_Storage_TableEntity
{
    const DEFAULT_TIMESTAMP = '1900-01-01T00:00:00';

    /**
     * Partition key
     *
     * @var string
     */
    protected $_partitionKey;

    /**
     * Row key
     *
     * @var string
     */
    protected $_rowKey;

    /**
     * Timestamp
     *
     * @var string
     */
    protected $_timestamp;

    /**
     * Etag
     *
     * @var string
     */
    protected $_etag = '';

    /**
     * Constructor
     *
     * @param string  $partitionKey    Partition key
     * @param string  $rowKey          Row key
     */
    public function __construct($partitionKey = '', $rowKey = '')
    {	
        $this->_partitionKey = $partitionKey;
        $this->_rowKey       = $rowKey;
    }

    /**
     * Get partition key
     *
     * @azure PartitionKey
     * @return string
     */
    public function getPartitionKey()
    {
        return $this->_partitionKey;
    }

    /**
     * Set partition key
     *
     * @azure PartitionKey
     * @param string $value
     */
    public function setPartitionKey($value)
    {
        $this->_partitionKey = $value;
    }

    /**
     * Get row key
     *
     * @azure RowKey
     * @return string
     */
    public function getRowKey()
    {
        return $this->_rowKey;
    }

    /**
     * Set row key
     *
     * @azure RowKey
     * @param string $value
     */
    public function setRowKey($value)
    {
        $this->_rowKey = $value;
    }

    /**
     * Get timestamp
     *
     * @azure Timestamp Edm.DateTime
     * @return string
     */
    public function getTimestamp()
    {
        if (null === $this->_timestamp) {
            $this->setTimestamp(self::DEFAULT_TIMESTAMP);
        }
        return $this->_timestamp;
    }

    /**
     * Set timestamp
     *
     * @azure Timestamp Edm.DateTime
     * @param string $value
     */
    public function setTimestamp($value = '1900-01-01T00:00:00')
    {
        $this->_timestamp = $value;
    }

    /**
     * Get etag
     *
     * @return string
     */
    public function getEtag()
    {
        return $this->_etag;
    }

    /**
     * Set etag
     *
     * @param string $value
     */
    public function setEtag($value = '')
    {
        $this->_etag = $value;
    }

    /**
     * Get Azure values
     *
     * @return array
     */
    public function getAzureValues()
    {
        // Get accessors
        $accessors = self::getAzureAccessors(get_class($this));

        // Loop accessors and retrieve values
        $returnValue = array();
        foreach ($accessors as $accessor) {
            if ($accessor->EntityType == 'ReflectionProperty') {
                $property = $accessor->EntityAccessor;
                $returnValue[] = (object)array(
                    'Name'  => $accessor->AzurePropertyName,
                    'Type'  => $accessor->AzurePropertyType,
                    'Value' => $this->$property,
                );
            } else if ($accessor->EntityType == 'ReflectionMethod' && substr(strtolower($accessor->EntityAccessor), 0, 3) == 'get') {
                $method = $accessor->EntityAccessor;
                $returnValue[] = (object)array(
                    'Name'  => $accessor->AzurePropertyName,
                    'Type'  => $accessor->AzurePropertyType,
                    'Value' => $this->$method(),
                );
            }
        }

        // Return
        return $returnValue;
    }

    /**
     * Set Azure values
     *
     * @param array $values
     * @param boolean $throwOnError Throw Zend_Service_WindowsAzure_Exception when a property is not specified in $values?
     * @throws Zend_Service_WindowsAzure_Exception
     */
    public function setAzureValues($values = array(), $throwOnError = false)
    {
        // Get accessors
        $accessors = self::getAzureAccessors(get_class($this));

        // Loop accessors and set values
        $returnValue = array();
        foreach ($accessors as $accessor) {
            if (isset($values[$accessor->AzurePropertyName])) {
                // Cast to correct type
                if ($accessor->AzurePropertyType != '') {
                    switch (strtolower($accessor->AzurePropertyType)) {
                        case 'edm.int32':
                        case 'edm.int64':
                            $values[$accessor->AzurePropertyName] = intval($values[$accessor->AzurePropertyName]); break;
                        case 'edm.boolean':
                            if ($values[$accessor->AzurePropertyName] == 'true' || $values[$accessor->AzurePropertyName] == '1')
                                $values[$accessor->AzurePropertyName] = true;
                            else
                                $values[$accessor->AzurePropertyName] = false;
                            break;
                        case 'edm.double':
                            $values[$accessor->AzurePropertyName] = floatval($values[$accessor->AzurePropertyName]); break;
                    }
                }

                // Assign value
                if ($accessor->EntityType == 'ReflectionProperty') {
                    $property = $accessor->EntityAccessor;
                    $this->$property = $values[$accessor->AzurePropertyName];
                } else if ($accessor->EntityType == 'ReflectionMethod' && substr(strtolower($accessor->EntityAccessor), 0, 3) == 'set') {
                    $method = $accessor->EntityAccessor;
                    $this->$method($values[$accessor->AzurePropertyName]);
                }
            } else if ($throwOnError) {
                throw new Zend_Service_WindowsAzure_Exception("Property '" . $accessor->AzurePropertyName . "' was not found in \$values array");
            }
        }

        // Return
        return $returnValue;
    }

    /**
     * Get Azure accessors from class
     *
     * @param string $className Class to get accessors for
     * @return array
     */
    public static function getAzureAccessors($className = '')
    {
        // List of accessors
        $azureAccessors = array();

        // Get all types
        $type = new ReflectionClass($className);

        // Loop all properties
        $properties = $type->getProperties();
        foreach ($properties as $property) {
            $accessor = self::getAzureAccessor($property);
            if ($accessor !== null) {
                $azureAccessors[] = $accessor;
            }
        }

        // Loop all methods
        $methods = $type->getMethods();
        foreach ($methods as $method) {
            $accessor = self::getAzureAccessor($method);
            if ($accessor !== null) {
                $azureAccessors[] = $accessor;
            }
        }

        // Return
        return $azureAccessors;
    }

    /**
     * Get Azure accessor from reflection member
     *
     * @param ReflectionProperty|ReflectionMethod $member
     * @return object
     */
    public static function getAzureAccessor($member)
    {
        // Get comment
        $docComment = $member->getDocComment();

        // Check for Azure comment
        if (strpos($docComment, '@azure') === false)
        {
            return null;
        }

        // Search for @azure contents
        $azureComment = '';
        $commentLines = explode("\n", $docComment);
        foreach ($commentLines as $commentLine) {
            if (strpos($commentLine, '@azure') !== false) {
                $azureComment = trim(substr($commentLine, strpos($commentLine, '@azure') + 6));
                while (strpos($azureComment, '  ') !== false) {
                    $azureComment = str_replace('  ', ' ', $azureComment);
                }
                break;
            }
        }

        // Fetch @azure properties
        $azureProperties = explode(' ', $azureComment);
        return (object)array(
            'EntityAccessor'    => $member->getName(),
            'EntityType'        => get_class($member),
            'AzurePropertyName' => $azureProperties[0],
            'AzurePropertyType' => isset($azureProperties[1]) ? $azureProperties[1] : ''
        );
    }
}
