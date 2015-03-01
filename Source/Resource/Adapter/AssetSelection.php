<?php
/**
 * Assets Resource Adapter
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource\Adapter;

use stdClass;

/**
 * Assets Resource Adapter
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0
 */
abstract class AssetSelection extends AssetCollection
{

    /**
     * Test Asset String to see if it should be added to page array
     *
     * @param   array $options
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function skipAssetString(array $options = array())
    {
        if (isset($options['asset_string'])) {
        } else {
            return true;
        }

        if (trim($options['asset_string']) === '') {
            return true;
        }

        return $this->skipDuplicate($options['asset_string']);
    }

    /**
     * Perform file checks for inclusion
     *
     * @param   string $file
     * @param   string $language_direction
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function skipFile($file, $language_direction)
    {
        $options = $this->setMethodOptions($file, $language_direction);

        foreach ($this->methods as $method) {

            if ($this->$method($options) === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * Load options into an array
     *
     * @param   string $file
     * @param   string $language_direction
     *
     * @return  array
     * @since   1.0.0
     */
    protected function setMethodOptions($file, $language_direction)
    {
        $pathinfo = pathinfo($file);

        $options                       = array();
        $options['file']               = $file;
        $options['filename']           = $pathinfo['filename'];
        $options['extension']          = $pathinfo['extension'];
        $options['language_direction'] = $language_direction;

        return $options;
    }

    /**
     * Verify if file is '.' or '..'
     *
     * @param   array $options
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function verifyDotFile(array $options = array())
    {
        if ($options['filename'] == '.' || $options['filename'] == '..') {
            return true;
        }

        return false;
    }

    /**
     * Verify Language Directional File
     *
     * @param   array $options
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function verifyLanguageDirectionalFile(array $options = array())
    {
        $test = substr($options['filename'], 0, 3);

        if (in_array($test, array('ltr', 'rtl'))) {

            if ($test === $options['language_direction']) {
            } else {
                return true;
            }
        }

        return false;
    }

    /**
     * Verify Skip File
     *
     * @param   array $options
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function verifySkipFile(array $options = array())
    {
        if (strtolower(substr($options['filename'], 0, 4)) === 'hold') {
            return true;
        }

        return false;
    }

    /**
     * Verify name is actually a file
     *
     * @param   array $options
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function verifyNotFile(array $options = array())
    {
        if (is_file($options['file']) === true) {
        } else {
            return true;
        }

        return false;
    }

    /**
     * Verify File Extension
     *
     * @param   array $options
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function verifyNotFileExtension(array $options = array())
    {
        if (strtolower($options['extension']) === strtolower($this->scheme_name)) {
            return false;
        }

        return true;
    }

    /**
     * Skip if it has already been defined to page array
     *
     * @param   string $path_or_string
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function skipDuplicate($path_or_string)
    {
        if (count($this->asset_array) === 0) {
            return false;
        }

        foreach ($this->asset_array as $existing) {

            if ($existing->path_or_string === $path_or_string) {
                return true;
            }
        }

        return false;
    }
}
