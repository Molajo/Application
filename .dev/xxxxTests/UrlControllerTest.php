<?php
/**
 * UrlController Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Test;

use Molajo\Controller\UrlController;

/**
 * UrlController Controller Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class UrlControllerTest extends \PHPUnit_Framework_TestCase
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
     * 1. Remove ending '/'
     * 2. Find UrlController Base Path
     * 3. Doesn't find UrlController -- sets default
     * 4. verify name, id, base_path and path
     *
     * @return  $this
     * @since   1.0
     */
    public function testSetUrlController()
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
