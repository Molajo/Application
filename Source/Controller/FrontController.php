<?php
/**
 * Front Controller
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller;

use CommonApi\Controller\ErrorHandlingInterface;
use CommonApi\Controller\FrontControllerInterface;
use CommonApi\IoC\ScheduleInterface;

/**
 * Front Controller
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class FrontController implements FrontControllerInterface, ErrorHandlingInterface
{
    /**
     * First Step
     *
     * @var    boolean
     * @since  1.0
     */
    protected $first_step = true;

    /**
     * Front Controller Steps
     *
     * @var    array
     * @since  1.0
     */
    protected $steps = array();

    /**
     * Normal Ending
     *
     * @var    boolean
     * @since  1.0
     */
    protected $normal_ending = false;

    /**
     * Cache Handler Trait
     *
     * @var     object  Molajo\Controller\FrontController\CacheHandlerTrait
     * @since   1.0.0
     */
    use \Molajo\Controller\FrontController\CacheHandlerTrait;

    /**
     * Debug Handler Trait
     *
     * @var     object  Molajo\Controller\FrontController\DebugHandlerTrait
     * @since   1.0.0
     */
    use \Molajo\Controller\FrontController\DebugHandlerTrait;

    /**
     * Error Handler Trait
     *
     * @var     object  Molajo\Controller\FrontController\ErrorHandlerTrait
     * @since   1.0.0
     */
    use \Molajo\Controller\FrontController\ErrorHandlerTrait;

    /**
     * Event Handler Trait
     *
     * @var     object  Molajo\Controller\FrontController\EventHandlerTrait
     * @since   1.0.0
     */
    use \Molajo\Controller\FrontController\EventHandlerTrait;

    /**
     * Exception Handler Trait
     *
     * @var     object  Molajo\Controller\FrontController\ExceptionHandlerTrait
     * @since   1.0.0
     */
    use \Molajo\Controller\FrontController\ExceptionHandlerTrait;

    /**
     * Factory Handler Trait
     *
     * @var     object  Molajo\Controller\FrontController\FactoryHandlerTrait
     * @since   1.0.0
     */
    use \Molajo\Controller\FrontController\FactoryHandlerTrait;

    /**
     * Constructor
     *
     * @param  ScheduleInterface      $schedule
     * @param  array                  $requests
     * @param  array                  $steps
     * @param  array                  $dependencies
     * @param  ErrorHandlingInterface $error_handler
     * @param  null                   $exception_handler
     * @param  ErrorHandlingInterface $debug_handler
     * @param  array                  $debug_types
     * @param  boolean                $debug
     *
     * @since  1.0
     */
    public function __construct(
        ScheduleInterface $schedule,
        $requests,
        array $steps = array(),
        array $dependencies = array(),
        ErrorHandlingInterface $error_handler = null,
        $exception_handler = null,
        ErrorHandlingInterface $debug_handler = null,
        array $debug_types = array(),
        $debug = false
    ) {
        $this->schedule     = $schedule;
        $this->requests     = $requests;
        $this->steps        = $steps;
        $this->dependencies = $dependencies;

        $this->setErrorHandler($error_handler);
        $this->setExceptionHandler($exception_handler);
        $this->setDebugHandler($debug_handler, $debug_types, $debug);
        $this->createEventCallback();
        $this->createCacheCallbacksOn();
    }

    /**
     * Execute Application: Request to Response Processing
     *
     * @return  $this
     * @since   1.0.0
     */
    public function process()
    {
        register_shutdown_function(array($this, 'shutdown'));

        foreach ($this->steps as $step) {
            $this->scheduleEvent($event_name = 'onBefore' . ucfirst(strtolower($step)));
            $this->runStep($step);
            $this->scheduleEvent($event_name = 'onAfter' . ucfirst(strtolower($step)));
        }

        $this->normal_ending = true;
        restore_error_handler();
        $this->shutdown();
    }

    /**
     * Shutdown the application
     *
     * @return  void
     * @since   1.0.0
     */
    public function shutdown()
    {
        if (headers_sent()) {
        } else {
            header('HTTP/1.1 500 Internal Server Error');
        }

        if ($this->normal_ending === true) {
        } else {
            echo 'Failed Run.';
        }

        exit(0);
    }

    /**
     * Executed by the process loop for each process identified in $this->steps
     *
     * @param   string $factory_method
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function runStep($factory_method)
    {
        if ($this->first_step === true) {
            $this->first_step = false;
            return $this->initialise();
        }

        $results = $this->scheduleFactoryMethod($factory_method, 'Step');

        if (isset($results->error_code) && (int)$results->error_code > 0) {
            trigger_error(E_ERROR, 'Frontcontroller::runStep Error for: ' . $factory_method);
        }

        return $this;
    }

    /**
     * Initialise
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function initialise()
    {
        if (count($this->requests) > 0) {
            foreach ($this->requests as $request) {
                $this->scheduleFactoryMethod($request, 'Initialise');
            }
        }

        return $this;
    }
}
