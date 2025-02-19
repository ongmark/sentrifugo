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
 * @category    ZendX
 * @package     ZendX_JQuery
 * @subpackage  View
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (https://www.zend.com)
 * @license     https://framework.zend.com/license/new-bsd     New BSD License
 * @version     $Id: JQuery.php 21867 2010-04-16 07:45:34Z beberlei $
 */

/**
 * @see Zend_Json
 */
require_once "Zend/Json.php";

/**
 * jQuery Global Class holding constants and static convienience methods.
 *
 * @todo       Offer convenience methods to add a tab or accordion container/pane combination.
 * @package    ZendX_JQuery
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
  */
class ZendX_JQuery
{
    /**
     * Current default supported jQuery library version with ZendX_JQuery
     * 
     * @const string
     */
    const DEFAULT_JQUERY_VERSION = "1.3.2";

    /**
     * Currently supported jQuery UI library version with ZendX_JQuery
     *
     * @const string
     */
    const DEFAULT_UI_VERSION = "1.7.1";

    /**
     * @see https://code.google.com/apis/ajaxlibs/documentation/index.html#jquery
     * @const string Base path to CDN
     */
    const CDN_BASE_GOOGLE = 'https://ajax.googleapis.com/ajax/libs/';

    /**
     * @see https://code.google.com/apis/ajaxlibs/documentation/index.html#jquery
     * @const string Base path to CDN
     */
    const CDN_BASE_GOOGLE_SSL = 'https://ajax.googleapis.com/ajax/libs/';

    /**
     * @const string
     */
    const CDN_SUBFOLDER_JQUERY = 'jquery/';

    /**
     * @const string
     */
    const CDN_SUBFOLDER_JQUERYUI = 'jqueryui/';

    /**
     * Always uses compressed version, because this is assumed to be the use case
     * in production enviroment. An uncompressed version has to included manually.
     *
     * @see https://code.google.com/apis/ajaxlibs/documentation/index.html#jquery
     * @const string File path after base and version
     */
    const CDN_JQUERY_PATH_GOOGLE = '/jquery.min.js';

    /**
     * Which parts of the the jQuery library should be rendered on echo'ing
     * the jQuery library to the View. The constants act as bit-mask. This
     * way the jQuery autogenerated code can be refactored based on personal needs.
     *
     * @see ZendX_JQuery_Helper_JQuery::setRenderMode
     * @const Integer
     */
    const RENDER_LIBRARY         = 1;
    const RENDER_SOURCES         = 2;
    const RENDER_STYLESHEETS     = 4;
    const RENDER_JAVASCRIPT      = 8;
    const RENDER_JQUERY_ON_LOAD  = 16;
    const RENDER_ALL             = 255;

    /**
     * jQuery-enable a view instance
     *
     * @param  Zend_View_Interface $view
     * @return void
     */
    public static function enableView(Zend_View_Interface $view)
    {
        if (false === $view->getPluginLoader('helper')->getPaths('ZendX_JQuery_View_Helper')) {
            $view->addHelperPath('ZendX/JQuery/View/Helper', 'ZendX_JQuery_View_Helper');
        }
    }

    /**
     * jQuery-enable a form instance
     *
     * @param  Zend_Form $form
     * @return void
     */
    public static function enableForm(Zend_Form $form)
    {
        $form->addPrefixPath('ZendX_JQuery_Form_Decorator', 'ZendX/JQuery/Form/Decorator', 'decorator')
             ->addPrefixPath('ZendX_JQuery_Form_Element', 'ZendX/JQuery/Form/Element', 'element')
             ->addElementPrefixPath('ZendX_JQuery_Form_Decorator', 'ZendX/JQuery/Form/Decorator', 'decorator')
             ->addDisplayGroupPrefixPath('ZendX_JQuery_Form_Decorator', 'ZendX/JQuery/Form/Decorator');

        foreach ($form->getSubForms() as $subForm) {
            self::enableForm($subForm);
        }

        if (null !== ($view = $form->getView())) {
            self::enableView($view);
        }
    }

    /**
     * Encode Json that may include javascript expressions.
     *
     * Take care of using the Zend_Json_Encoder to alleviate problems with the json_encode
     * magic key mechanism as of now.
     *
     * @see Zend_Json::encode
     * @param  mixed $value
     * @return mixed
     */
    public static function encodeJson($value)
    {
        if (is_array($value) && count($value) == 0) {
            return '{}';
        }

        if(!class_exists('Zend_Json')) {
            /**
             * @see Zend_Json
             */
            require_once "Zend/Json.php";
        }
        return Zend_Json::encode($value, false, array('enableJsonExprFinder' => true));
    }
}