<?php
/**
 * Translate Number to Text Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Translate\Test;

include_once __DIR__ . '/' . 'Mocks/MockNumberToText.php';

use Molajo\Controller\NumberToText;
use Molajo\Controller\NumberToText\Translate;

/**
 * Number to Text Testing
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class NumberToTextTranslateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Locale Instance
     *
     * @var    object
     * @since  1.0
     */
    protected $numbertotext;

    /**
     * @covers  Molajo\Controller\NumberToText::__construct
     * @covers  Molajo\Controller\NumberToText::convert
     * @covers  Molajo\Controller\NumberToText::extractDecimal
     * @covers  Molajo\Controller\NumberToText::extractSign
     * @covers  Molajo\Controller\NumberToText::extractDigits
     * @covers  Molajo\Controller\NumberToText::createGroups
     * @covers  Molajo\Controller\NumberToText::processGroups
     * @covers  Molajo\Controller\NumberToText::processGroupDigits
     * @covers  Molajo\Controller\NumberToText::translateGroup
     * @covers  Molajo\Controller\NumberToText::getGroupDigits
     * @covers  Molajo\Controller\NumberToText::setWordTens
     * @covers  Molajo\Controller\NumberToText::setWordHundreds
     * @covers  Molajo\Controller\NumberToText::setWord
     * @covers  Molajo\Controller\NumberToText::convertGrouping
     * @covers  Molajo\Controller\NumberToText::setDecimal
     * @covers  Molajo\Controller\NumberToText::setSign
     *
     * @return  $this
     * @since   1.0
     */
    protected function setUp()
    {
        $translate_instance = new Translate('en-GB');
        $this->numbertotext = new MockNumberToText($translate_instance);
    }

    /**
     * @covers  Molajo\Controller\NumberToText::__construct
     * @covers  Molajo\Controller\NumberToText::convert
     * @covers  Molajo\Controller\NumberToText::extractDecimal
     * @covers  Molajo\Controller\NumberToText::extractSign
     * @covers  Molajo\Controller\NumberToText::extractDigits
     * @covers  Molajo\Controller\NumberToText::createGroups
     * @covers  Molajo\Controller\NumberToText::processGroups
     * @covers  Molajo\Controller\NumberToText::processGroupDigits
     * @covers  Molajo\Controller\NumberToText::translateGroup
     * @covers  Molajo\Controller\NumberToText::getGroupDigits
     * @covers  Molajo\Controller\NumberToText::setWordTens
     * @covers  Molajo\Controller\NumberToText::setWordHundreds
     * @covers  Molajo\Controller\NumberToText::setWord
     * @covers  Molajo\Controller\NumberToText::convertGrouping
     * @covers  Molajo\Controller\NumberToText::setDecimal
     * @covers  Molajo\Controller\NumberToText::setSign
     *
     * @return  $this
     * @since   1.0
     */
    public function testExtractDecimal()
    {
        $results = $this->numbertotext->convert(2.1);

        $this->assertEquals(2, $this->numbertotext->propertyExtractDecimal[0]);
        $this->assertEquals(1, $this->numbertotext->propertyExtractDecimal[1]);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\NumberToText::__construct
     * @covers  Molajo\Controller\NumberToText::convert
     * @covers  Molajo\Controller\NumberToText::extractDecimal
     * @covers  Molajo\Controller\NumberToText::extractSign
     * @covers  Molajo\Controller\NumberToText::extractDigits
     * @covers  Molajo\Controller\NumberToText::createGroups
     * @covers  Molajo\Controller\NumberToText::processGroups
     * @covers  Molajo\Controller\NumberToText::processGroupDigits
     * @covers  Molajo\Controller\NumberToText::translateGroup
     * @covers  Molajo\Controller\NumberToText::getGroupDigits
     * @covers  Molajo\Controller\NumberToText::setWordTens
     * @covers  Molajo\Controller\NumberToText::setWordHundreds
     * @covers  Molajo\Controller\NumberToText::setWord
     * @covers  Molajo\Controller\NumberToText::convertGrouping
     * @covers  Molajo\Controller\NumberToText::setDecimal
     * @covers  Molajo\Controller\NumberToText::setSign
     *
     * @return  $this
     * @since   1.0
     */
    public function testExtractNoSign()
    {
        $results = $this->numbertotext->convert('2');

        $this->assertEquals('', $this->numbertotext->propertyExtractSign[0]);
        $this->assertEquals('2', $this->numbertotext->propertyExtractSign[1]);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\NumberToText::__construct
     * @covers  Molajo\Controller\NumberToText::convert
     * @covers  Molajo\Controller\NumberToText::extractDecimal
     * @covers  Molajo\Controller\NumberToText::extractSign
     * @covers  Molajo\Controller\NumberToText::extractDigits
     * @covers  Molajo\Controller\NumberToText::createGroups
     * @covers  Molajo\Controller\NumberToText::processGroups
     * @covers  Molajo\Controller\NumberToText::processGroupDigits
     * @covers  Molajo\Controller\NumberToText::translateGroup
     * @covers  Molajo\Controller\NumberToText::getGroupDigits
     * @covers  Molajo\Controller\NumberToText::setWordTens
     * @covers  Molajo\Controller\NumberToText::setWordHundreds
     * @covers  Molajo\Controller\NumberToText::setWord
     * @covers  Molajo\Controller\NumberToText::convertGrouping
     * @covers  Molajo\Controller\NumberToText::setDecimal
     * @covers  Molajo\Controller\NumberToText::setSign
     *
     * @return  $this
     * @since   1.0
     */
    public function testExtractNegativeSign()
    {
        $results = $this->numbertotext->convert('-2');

        $this->assertEquals('-', $this->numbertotext->propertyExtractSign[0]);
        $this->assertEquals('2', $this->numbertotext->propertyExtractSign[1]);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\NumberToText::__construct
     * @covers  Molajo\Controller\NumberToText::convert
     * @covers  Molajo\Controller\NumberToText::extractDecimal
     * @covers  Molajo\Controller\NumberToText::extractSign
     * @covers  Molajo\Controller\NumberToText::extractDigits
     * @covers  Molajo\Controller\NumberToText::createGroups
     * @covers  Molajo\Controller\NumberToText::processGroups
     * @covers  Molajo\Controller\NumberToText::processGroupDigits
     * @covers  Molajo\Controller\NumberToText::translateGroup
     * @covers  Molajo\Controller\NumberToText::getGroupDigits
     * @covers  Molajo\Controller\NumberToText::setWordTens
     * @covers  Molajo\Controller\NumberToText::setWordHundreds
     * @covers  Molajo\Controller\NumberToText::setWord
     * @covers  Molajo\Controller\NumberToText::convertGrouping
     * @covers  Molajo\Controller\NumberToText::setDecimal
     * @covers  Molajo\Controller\NumberToText::setSign
     *
     * @return  $this
     * @since   1.0
     */
    public function testExtractPlusSign()
    {
        $results = $this->numbertotext->convert('+2');

        $this->assertEquals('+', $this->numbertotext->propertyExtractSign[0]);
        $this->assertEquals('2', $this->numbertotext->propertyExtractSign[1]);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\NumberToText::__construct
     * @covers  Molajo\Controller\NumberToText::convert
     * @covers  Molajo\Controller\NumberToText::extractDecimal
     * @covers  Molajo\Controller\NumberToText::extractSign
     * @covers  Molajo\Controller\NumberToText::extractDigits
     * @covers  Molajo\Controller\NumberToText::createGroups
     * @covers  Molajo\Controller\NumberToText::processGroups
     * @covers  Molajo\Controller\NumberToText::processGroupDigits
     * @covers  Molajo\Controller\NumberToText::translateGroup
     * @covers  Molajo\Controller\NumberToText::getGroupDigits
     * @covers  Molajo\Controller\NumberToText::setWordTens
     * @covers  Molajo\Controller\NumberToText::setWordHundreds
     * @covers  Molajo\Controller\NumberToText::setWord
     * @covers  Molajo\Controller\NumberToText::convertGrouping
     * @covers  Molajo\Controller\NumberToText::setDecimal
     * @covers  Molajo\Controller\NumberToText::setSign
     *
     * @return  $this
     * @since   1.0
     */
    public function testExtractDigits()
    {
        $results = $this->numbertotext->convert('+2');

        $this->assertEquals('200', $this->numbertotext->propertyExtractDigits);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\NumberToText::__construct
     * @covers  Molajo\Controller\NumberToText::convert
     * @covers  Molajo\Controller\NumberToText::extractDecimal
     * @covers  Molajo\Controller\NumberToText::extractSign
     * @covers  Molajo\Controller\NumberToText::extractDigits
     * @covers  Molajo\Controller\NumberToText::createGroups
     * @covers  Molajo\Controller\NumberToText::processGroups
     * @covers  Molajo\Controller\NumberToText::processGroupDigits
     * @covers  Molajo\Controller\NumberToText::translateGroup
     * @covers  Molajo\Controller\NumberToText::getGroupDigits
     * @covers  Molajo\Controller\NumberToText::setWordTens
     * @covers  Molajo\Controller\NumberToText::setWordHundreds
     * @covers  Molajo\Controller\NumberToText::setWord
     * @covers  Molajo\Controller\NumberToText::convertGrouping
     * @covers  Molajo\Controller\NumberToText::setDecimal
     * @covers  Molajo\Controller\NumberToText::setSign
     *
     * @return  $this
     * @since   1.0
     */
    public function testExtractDigitsThousand()
    {
        $results = $this->numbertotext->convert('1000');

        $this->assertEquals('000100', $this->numbertotext->propertyExtractDigits);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\NumberToText::__construct
     * @covers  Molajo\Controller\NumberToText::convert
     * @covers  Molajo\Controller\NumberToText::extractDecimal
     * @covers  Molajo\Controller\NumberToText::extractSign
     * @covers  Molajo\Controller\NumberToText::extractDigits
     * @covers  Molajo\Controller\NumberToText::createGroups
     * @covers  Molajo\Controller\NumberToText::processGroups
     * @covers  Molajo\Controller\NumberToText::processGroupDigits
     * @covers  Molajo\Controller\NumberToText::translateGroup
     * @covers  Molajo\Controller\NumberToText::getGroupDigits
     * @covers  Molajo\Controller\NumberToText::setWordTens
     * @covers  Molajo\Controller\NumberToText::setWordHundreds
     * @covers  Molajo\Controller\NumberToText::setWord
     * @covers  Molajo\Controller\NumberToText::convertGrouping
     * @covers  Molajo\Controller\NumberToText::setDecimal
     * @covers  Molajo\Controller\NumberToText::setSign
     *
     * @return  $this
     * @since   1.0
     */
    public function testGroups()
    {
        $results = $this->numbertotext->convert('1000');

        $this->assertEquals(array('000', '100'), $this->numbertotext->propertyCreateGroups);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\NumberToText::__construct
     * @covers  Molajo\Controller\NumberToText::convert
     * @covers  Molajo\Controller\NumberToText::extractDecimal
     * @covers  Molajo\Controller\NumberToText::extractSign
     * @covers  Molajo\Controller\NumberToText::extractDigits
     * @covers  Molajo\Controller\NumberToText::createGroups
     * @covers  Molajo\Controller\NumberToText::processGroups
     * @covers  Molajo\Controller\NumberToText::processGroupDigits
     * @covers  Molajo\Controller\NumberToText::translateGroup
     * @covers  Molajo\Controller\NumberToText::getGroupDigits
     * @covers  Molajo\Controller\NumberToText::setWordTens
     * @covers  Molajo\Controller\NumberToText::setWordHundreds
     * @covers  Molajo\Controller\NumberToText::setWord
     * @covers  Molajo\Controller\NumberToText::convertGrouping
     * @covers  Molajo\Controller\NumberToText::setDecimal
     * @covers  Molajo\Controller\NumberToText::setSign
     *
     * @return  $this
     * @since   1.0
     */
    public function testProcessGroupsZero()
    {
        $results = $this->numbertotext->convert('0');

        $this->assertEquals('zero', $this->numbertotext->propertyConvert);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\NumberToText::__construct
     * @covers  Molajo\Controller\NumberToText::convert
     * @covers  Molajo\Controller\NumberToText::extractDecimal
     * @covers  Molajo\Controller\NumberToText::extractSign
     * @covers  Molajo\Controller\NumberToText::extractDigits
     * @covers  Molajo\Controller\NumberToText::createGroups
     * @covers  Molajo\Controller\NumberToText::processGroups
     * @covers  Molajo\Controller\NumberToText::processGroupDigits
     * @covers  Molajo\Controller\NumberToText::translateGroup
     * @covers  Molajo\Controller\NumberToText::getGroupDigits
     * @covers  Molajo\Controller\NumberToText::setWordTens
     * @covers  Molajo\Controller\NumberToText::setWordHundreds
     * @covers  Molajo\Controller\NumberToText::setWord
     * @covers  Molajo\Controller\NumberToText::convertGrouping
     * @covers  Molajo\Controller\NumberToText::setDecimal
     * @covers  Molajo\Controller\NumberToText::setSign
     *
     * @return  $this
     * @since   1.0
     */
    public function testProcessGroupsOne()
    {
        $results = $this->numbertotext->convert('1');

        $this->assertEquals('one', $this->numbertotext->propertyProcessGroups);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\NumberToText::__construct
     * @covers  Molajo\Controller\NumberToText::convert
     * @covers  Molajo\Controller\NumberToText::extractDecimal
     * @covers  Molajo\Controller\NumberToText::extractSign
     * @covers  Molajo\Controller\NumberToText::extractDigits
     * @covers  Molajo\Controller\NumberToText::createGroups
     * @covers  Molajo\Controller\NumberToText::processGroups
     * @covers  Molajo\Controller\NumberToText::processGroupDigits
     * @covers  Molajo\Controller\NumberToText::translateGroup
     * @covers  Molajo\Controller\NumberToText::getGroupDigits
     * @covers  Molajo\Controller\NumberToText::setWordTens
     * @covers  Molajo\Controller\NumberToText::setWordHundreds
     * @covers  Molajo\Controller\NumberToText::setWord
     * @covers  Molajo\Controller\NumberToText::convertGrouping
     * @covers  Molajo\Controller\NumberToText::setDecimal
     * @covers  Molajo\Controller\NumberToText::setSign
     *
     * @return  $this
     * @since   1.0
     */
    public function testProcessGroupsEight()
    {
        $results = $this->numbertotext->convert('8');

        $this->assertEquals('eight', $this->numbertotext->propertyProcessGroups);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\NumberToText::__construct
     * @covers  Molajo\Controller\NumberToText::convert
     * @covers  Molajo\Controller\NumberToText::extractDecimal
     * @covers  Molajo\Controller\NumberToText::extractSign
     * @covers  Molajo\Controller\NumberToText::extractDigits
     * @covers  Molajo\Controller\NumberToText::createGroups
     * @covers  Molajo\Controller\NumberToText::processGroups
     * @covers  Molajo\Controller\NumberToText::processGroupDigits
     * @covers  Molajo\Controller\NumberToText::translateGroup
     * @covers  Molajo\Controller\NumberToText::getGroupDigits
     * @covers  Molajo\Controller\NumberToText::setWordTens
     * @covers  Molajo\Controller\NumberToText::setWordHundreds
     * @covers  Molajo\Controller\NumberToText::setWord
     * @covers  Molajo\Controller\NumberToText::convertGrouping
     * @covers  Molajo\Controller\NumberToText::setDecimal
     * @covers  Molajo\Controller\NumberToText::setSign
     *
     * @return  $this
     * @since   1.0
     */
    public function testProcessGroups100()
    {
        $results = $this->numbertotext->convert('100');

        $this->assertEquals('one hundred', $this->numbertotext->propertyProcessGroups);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\NumberToText::__construct
     * @covers  Molajo\Controller\NumberToText::convert
     * @covers  Molajo\Controller\NumberToText::extractDecimal
     * @covers  Molajo\Controller\NumberToText::extractSign
     * @covers  Molajo\Controller\NumberToText::extractDigits
     * @covers  Molajo\Controller\NumberToText::createGroups
     * @covers  Molajo\Controller\NumberToText::processGroups
     * @covers  Molajo\Controller\NumberToText::processGroupDigits
     * @covers  Molajo\Controller\NumberToText::translateGroup
     * @covers  Molajo\Controller\NumberToText::getGroupDigits
     * @covers  Molajo\Controller\NumberToText::setWordTens
     * @covers  Molajo\Controller\NumberToText::setWordHundreds
     * @covers  Molajo\Controller\NumberToText::setWord
     * @covers  Molajo\Controller\NumberToText::convertGrouping
     * @covers  Molajo\Controller\NumberToText::setDecimal
     * @covers  Molajo\Controller\NumberToText::setSign
     *
     * @return  $this
     * @since   1.0
     */
    public function testProcessGroups1000()
    {
        $results = $this->numbertotext->convert('1000');

        $this->assertEquals('one thousand', $this->numbertotext->propertyProcessGroups);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\NumberToText::__construct
     * @covers  Molajo\Controller\NumberToText::convert
     * @covers  Molajo\Controller\NumberToText::extractDecimal
     * @covers  Molajo\Controller\NumberToText::extractSign
     * @covers  Molajo\Controller\NumberToText::extractDigits
     * @covers  Molajo\Controller\NumberToText::createGroups
     * @covers  Molajo\Controller\NumberToText::processGroups
     * @covers  Molajo\Controller\NumberToText::processGroupDigits
     * @covers  Molajo\Controller\NumberToText::translateGroup
     * @covers  Molajo\Controller\NumberToText::getGroupDigits
     * @covers  Molajo\Controller\NumberToText::setWordTens
     * @covers  Molajo\Controller\NumberToText::setWordHundreds
     * @covers  Molajo\Controller\NumberToText::setWord
     * @covers  Molajo\Controller\NumberToText::convertGrouping
     * @covers  Molajo\Controller\NumberToText::setDecimal
     * @covers  Molajo\Controller\NumberToText::setSign
     *
     * @return  $this
     * @since   1.0
     */
    public function testProcessGroups1002()
    {
        $results = $this->numbertotext->convert('1002');

        $this->assertEquals('one thousand two', $this->numbertotext->propertyProcessGroups);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\NumberToText::__construct
     * @covers  Molajo\Controller\NumberToText::convert
     * @covers  Molajo\Controller\NumberToText::extractDecimal
     * @covers  Molajo\Controller\NumberToText::extractSign
     * @covers  Molajo\Controller\NumberToText::extractDigits
     * @covers  Molajo\Controller\NumberToText::createGroups
     * @covers  Molajo\Controller\NumberToText::processGroups
     * @covers  Molajo\Controller\NumberToText::processGroupDigits
     * @covers  Molajo\Controller\NumberToText::translateGroup
     * @covers  Molajo\Controller\NumberToText::getGroupDigits
     * @covers  Molajo\Controller\NumberToText::setWordTens
     * @covers  Molajo\Controller\NumberToText::setWordHundreds
     * @covers  Molajo\Controller\NumberToText::setWord
     * @covers  Molajo\Controller\NumberToText::convertGrouping
     * @covers  Molajo\Controller\NumberToText::setDecimal
     * @covers  Molajo\Controller\NumberToText::setSign
     *
     * @return  $this
     * @since   1.0
     */
    public function testProcessGroupsOneMillion()
    {
        $results = $this->numbertotext->convert('100000000');

        $this->assertEquals('one million', $this->numbertotext->propertyProcessGroups);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\NumberToText::__construct
     * @covers  Molajo\Controller\NumberToText::convert
     * @covers  Molajo\Controller\NumberToText::extractDecimal
     * @covers  Molajo\Controller\NumberToText::extractSign
     * @covers  Molajo\Controller\NumberToText::extractDigits
     * @covers  Molajo\Controller\NumberToText::createGroups
     * @covers  Molajo\Controller\NumberToText::processGroups
     * @covers  Molajo\Controller\NumberToText::processGroupDigits
     * @covers  Molajo\Controller\NumberToText::translateGroup
     * @covers  Molajo\Controller\NumberToText::getGroupDigits
     * @covers  Molajo\Controller\NumberToText::setWordTens
     * @covers  Molajo\Controller\NumberToText::setWordHundreds
     * @covers  Molajo\Controller\NumberToText::setWord
     * @covers  Molajo\Controller\NumberToText::convertGrouping
     * @covers  Molajo\Controller\NumberToText::setDecimal
     * @covers  Molajo\Controller\NumberToText::setSign
     *
     * @return  $this
     * @since   1.0
     */
    public function testProcessGroupsOneMillionOneHundred()
    {
        $results = $this->numbertotext->convert('100000100');

        $this->assertEquals('one million one hundred', $this->numbertotext->propertyProcessGroups);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\NumberToText::__construct
     * @covers  Molajo\Controller\NumberToText::convert
     * @covers  Molajo\Controller\NumberToText::extractDecimal
     * @covers  Molajo\Controller\NumberToText::extractSign
     * @covers  Molajo\Controller\NumberToText::extractDigits
     * @covers  Molajo\Controller\NumberToText::createGroups
     * @covers  Molajo\Controller\NumberToText::processGroups
     * @covers  Molajo\Controller\NumberToText::processGroupDigits
     * @covers  Molajo\Controller\NumberToText::translateGroup
     * @covers  Molajo\Controller\NumberToText::getGroupDigits
     * @covers  Molajo\Controller\NumberToText::setWordTens
     * @covers  Molajo\Controller\NumberToText::setWordHundreds
     * @covers  Molajo\Controller\NumberToText::setWord
     * @covers  Molajo\Controller\NumberToText::convertGrouping
     * @covers  Molajo\Controller\NumberToText::setDecimal
     * @covers  Molajo\Controller\NumberToText::setSign
     *
     * @return  $this
     * @since   1.0
     */
    public function testDigit()
    {
        $results = $this->numbertotext->convert('100000100.01');

        $this->assertEquals('one million one hundred . 01', $results);

        return $this;
    }

    /**
     * @covers  Molajo\Controller\NumberToText::__construct
     * @covers  Molajo\Controller\NumberToText::convert
     * @covers  Molajo\Controller\NumberToText::extractDecimal
     * @covers  Molajo\Controller\NumberToText::extractSign
     * @covers  Molajo\Controller\NumberToText::extractDigits
     * @covers  Molajo\Controller\NumberToText::createGroups
     * @covers  Molajo\Controller\NumberToText::processGroups
     * @covers  Molajo\Controller\NumberToText::processGroupDigits
     * @covers  Molajo\Controller\NumberToText::translateGroup
     * @covers  Molajo\Controller\NumberToText::getGroupDigits
     * @covers  Molajo\Controller\NumberToText::setWordTens
     * @covers  Molajo\Controller\NumberToText::setWordHundreds
     * @covers  Molajo\Controller\NumberToText::setWord
     * @covers  Molajo\Controller\NumberToText::convertGrouping
     * @covers  Molajo\Controller\NumberToText::setDecimal
     * @covers  Molajo\Controller\NumberToText::setSign
     *
     * @return  $this
     * @since   1.0
     */
    public function testDigitNegative()
    {
        $results = $this->numbertotext->convert('-100000100.01');

        $this->assertEquals('-one million one hundred . 01', $results);

        return $this;
    }
}
