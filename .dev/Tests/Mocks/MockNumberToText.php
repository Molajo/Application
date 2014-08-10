<?php
/**
 * Translate Number to Text Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller\Translate\Test;

use Molajo\Controller\NumberToText;

/**
 * Number to Text Utility: Converts a numeric value up to a 999 quattuordecillion to translatable term.
 *
 * @package     Molajo
 * @subpackage  NumberToText
 * @since       1.0
 */
class MockNumberToText extends NumberToText
{
    public $propertyConvert;
    public $propertyExtractDecimal;
    public $propertyExtractSign;
    public $propertyExtractDigits;
    public $propertyCreateGroups;
    public $propertyProcessGroups;
    public $propertyTranslateGroup;
    public $propertySetWordTens;
    public $propertySetWordHundreds;
    public $propertySetWord;

    public function convert($number, $remove_spaces = false)
    {
        $this->propertyConvert = parent::convert($number, $remove_spaces);

        return $this->propertyConvert;
    }

    protected function extractDecimal($number)
    {
        $this->propertyExtractDecimal = parent::extractDecimal($number);

        return $this->propertyExtractDecimal;
    }

    protected function extractSign($digit)
    {
        $this->propertyExtractSign = parent::extractSign($digit);

        return $this->propertyExtractSign;
    }

    protected function extractDigits($number)
    {
        $this->propertyExtractDigits = parent::extractDigits($number);

        return $this->propertyExtractDigits;
    }

    protected function createGroups($number)
    {
        $this->propertyCreateGroups = parent::createGroups($number);

        return $this->propertyCreateGroups;
    }

    protected function processGroups(array $groups = array())
    {
        $this->propertyProcessGroups = parent::processGroups($groups);

        return $this->propertyProcessGroups;
    }

    protected function translateGroup($digits, $i)
    {
        $this->propertyTranslateGroup = parent::translateGroup($digits, $i);

        return $this->propertyTranslateGroup;
    }

    protected function setWordTens($tens_digit, $ones_digit, $onesWord)
    {
        $this->propertySetWordTens = parent::setWordTens($tens_digit, $ones_digit, $onesWord);

        return $this->propertySetWordTens;
    }

    protected function setWordHundreds($hundreds_digit, $tens_word)
    {
        $this->propertySetWordHundreds = parent::setWordHundreds($hundreds_digit, $tens_word);

        return $this->propertySetWordHundreds;
    }

    protected function setWord($digit, $digit_position = 0)
    {
        $this->propertySetWord = parent::setWord($digit, $digit_position = 0);

        return $this->propertySetWord;
    }

    protected function convertGrouping($number = 0)
    {
        $this->propertySetWord = parent::convertGrouping($number);

        return $this->propertySetWord;
    }
}
