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
 * @package    Zend_Reflection
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Extension.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see Zend_Reflection_Class
 */
require_once 'Zend/Reflection/Class.php';

/**
 * @see Zend_Reflection_Function
 */
require_once 'Zend/Reflection/Function.php';

/**
 * @category   Zend
 * @package    Zend_Reflection
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Reflection_Extension extends ReflectionExtension
{
    /**
     * Get extension function reflection objects
     *
     * @param  string $reflectionClass Name of reflection class to use
     * @return array Array of Zend_Reflection_Function objects
     */
    public function getFunctions($reflectionClass = 'Zend_Reflection_Function')
    {
        $phpReflections  = parent::getFunctions();
        $zendReflections = array();
        while ($phpReflections && ($phpReflection = array_shift($phpReflections))) {
            $instance = new $reflectionClass($phpReflection->getName());
            if (!$instance instanceof Zend_Reflection_Function) {
                require_once 'Zend/Reflection/Exception.php';
                throw new Zend_Reflection_Exception('Invalid reflection class provided; must extend Zend_Reflection_Function');
            }
            $zendReflections[] = $instance;
            unset($phpReflection);
        }
        unset($phpReflections);
        return $zendReflections;
    }

    /**
     * Get extension class reflection objects
     *
     * @param  string $reflectionClass Name of reflection class to use
     * @return array Array of Zend_Reflection_Class objects
     */
    public function getClasses($reflectionClass = 'Zend_Reflection_Class')
    {
        $phpReflections  = parent::getClasses();
        $zendReflections = array();
        while ($phpReflections && ($phpReflection = array_shift($phpReflections))) {
            $instance = new $reflectionClass($phpReflection->getName());
            if (!$instance instanceof Zend_Reflection_Class) {
                require_once 'Zend/Reflection/Exception.php';
                throw new Zend_Reflection_Exception('Invalid reflection class provided; must extend Zend_Reflection_Class');
            }
            $zendReflections[] = $instance;
            unset($phpReflection);
        }
        unset($phpReflections);
        return $zendReflections;
    }
}
