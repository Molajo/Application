<?php
/**
 * Application Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Test;

use Molajo\Controller\Application;

/**
 * Application Controller Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class ApplicationTest extends \PHPUnit_Framework_TestCase
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
     * 2. Find Application Base Path
     * 3. Doesn't find Application -- sets default
     * 4. verify name, id, base_path and path
     *
     * @return  $this
     * @since   1.0
     */
    public function testSetApplication()
    {
        $test = true;

        $this->assertEquals(true, is_string($test));

        return $this;
    }

    /**
     * Retrieve Configuration Data
     * 1. Find installation needed
     * 2. retrieve data
     * 3. RuntimeException - query error
     * 4. RuntimeException - No Model Registry
     * 5. Verify appropriate data returns
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function testGetConfiguration()
    {

    }

    /**
     * Check if the Site has permission to utilise this Application
     *
     * 1. Valid (returns $this)
     * 2. Invalid - throws RuntimeException
     *
     * @return  $this
     * @since   1.0
     */
    public function testVerifySiteApplication($site_id)
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
