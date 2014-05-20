<?php
/**
 * Number To Text Controller
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Controller;

use CommonApi\Controller\NumberToTextInterface;
use CommonApi\Language\TranslateInterface;

/**
 * Number to Text Utility: Converts a numeric value up to a 999 quattuordecillion to translatable term.
 *
 * @package     Molajo
 * @subpackage  NumberToText
 * @since       1.0
 */
class NumberToText implements NumberToTextInterface
{
    /**
     * Translation Strings for Numbers
     *
     * @var    array
     * @since  1.0
     */
    protected $locale_instance;

    /**
     * Assigning words
     *
     * @var    array
     * @since  1.0
     */
    protected $number_array = array();

    /**
     * Constructor
     *
     * @param  TranslateInterface $locale_instance
     *
     * @since  1.0
     */
    public function __construct(TranslateInterface $locale_instance)
    {
        $this->locale_instance = $locale_instance;

        $this->number_array = array();

        $this->number_array[0][0] = 'number_zero';
        $this->number_array[0][1] = 'number_one';
        $this->number_array[0][2] = 'number_two';
        $this->number_array[0][3] = 'number_three';
        $this->number_array[0][4] = 'number_four';
        $this->number_array[0][5] = 'number_five';
        $this->number_array[0][6] = 'number_six';
        $this->number_array[0][7] = 'number_seven';
        $this->number_array[0][8] = 'number_eight';
        $this->number_array[0][9] = 'number_nine';

        $this->number_array[1][0] = 'number_ten';
        $this->number_array[1][1] = 'number_eleven';
        $this->number_array[1][2] = 'number_twelve';
        $this->number_array[1][3] = 'number_thirteen';
        $this->number_array[1][4] = 'number_fourteen';
        $this->number_array[1][5] = 'number_fifteen';
        $this->number_array[1][6] = 'number_sixteen';
        $this->number_array[1][7] = 'number_seventeen';
        $this->number_array[1][8] = 'number_eighteen';
        $this->number_array[1][9] = 'number_nineteen';

        $this->number_array[2][2] = 'number_twenty';
        $this->number_array[2][3] = 'number_thirty';
        $this->number_array[2][4] = 'number_forty';
        $this->number_array[2][5] = 'number_fifty';
        $this->number_array[2][6] = 'number_sixty';
        $this->number_array[2][7] = 'number_seventy';
        $this->number_array[2][8] = 'number_eighty';
        $this->number_array[2][9] = 'number_ninety';
    }

    /**
     * Converts a numeric value, with or without a decimal, up to a 999 quattuordecillion to words
     *
     * @param   string $number
     *
     * @return  string
     * @since   1.0
     */
    public function convert($number)
    {
        list($digit, $decimal) = $this->extractDecimal($number);
        list($sign, $digit) = $this->extractSign($digit);
        $digits     = $this->extractDigits($digit);
        $groups     = $this->createGroups($digits);
        $word_value = $this->processGroups($groups);
        $word_value = $this->setDecimal($decimal, $word_value);
        $word_value = $this->setSign($sign, $word_value);

        return trim($word_value);
    }

    /**
     * Extract out the decimal
     *
     * @param   $number
     *
     * @return  array
     * @since   1.0.0
     */
    protected function extractDecimal($number)
    {
        $digit = explode('.', $number);

        if (count($digit) > 1) {
            return array($digit[0], $digit[1]);
        }

        return array($number, null);
    }

    /**
     * Separate out digits from whole digits
     *
     * @param   $digit
     *
     * @return  array
     * @since   1.0.0
     */
    protected function extractSign($digit)
    {
        $sign = '';

        if (substr($digit, 0, 1) === '+') {
            $sign = '+';

        } elseif (substr($digit, 0, 1) === '-') {
            $sign = '-';

        } else {
            return array($sign, $digit);
        }

        $digit = substr($digit, 1, strlen($digit) - 1);

        return array($sign, $digit);
    }

