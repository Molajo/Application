<?php
/**
 * Translate Plugin
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Plugins\Translate;

use CommonApi\Event\DisplayInterface;
use CommonApi\Exception\RuntimeException;
use Molajo\Plugins\DisplayEventPlugin;

/**
 * Translate Plugin
 *
 * @package     Molajo
 * @license     http://www.opensource.org/licenses/mit-license.html MIT License
 * @since       1.0
 */
class TranslatePlugin extends DisplayEventPlugin implements DisplayInterface
{
    /**
     * Parse Mask for Translate Literals
     *
     * @var    string
     * @since  1.0
     */
    protected $parse_mask = '#{T (.*) T}#iU';

    /**
     * Search for and translate <translate THIS/> statements
     *
     * @return  $this
     * @since   1.0
     */
    public function onAfterRender()
    {
        $tokens_to_translate = $this->parseTokens();

        if (count($tokens_to_translate[1]) == 0) {
            return $this;
        }

        for ($i = 0; $i < count($tokens_to_translate[1]); $i ++) {
            $token       = $tokens_to_translate[0][$i];
            $string      = $tokens_to_translate[1][$i];

            if (trim($string) == '') {
                $filtered    = '';
            } else {
                $translation = $this->translateToken($string);
                $filtered    = $this->filterTranslation($string, $translation);
            }

            $this->replaceToken($token, $filtered);
        }

        return $this;
    }

    /**
     * Parse tokens to be translated
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function parseTokens()
    {
        $tokens_to_translate = array();

        preg_match_all($this->parse_mask, $this->rendered_page, $tokens_to_translate);

        return $tokens_to_translate;
    }

    /**
     * Translate Value
     *
     * @param   string $this
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function translateToken($string)
    {
        return $this->language_controller->translate($string);
    }

    /**
     * Translate Value
     *
     * @param   string $this
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function filterTranslation($string, $translation)
    {
        return $this->fieldhandler->escape('Translation of ' . $string, $translation, 'string');
    }

    /**
     * Translate Value
     *
     * @param   string $token
     * @param   string $translation
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function replaceToken($token, $translation)
    {
        $this->rendered_page = str_replace($token, $translation, $this->rendered_page);

        return $this;
    }
}
