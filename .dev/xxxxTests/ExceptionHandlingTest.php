<?php
/**
 * Error Handling Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Test;

use Molajo\Controller\ErrorHandling;

/**
 * Error Handling Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class ErrorHandlingTest extends \PHPUnit_Framework_TestCase
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
     * 1. 403
     * 2. 404
     * 3. 500
     * 4. 503
     * 5. ErrorThrownAsException
     *
     * todo: change class to render output
     *
     * @return  $this
     * @since   1.0
     */
    public function testSetError()
    {
        $test = true;

        $this->assertEquals(true, is_string($test));

        return $this;
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
