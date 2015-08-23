<?php
/**
 * Text Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Test;

use CommonApi\Application\RandomStringInterface;
use Molajo\Controller\Randomstring;

/**
 * Utilities Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class RandomstringTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Text Instance
     *
     * @var    object
     * @since  1.0
     */
    protected $random_instance;

    /**
     * @covers  Molajo\Controller\Randomstring::__construct
     * @covers  Molajo\Controller\Randomstring::generateString
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testGenerateString()
    {
        $this->random_instance = new Randomstring();
        $results               = $this->random_instance->generateString();

        $this->assertEquals(true, strlen($results) > 4);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\Randomstring::__construct
     * @covers  Molajo\Controller\Randomstring::generateString
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testGenerateStringConstructor()
    {
        $this->random_instance = new Randomstring(5, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $results               = $this->random_instance->generateString();

        $this->assertEquals(5, strlen($results));

        return $this;
    }

    /**
     * @covers  Molajo\Controller\Randomstring::__construct
     * @covers  Molajo\Controller\Randomstring::generateString
     *
     * @return  $this
     * @since   1.0.0
     */
    public function testGenerateStringPassin()
    {
        $this->random_instance = new Randomstring();
        $results               = $this->random_instance->generateString(5, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');

        $this->assertEquals(5, strlen($results));

        return $this;
    }
}
