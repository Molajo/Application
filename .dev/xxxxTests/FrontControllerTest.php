<?php
/**
 * FrontController Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Test;

use Molajo\Controller\FrontController;

/**
 * FrontController Controller Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class FrontControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Options
     *
     * @var    array
     * @since  1.0
     */
    protected $options;

    /**
     * Setup testing
     *
     * @return  $this
     * @since   1.0
     */
    protected function setUp()
    {
        return $this;
    }

    /**
     * Test
     * 1. Test set_error_handler
     * 2. Test register_shutdown_function
     * 3. Test scheduleEvent onBeforeStepname
     * 4. Test RuntimeException for step failure
     * 5. Test scheduleEvent onAfterStepname
     *
     * @return  $this
     * @since   1.0
     */
    public function testProcess()
    {
        $test = true;

        $this->assertEquals(true, is_string($test));

        return $this;
    }

    /**
     * Schedule Event Processing
     *
     * 1. RuntimeException - Fails to get event instance
     * 2. RuntimeException - Fails to schedule Event
     * 3. Sets Container Entry for keys
     * 4. Returns reults
     *
     * @return  $this
     * @since   1.0
     */
    public function testScheduleEvent()
    {

        return $this;
    }

    /**
     * Schedule Factory recursively resolving dependencies
     *
     * @param   string $product_name
     * @param   array  $options
     *
     * @return  mixed
     * @since   1.0
     */
    public function testScheduleService($product_name, array $options = array())
    {
        try {
            return $this->iocc->scheduleFactoryMethod($product_name, $options);

        } catch (Exception $e) {
            throw new RuntimeException ('Frontcontroller scheduleFactoryMethod Failed ' . $e->getMessage());
        }
    }

    /**
     * Store Instance in the Inversion of Control Container
     *
     * @param   string $product_name
     * @param   object $value
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function testSetContainerEntry()
    {
        try {
            $this->iocc->set($product_name, $value);

        } catch (Exception $e) {
            throw new RuntimeException ('Frontcontroller setContainerEntry Failed ' . $e->getMessage());
        }

        return $this;
    }

    /**
     * Error Handling
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function testHandleErrors()
    {
        //$this->scheduleFactoryMethod('ErrorHandling');
        /**
         *
         * $this->redirect->set('url', $runtime_data->redirect_to_id);
         * $this->redirect->set('status_code', 301);
         * $this->redirect->redirect();
         *
         * ob_start();
         * if ( is_callable($this->error) ) {
         * call_user_func_array($this->error, array($argument));
         * } else {
         * call_user_func_array(array($this, 'defaultError'), array($argument));
         * }
         *
         * return ob_get_clean();
         */
    }

    /**
     * Shutdown the application
     *
     * @return  void
     * @since   1.0
     */
    public function testShutdown()
    {

    }

    /**
     * Tear down
     *
     * @return  $this
     * @since   1.0
     */
    protected function tearDown()
    {

    }
}
