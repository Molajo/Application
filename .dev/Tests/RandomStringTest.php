<?php
/**
 * Text Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Test;

use CommonApi\Controller\RandomStringInterface;
use Molajo\Controller\RandomString;

/**
 * Utilities Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class RandomStringTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Text Instance
     *
     * @var    object
     * @since  1.0
     */
    protected $random_instance;

    /**
     * @covers Molajo\Controller\RandomString::__construct
     * @covers Molajo\Controller\RandomString::generateString
     *
     * @return  $this
     * @since   1.0
     */
    protected function setUp()
    {
        $this->random_instance = new RandomString();
    }

    /**
     * @covers Molajo\Controller\RandomString::__construct
     * @covers Molajo\Controller\RandomString::generateString
     *
     * @return  $this
     * @since   1.0
     */
    public function testGenerateString()
    {
        $results = $this->random_instance->generateString();

        $this->assertEquals(true, strlen($results) > 4);

        return $this;
    }

}
