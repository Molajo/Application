<?php
/**
 * Exception Handler Trait for Front Controller
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\FrontController;

use Exception;

/**
 * Exception Handler Trait for Front Controller
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
trait ExceptionHandlerTrait
{
    /**
     * Exception Handler
     *
     * @var    object
     * @since  1.0
     */
    protected $exception_handler;

    /**
     * Method is called by PHP for exceptions
     *
     * @param   Exception $e
     *
     * @return  $this
     * @since   1.0.0
     */
    public function setException(Exception $e)
    {
        $options              = array();
        $options['exception'] = $e;

        $this->exception_handler->handleException($options);

        return $this;
    }

    /**
     * Establish the Exception Handler for Application
     *
     * @param   null|object $exception_handler
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setExceptionHandler($exception_handler = null)
    {
        if ($exception_handler === null) {
            $exception_handler = $this->scheduleFactoryMethod('Exceptionhandling', 'Service');
        }

        $this->exception_handler = $exception_handler;

        set_exception_handler(array($this, 'setException'));

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
