<?php
/**
 * Translate Number to Text Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\NumberToText\Test;

use Molajo\Controller\NumberToText\Translate;

/**
 * Number to Text Testing
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class NumberTranslateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Locale Instance
     *
     * @var    object
     * @since  1.0
     */
    protected $locale_instance;

    /**
     * @covers  Molajo\Controller\NumberToText\Translate::__construct
     * @covers  Molajo\Controller\NumberToText\enGB::loadTranslation
     *
     * @return  $this
     * @since   1.0
     */
    protected function setUp()
    {
        $this->locale_instance = new Translate('en-GB');
    }

    /**
     * @covers  Molajo\Controller\NumberToText\Translate::__construct
     * @covers  Molajo\Controller\NumberToText\enGB::loadTranslation
     * @covers  Molajo\Controller\NumberToText\Translate::translateString
     *
     * @return  $this
     * @since   1.0
     */
    public function testTranslateString()
    {
        $results = $this->locale_instance->translateString('number_one');
        $this->assertEquals('one', $results);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\NumberToText\Translate::__construct
     * @covers  Molajo\Controller\NumberToText\enGB::loadTranslation
     * @covers  Molajo\Controller\NumberToText\Translate::translateString
     *
     * @return  $this
     * @since   1.0
     */
    public function testTranslateStringNotFound()
    {
        $results = $this->locale_instance->translateString('not_found');
        $this->assertEquals('not_found', $results);

        return $this;
    }
}
