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
 * @package    Zend_Http
 * @subpackage UserAgent
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */

require_once 'Zend/Http/UserAgent/AbstractDevice.php';

/**
 * Text browser type matcher
 *
 * @category   Zend
 * @package    Zend_Http
 * @subpackage UserAgent
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Http_UserAgent_Text extends Zend_Http_UserAgent_AbstractDevice
{
    /**
     * User Agent Signatures
     *
     * @var array
     */
    protected static $_uaSignatures = array(
        'lynx',
        'retawq',
        'w3m',
    );

    /**
     * Comparison of the UserAgent chain and User Agent signatures
     *
     * @param string $userAgent User Agent chain
     * @param  array $server $_SERVER like param
     * @return bool
     */
    public static function match($userAgent, $server)
    {
        return self::_matchAgentAgainstSignatures($userAgent, self::$_uaSignatures);
    }

    /**
     * Gives the current browser type
     *
     * @return string
     */
    public function getType()
    {
        return 'text';
    }

    /**
     * Look for features
     *
     * @return string
     */
    protected function _defineFeatures()
    {
        $this->setFeature('images', false, 'product_capability');
        $this->setFeature('iframes', false, 'product_capability');
        $this->setFeature('frames', false, 'product_capability');
        $this->setFeature('javascript', false, 'product_capability');
        return parent::_defineFeatures();
    }

    /**
     * Determine supported image formats
     *
     * @return null
     */
    public function getImageFormatSupport()
    {
        return null;
    }

    /**
     * Get preferred markup format
     *
     * @return string
     */
    public function getPreferredMarkup()
    {
        return 'xhtml';
    }

    /**
     * Get supported X/HTML markup level
     *
     * @return int
     */
    public function getXhtmlSupportLevel()
    {
        return 1;
    }

    /**
     * Does the device support Flash?
     *
     * @return bool
     */
    public function hasFlashSupport()
    {

        return false;
    }

    /**
     * Does the device support PDF?
     *
     * @return bool
     */
    public function hasPdfSupport()
    {
        return false;
    }
}
