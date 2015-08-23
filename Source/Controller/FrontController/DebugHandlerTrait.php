<?php
/**
 * Debug Handler Trait for Front Controller
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\FrontController;

use CommonApi\Application\ErrorHandlingInterface;

/**
 * Debug Handler Trait for Front Controller
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
trait DebugHandlerTrait
{
    /**
     * Debug Handler
     *
     * @var    object  CommonApi\Application\ErrorHandlingInterface
     * @since  1.0
     */
    protected $debug_handler;

    /**
     * Debug Types
     *
     * @var    array
     * @since  1.0
     */
    protected $debug_types = array();

    /**
     * Function to capture debug trace log
     *
     * @var    callable
     * @since  1.0
     */
    protected $debug_callback;

    /**
     * Method is called by PHP for errors if it has been assigned the PHP set_error_handler in the application
     *
     * @param   string $message
     * @param   array  $context
     *
     * @return  $this
     * @since   1.0.0
     */
    public function setDebug($message, array $context = array())
    {
        $this->debug_handler->log(100, $message, $context);

        return $this;
    }

    /**
     * Establish the Debug Handler for Application
     *
     * @param   null|ErrorHandlingInterface $debug_handler
     * @param   array                       $debug_types
     * @param   boolean                     $debug
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setDebugHandler(
        ErrorHandlingInterface $debug_handler = null,
        array $debug_types = array(),
        $debug = false
    ) {
        if ($debug === true) {
        } else {
            $this->debug_types = array();

            return $this;
        }

        if ($debug_handler === null) {
            $debug_handler = $this->scheduleFactoryMethod('Debug', 'Service');
        }

        $this->debug_types   = $debug_types;
        $this->debug_handler = $debug_handler;

        $this->setDebugCallback();

        return $this;
    }

    /**
     * Create Debug Callback for use with Application Logging
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setDebugCallback()
    {
        $this->debug_callback = function ($message, $debug_type, $file, $line, array $context = array()) {

            if (in_array($debug_type, $this->debug_types)) {
                $this->setDebugMethodCall($message, $debug_type, $file, $line, $context);
            }

            return $this;
        };

        $this->setContainerEntry('Debugcallback', $this->debug_callback);

        return $this;
    }

    /**
     * Set Debug Method Call
     *
     * @param  string  $message
     * @param  string  $debug_type
     * @param  string  $file
     * @param  integer $line
     * @param  array   $context
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setDebugMethodCall($message, $debug_type, $file, $line, array $context = array())
    {
        if (in_array($debug_type, $this->debug_types)) {
            $context['debug_type'] = $debug_type;
            $context['file']       = $file;
            $context['line']       = $line;
            $this->setDebug($message, $context);
        }

        return $this;
    }

    /**
     * Store Product in the Inversion of Control Container
     *
     * @param   string $product_name
     * @param   mixed  $value
     *
     * @return  $this
     * @since   1.0.0
     */
    abstract protected function setContainerEntry($product_name, $value);

    /**
     * Schedule Factory recursively resolving dependencies
     *
     * @param   string $product_name
     * @param   string $debug_type
     * @param   array  $options
     *
     * @return  object
     * @since   1.0.0
     */
    abstract protected function scheduleFactoryMethod($product_name, $debug_type, array $options = array());
}
