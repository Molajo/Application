<?php
/**
 * FrontController Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Test;

include_once __DIR__ . '/' . 'Mocks/Dispatcher.php';
include_once __DIR__ . '/' . 'Mocks/Event.php';
include_once __DIR__ . '/' . 'Mocks/Scheduler.php';

use Molajo\Controller\FrontController;

/**
 * FrontController Controller Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class FrontControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * IoCC
     *
     * @var    object  CommonApi\IoC\ScheduleInterface
     * @since  1.0
     */
    protected $schedule;

    /**
     * Dispatcher
     *
     * @var    object  CommonApi\Event\DispatcherInterface
     * @since  1.0
     */
    protected $dispatcher;

    /**
     * Requests
     *
     * @var    array
     * @since  1.0
     */
    protected $requests;

    /**
     * Base Folder
     *
     * @var    string
     * @since  1.0
     */
    protected $base_path;

    /**
     * Front Controller Steps
     *
     * @var    array
     * @since  1.0
     */
    protected $steps
        = array(
            'initialise',
            'authenticate',
            'route',
            'authorise',
            'dispatcher',
            'execute',
            'response'
        );

    /**
     * Dependencies for Events
     *
     * @var    array
     * @since  1.0
     */
    protected $dependencies_array
        = array(
            'runtime_data'   => 'Runtimedata',
            'plugin_data'    => 'Plugindata',
            'parameters'     => 'parameters',
            'row'            => 'row',
            'query'          => 'query',
            'model_registry' => 'model_registry',
            'query_results'  => 'query_results',
            'rendered_view'  => 'rendered_view',
            'rendered_page'  => 'rendered_page',
            'user'           => 'User',
            'exclude_tokens' => 'exclude_tokens',
            'token_objects'  => 'token_objects'
        );

    /**
     * Debug Flag
     *
     * @var    boolean
     * @since  1.0
     */
    protected $debug = false;

    /**
     * @covers  Molajo\Controller\FrontController::__construct
     * @covers  Molajo\Controller\FrontController::process
     * @covers  Molajo\Controller\FrontController::runStep
     * @covers  Molajo\Controller\FrontController::initialise
     * @covers  Molajo\Controller\FrontController::scheduleEvent
     * @covers  Molajo\Controller\FrontController::scheduleFactoryMethod
     * @covers  Molajo\Controller\FrontController::setContainerEntry
     * @covers  Molajo\Controller\FrontController::handleErrors
     * @covers  Molajo\Controller\FrontController::shutdown
     * @covers  Molajo\Controller\FrontController::createScheduleEventCallback
     *
     * @since   1.0.0
     */
    protected function setUp()
    {
        $this->dispatcher = new MockDispatcher();
        $this->schedule   = new MockScheduler($this->dispatcher);
        $this->base_path  = __DIR__;

        $this->fc = new FrontController(
            $this->schedule,
            $this->requests,
            $this->base_path,
            $this->steps,
            $this->dependencies_array,
            $this->debug
        );
    }

    /**
     * @covers  Molajo\Controller\FrontController::__construct
     * @covers  Molajo\Controller\FrontController::process
     * @covers  Molajo\Controller\FrontController::runStep
     * @covers  Molajo\Controller\FrontController::initialise
     * @covers  Molajo\Controller\FrontController::scheduleEvent
     * @covers  Molajo\Controller\FrontController::scheduleFactoryMethod
     * @covers  Molajo\Controller\FrontController::setContainerEntry
     * @covers  Molajo\Controller\FrontController::handleErrors
     * @covers  Molajo\Controller\FrontController::shutdown
     * @covers  Molajo\Controller\FrontController::createScheduleEventCallback
     *
     * @since   1.0.0
     */
    public function testVerifyIoCCProducts()
    {
        $results = $this->fc->process();

        $expected = array(
            'Eventcallback',
            'Event',
            'Dispatcher',
            'Event',
            'Dispatcher',
            'authenticate',
            'Event',
            'Dispatcher',
            'Event',
            'Dispatcher',
            'route',
            'Event',
            'Dispatcher',
            'Event',
            'Dispatcher',
            'authorise',
            'Event',
            'Dispatcher',
            'Event',
            'Dispatcher',
            'dispatcher',
            'Event',
            'Dispatcher',
            'Event',
            'Dispatcher',
            'execute',
            'Event',
            'Dispatcher',
            'Event',
            'Dispatcher',
            'response',
            'Event',
            'Dispatcher'
        );

        $this->assertEquals($expected, $this->schedule->scheduled_products);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\FrontController::__construct
     * @covers  Molajo\Controller\FrontController::process
     * @covers  Molajo\Controller\FrontController::runStep
     * @covers  Molajo\Controller\FrontController::initialise
     * @covers  Molajo\Controller\FrontController::scheduleEvent
     * @covers  Molajo\Controller\FrontController::scheduleFactoryMethod
     * @covers  Molajo\Controller\FrontController::setContainerEntry
     * @covers  Molajo\Controller\FrontController::handleErrors
     * @covers  Molajo\Controller\FrontController::shutdown
     * @covers  Molajo\Controller\FrontController::createScheduleEventCallback
     *
     * @since   1.0.0
     */
    public function testVerifyEvents()
    {
        $results = $this->fc->process();

        $expected = array(
            'onAfterInitialise',
            'onBeforeAuthenticate',
            'onAfterAuthenticate',
            'onBeforeRoute',
            'onAfterRoute',
            'onBeforeAuthorise',
            'onAfterAuthorise',
            'onBeforeDispatcher',
            'onAfterDispatcher',
            'onBeforeExecute',
            'onAfterExecute',
            'onBeforeResponse',
            'onAfterResponse'
        );

        $this->assertEquals($expected, $this->dispatcher->event_list);

        return $this;
    }
}
