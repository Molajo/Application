<?php
/**
 * Translation
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Controller\Translations;

use CommonApi\Controller\TranslateInterface;
use CommonApi\Exception\RuntimeException;

/**
 * Translate requested string for specified locale
 *
 * @package     Molajo
 * @subpackage  NumberToText
 * @since       1.0
 */
class Translate implements TranslateInterface
{
    /**
     * Translation Strings for Numbers
     *
     * @var    array
     * @since  1.0
     */
    protected $number_translate_array = array();

    /**
     * Constructor
     *
     * @param  string $locale
     *
     * @since  1.0
     */
    public function __construct($locale = 'en-GB')
    {
        if ($locale === '') {
            $locale = 'enGB';
        }

        $locale = str_replace('-', '', $locale);

        $class = 'Molajo\\Translations\\' . $locale;

        try {
            $translate                    = new $class();
            $this->number_translate_array = $translate->loadTranslation();
        } catch (RuntimeException $e) {
            throw new RuntimeException(
                'NumberToText Translate Error Loading ' . $class . ' ' . $e->getMessage()
            );
        }
    }

    /**
     * Translate the string
     *
     * @param   string $string
     *
     * @return  string
     * @since   1.0
     */
    public function translate($string)
    {
        if (isset($this->number_translate_array[$string])) {
            return $this->number_translate_array[$string];
        }

        return $string;
    }
}
