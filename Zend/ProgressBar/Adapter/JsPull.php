<?php
/**
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
 * @package    Zend_ProgressBar
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license    https://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: JsPull.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see Zend_Json
 */
require_once 'Zend/Json.php';

/**
 * @see Zend_ProgressBar_Adapter
 */
require_once 'Zend/ProgressBar/Adapter.php';

/**
 * Zend_ProgressBar_Adapter_JsPull offers a simple method for updating a
 * progressbar in a browser.
 *
 * @category  Zend
 * @package   Zend_ProgressBar
 * @uses      Zend_ProgressBar_Adapter_Interface
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_ProgressBar_Adapter_JsPull extends Zend_ProgressBar_Adapter
{
    /**
     * Wether to exit after json data send or not
     *
     * @var boolean
     */
    protected $_exitAfterSend = true;

    /**
     * Set wether to exit after json data send or not
     *
     * @param  boolean $exitAfterSend
     * @return Zend_ProgressBar_Adapter_JsPull
     */
    public function setExitAfterSend($exitAfterSend)
    {
        $this->_exitAfterSend = $exitAfterSend;
    }

    /**
     * Defined by Zend_ProgressBar_Adapter_Interface
     *
     * @param  float   $current       Current progress value
     * @param  float   $max           Max progress value
     * @param  float   $percent       Current percent value
     * @param  integer $timeTaken     Taken time in seconds
     * @param  integer $timeRemaining Remaining time in seconds
     * @param  string  $text          Status text
     * @return void
     */
    public function notify($current, $max, $percent, $timeTaken, $timeRemaining, $text)
    {
        $arguments = array(
            'current'       => $current,
            'max'           => $max,
            'percent'       => ($percent * 100),
            'timeTaken'     => $timeTaken,
            'timeRemaining' => $timeRemaining,
            'text'          => $text,
            'finished'      => false
        );

        $data = Zend_Json::encode($arguments);

        // Output the data
        $this->_outputData($data);
    }

    /**
     * Defined by Zend_ProgressBar_Adapter_Interface
     *
     * @return void
     */
    public function finish()
    {
        $data = Zend_Json::encode(array('finished' => true));

        $this->_outputData($data);
    }

    /**
     * Outputs given data the user agent.
     *
     * This split-off is required for unit-testing.
     *
     * @param  string $data
     * @return void
     */
    protected function _outputData($data)
    {
        echo $data;

        if ($this->_exitAfterSend) {
            exit;
        }
    }
}
