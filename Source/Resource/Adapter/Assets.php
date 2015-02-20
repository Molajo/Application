<?php
/**
 * Assets Resource Adapter
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource\Adapter;

/**
 * Assets Resource Adapter
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0
 */
abstract class Assets extends AbstractAdapter
{
    /**
     * Perform file checks for inclusion
     *
     * @param   string  $file
     * @param   string  $extension
     * @param   string  $language_direction
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function includeFile($file, $extension, $language_direction)
    {
        $skip = 0;

        if ($this->verifyDotFile($file) === true) {
            $skip++;
        }

        if ($this->verifyLanguageDirectionalFile($file, $language_direction) === false) {
            $skip++;
        }

        if ($this->verifySkipFile($file) === false) {
            $skip++;
        }

        if (is_file($file) === true) {
        } else {
            $skip++;
        }

        if ($this->verifyFileExtension($file, $extension) === false) {
            $skip++;
        }

        return (boolean) $skip;
    }

    /**
     * Verify if file is '.' or '..'
     *
     * @param   string  $file
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function verifyDotFile($file)
    {
        if ($file == '.' || $file == '..') {
            return true;
        }

        return false;
    }

    /**
     * Verify Language Directional File
     *
     * @param   string  $file
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function verifyLanguageDirectionalFile($file, $language_direction)
    {
        if (substr($file, 0, 4) == 'ltr_' && $language_direction == 'rtl') {
                return false;
        }

        if (substr($file, 0, 4) == 'rtl_' && $language_direction == 'ltr') {
            return false;
        }

        return true;
    }

    /**
     * Verify Skip File
     *
     * @param   string  $file
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function verifySkipFile($file)
    {
        if (strtolower(substr($file, 0, 4)) == 'hold') {
            return false;
        }

        return true;
    }

    /**
     * Verify File Extension
     *
     * @param   string  $file
     * @param   string  $extension
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function verifyFileExtension($file, $extension)
    {
        $pathinfo = pathinfo($file);

        if ($pathinfo->extension === $extension) {
            return true;
        }

        return false;
    }
}
