<?php
/**
 * Error Handler Trait for Front Controller
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\FrontController;

use CommonApi\Application\ErrorHandlingInterface;

/**
 * Error Handler Trait for Front Controller
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
trait ErrorHandlerTrait
{
    /**
     * Error Handler
     *
     * @var    object  CommonApi\Application\ErrorHandlingInterface
     * @since  1.0
     */
    protected $error_handler;

    /**
     * Method called by PHP for errors
     *
     * @param   integer $error_number
     * @param   string  $message
     * @param   string  $file
     * @param   integer $line_number
     * @param   array   $context
     *
     * @return  $this
     * @since   1.0.0
     */
    public function setError($error_number, $message, $file, $line_number, array $context = array())
    {
        $this->error_handler->setError($error_number, $message, $file, $line_number, $context);

        return $this;
    }

    /**
     * Establish the Error Handler for Application
     *
     * @param   null|ErrorHandlingInterface $error_handler
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setErrorHandler(ErrorHandlingInterface $error_handler = null)
    {
        if ($error_handler === null) {
            $error_handler = $this->scheduleFactoryMethod('Errorhandling', 'Service');
        }

        $this->error_handler = $error_handler;

        set_error_handler(array($this, 'setError'));
        error_reporting(E_ALL & ~E_NOTICE);

        return $this;
    }

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
