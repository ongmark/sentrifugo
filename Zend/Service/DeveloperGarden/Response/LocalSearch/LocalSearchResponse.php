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
 * @package    Zend_Service
 * @subpackage DeveloperGarden
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: LocalSearchResponse.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see Zend_Service_DeveloperGarden_Response_BaseType
 */
require_once 'Zend/Service/DeveloperGarden/Response/BaseType.php';

/**
 * @see Zend_Service_DeveloperGarden_Response_LocalSearch_LocalSearchResponseType
 */
require_once 'Zend/Service/DeveloperGarden/Response/LocalSearch/LocalSearchResponseType.php';

/**
 * @category   Zend
 * @package    Zend_Service
 * @subpackage DeveloperGarden
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @author     Marco Kaiser
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Service_DeveloperGarden_Response_LocalSearch_LocalSearchResponse
    extends Zend_Service_DeveloperGarden_Response_BaseType
{
    /**
     *
     * @var Zend_Service_DeveloperGarden_Response_LocalSearch_LocalSearchResponseType
     */
    public $searchResult = null;

    /**
     * constructor
     *
     * @param Zend_Service_DeveloperGarden_Response_LocalSearch_LocalSearchResponseType $response
     * @todo implement special result methods
     */
    public function __construct(
        Zend_Service_DeveloperGarden_Response_LocalSearch_LocalSearchResponseType $response
    ) {
        $this->errorCode     = $response->getErrorCode();
        $this->errorMessage  = $response->getErrorMessage();
        $this->statusCode    = $response->getStatusCode();
        $this->statusMessage = $response->getStatusMessage();
        $this->searchResult  = $response;
    }

    /**
     * returns the raw search result
     *
     * @return Zend_Service_DeveloperGarden_Response_LocalSearch_LocalSearchResponseType
     */
    public function getSearchResult()
    {
        return $this->searchResult;
    }

    /**
     * overwrite hasError to not handle 0103 error (empty result)
     *
     * @return boolean
     */
    public function hasError()
    {
        $result = parent::hasError();
        if (!$result && $this->statusCode == '0103') {
            $result = false;
        }
        return $result;
    }
}
