<?php
/**
 * Date Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Test;

use Molajo\Controller\DateController;

/**
 * Utilities Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class DateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Options
     *
     * @var    array
     * @since  1.0
     */
    protected $options;

    /**
     * @covers  Molajo\Controller\DateController::__construct
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setUp()
    {
        return $this;
    }

    /**
     * @covers  Molajo\Controller\DateController::__construct
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testGetDate()
    {
        $date = new DateController();
        $test = $date->getDate();

        $this->assertEquals(true, is_string($test));

        return $this;
    }
}