    /**
     * Extract each digit into reverse order and sets of three (ex 1,000 = 000100)
     *
     * @param  string $number
     *
     * @return string
     * @since  1.0.0
     */
    protected function extractDigits($number)
    {
        $reverseDigits = str_split($number, 1);
        $number        = implode(array_reverse($reverseDigits));

        if ((strlen($number) % 3) == 0) {
            $padToSetsOfThree = strlen($number);
        } else {
            $padToSetsOfThree = 3 - (strlen($number) % 3) + strlen($number);
        }

        return str_pad($number, $padToSetsOfThree, 0, STR_PAD_RIGHT);
    }

    /**
     * Create groups of three for further processing
     *
     * @param  string $number
     *
     * @return string
     * @since  1.0.0
     */
    protected function createGroups($number)
    {
        return str_split($number, 3);
    }

    /**
     * Translate Groups of three digit, one group at a time
     *
     * @param  array $groups
     *
     * @return string
     * @since  1.0.0
     */
    protected function processGroups(array $groups = array())
    {
        $i          = 0;
        $word_value = '';

        foreach ($groups as $digits) {

            $temp_word_value = $this->translateGroup($digits, $i);

            if (trim($word_value) === '') {
                $word_value = $temp_word_value;
            } else {
                $word_value = trim($temp_word_value) . ' ' . trim($word_value);
            }

            $i++;
        }

        if (trim($word_value) === '') {
            $word_value = $this->locale_instance->translateString('number_zero');
        }

        return $word_value;
    }

    /**
     * Translate Group of three digits
     *
     * @param   string  $digits
     * @param   integer $i
     *
     * @return  string
     * @since   1.0.0
     */
    protected function translateGroup($digits, $i)
    {
        $digit = str_split($digits);

        $ones_digit     = (int)$digit[0];
        $tens_digit     = (int)$digit[1];
        $hundreds_digit = (int)$digit[2];

        if ($ones_digit === 0 && $tens_digit === 0 && $hundreds_digit === 0) {
            return '';
        }

        $temp_word_value = $this->setWord($ones_digit);
        $temp_word_value = $this->setWordTens($tens_digit, $ones_digit, $temp_word_value);
        $temp_word_value = $this->setWordHundreds($hundreds_digit, $temp_word_value);

        if ($i > 0 || $hundreds_digit > 0) {
            $temp_word_value .= ' ' . $this->convertGrouping($i);
        }

        return $temp_word_value;
    }

    /**
     * Convert the tens placeholder to a word, combining with the ones placeholder word
     *
     * @param   string $tens_digit
     * @param   string $ones_digit
     * @param   string $ones_word
     *
     * @return  string
     * @since   1.0
     */
    protected function setWordTens($tens_digit, $ones_digit, $ones_word)
    {
        if ($tens_digit === 0) {
            $string = $ones_word;

        } elseif ($tens_digit === 1) { // 18 = eighteen - use the ones digit
            $string = $this->setWord($ones_digit, 1);

        } else {
            $string = $this->setWord($tens_digit, 2) . ' ' . $ones_word; // 21: twenty + one
        }

        return $string;
    }

    /**
     * Creates words for hundred digit, combining previously determined tens and one digit words
     *
     * @param   string $hundreds_digit
     * @param   string $tens_word
     *
     * @return  string
     * @since   1.0
     */
    protected function setWordHundreds($hundreds_digit, $tens_word)
    {
        if ($hundreds_digit === 0) {
            $string = $tens_word;

        } else {
            $string = $this->setWord($hundreds_digit, 0);
        }

        return $string;
    }

