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
 * @package    Zend_Oauth
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Rsa.php 23775 2011-03-01 17:25:24Z ralph $
 */

/** Zend_Oauth_Signature_SignatureAbstract */
require_once 'Zend/Oauth/Signature/SignatureAbstract.php';

/** Zend_Crypt_Rsa */
require_once 'Zend/Crypt/Rsa.php';

/**
 * @category   Zend
 * @package    Zend_Oauth
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Oauth_Signature_Rsa extends Zend_Oauth_Signature_SignatureAbstract
{
    /**
     * Sign a request
     *
     * @param  array $params
     * @param  null|string $method
     * @param  null|string $url
     * @return string
     */
    public function sign(array $params, $method = null, $url = null)
    {
        $rsa = new Zend_Crypt_Rsa;
        $rsa->setHashAlgorithm($this->_hashAlgorithm);
        $sign = $rsa->sign(
            $this->_getBaseSignatureString($params, $method, $url),
            $this->_key,
            Zend_Crypt_Rsa::BASE64
        );
        return $sign;
    }

    /**
     * Assemble encryption key
     *
     * @return string
     */
    protected function _assembleKey()
    {
        return $this->_consumerSecret;
    }
}
