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
 * @package    Zend_Tool
 * @subpackage Framework
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: ApplicationDirectory.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see Zend_Tool_Project_Context_Filesystem_Directory
 */
require_once 'Zend/Tool/Project/Context/Filesystem/Directory.php';

/**
 * This class is the front most class for utilizing Zend_Tool_Project
 *
 * A profile is a hierarchical set of resources that keep track of
 * items within a specific project.
 *
 * @category   Zend
 * @package    Zend_Tool
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Tool_Project_Context_Zf_ApplicationDirectory extends Zend_Tool_Project_Context_Filesystem_Directory
{

    protected $_filesystemName = 'application';

    protected $_classNamePrefix = 'Application_';

    public function init()
    {
        if ($this->_resource->hasAttribute('classNamePrefix')) {
            $this->_classNamePrefix = $this->_resource->getAttribute('classNamePrefix');
        }
        parent::init();
    }

    /**
     * getPersistentAttributes
     *
     * @return array
     */
    public function getPersistentAttributes()
    {
        return array(
            'classNamePrefix' => $this->getClassNamePrefix()
            );
    }

    public function getName()
    {
        return 'ApplicationDirectory';
    }

    public function setClassNamePrefix($classNamePrefix)
    {
        $this->_classNamePrefix = $classNamePrefix;
    }

    public function getClassNamePrefix()
    {
        return $this->_classNamePrefix;
    }

}