    /**
     * Set word for number
     *
     * @param   integer $digit
     * @param   integer $digit_position
     *
     * @return  string
     * @since   1.0
     */
    protected function setWord($digit, $digit_position = 0)
    {
        switch ($digit) {

            case 0:
                $string = $this->locale_instance->translateString($this->number_array[$digit_position][0]);
                break;
            case 1:
                $string = $this->locale_instance->translateString($this->number_array[$digit_position][1]);
                break;
            case 2:
                $string = $this->locale_instance->translateString($this->number_array[$digit_position][2]);
                break;
            case 3:
                $string = $this->locale_instance->translateString($this->number_array[$digit_position][3]);
                break;
            case 4:
                $string = $this->locale_instance->translateString($this->number_array[$digit_position][4]);
                break;
            case 5:
                $string = $this->locale_instance->translateString($this->number_array[$digit_position][5]);
                break;
            case 6:
                $string = $this->locale_instance->translateString($this->number_array[$digit_position][6]);
                break;
            case 7:
                $string = $this->locale_instance->translateString($this->number_array[$digit_position][7]);
                break;
            case 8:
                $string = $this->locale_instance->translateString($this->number_array[$digit_position][8]);
                break;
            case 9:
                $string = $this->locale_instance->translateString($this->number_array[$digit_position][9]);
                break;
        }

        return $string;
    }

    /**
     * Creates the high-level word associated with the numeric group
     *
     * ex. for 300,000: we want 'thousand' to combine with 'three hundred' to make 'three hundred thousand'
     *
     * Called once for each set of (up to) three numbers over one hundred.
     *
     * Ex. for 3,000,000 it will be called for the middle "000" and the first digit, 3
     *
     * Source: http://en.wikipedia.org/wiki/Names_of_large_numbers
     *
     * @param   string $number
     *
     * @return  string
     * @since   1.0
     */
    protected function convertGrouping($number)
    {
        $string = '';

        switch ((int)$number) {

            case 0:
                $string = $this->locale_instance->translateString('number_hundred');
                break;
            case 1:
                $string = $this->locale_instance->translateString('number_thousand');
                break;
            case 2:
                $string = $this->locale_instance->translateString('number_million');
                break;
            case 3:
                $string = $this->locale_instance->translateString('number_billion');
                break;
            case 4:
                $string = $this->locale_instance->translateString('number_trillion');
                break;
            case 5:
                $string = $this->locale_instance->translateString('number_quadrillion');
                break;
            case 6:
                $string = $this->locale_instance->translateString('number_quintillion');
                break;
            case 7:
                $string = $this->locale_instance->translateString('number_sextillion');
                break;
            case 8:
                $string = $this->locale_instance->translateString('number_septillion');
                break;
            case 9:
                $string = $this->locale_instance->translateString('number_octillion');
                break;
            case 10:
                $string = $this->locale_instance->translateString('number_nonillion');
                break;
            case 11:
                $string = $this->locale_instance->translateString('number_decillion');
                break;
            case 12:
                $string = $this->locale_instance->translateString('number_undecillion');
                break;
            case 13:
                $string = $this->locale_instance->translateString('number_duodecillion');
                break;
            case 14:
                $string = $this->locale_instance->translateString('number_tredecillion');
                break;
            case 15:
                $string = $this->locale_instance->translateString('number_quattuordecillion');
                break;
            case 16:
                $string = $this->locale_instance->translateString('number_quinquadecillion');
                break;
        }

        return $string;
    }

    /**
     * Set Decimal
     *
     * @param   string $decimal
     * @param   string $word_value
     *
     * @return  string
     * @since   1.0.0
     */
    protected function setDecimal($decimal, $word_value)
    {
        if ($decimal === null) {
        } else {
            $word_value .= ' ' . $this->locale_instance->translateString('number_point') . ' ' . $decimal;
        }

        return $word_value;
    }

    /**
     * Assign Sign
     *
     * @param   string $sign
     * @param   string $word_value
     *
     * @return  mixed
     * @since   1.0
     */
    protected function setSign($sign, $word_value)
    {
        if (trim($sign) === '-') {
            $word_value = $this->locale_instance->translateString('number_negative') . $word_value;
        }

        return $word_value;
    }
}
