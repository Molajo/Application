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
     * Skip File Methods
     *
     * @var    array
     * @since  1.0.0
     */
    protected $methods = array(
        'verifyDotFile',
        'verifyLanguageDirectionalFile',
        'verifySkipFile',
        'verifyNotFile',
        'verifyNotFileExtension'
    );

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
    protected function skipFile($file, $extension, $language_direction)
    {
        $options = $this->setOptions($file, $extension, $language_direction);

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
     * @param   string  $file
     * @param   string  $extension
     * @param   string  $language_direction
     *
     * @return  array
     * @since   1.0.0
     */
    protected function setOptions($file, $extension, $language_direction)
    {
        $options                       = array();
        $options['file']               = $file;
        $options['extension']          = $extension;
        $options['language_direction'] = $language_direction;

        return $options;
    }

    /**
     * Verify if file is '.' or '..'
     *
     * @param   array  $options
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function verifyDotFile(array $options = array())
    {
        if ($options['file'] == '.' || $options['file'] == '..') {
            return true;
        }

        return false;
    }

    /**
     * Verify Language Directional File
     *
     * @param   array  $options
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function verifyLanguageDirectionalFile(array $options = array())
    {
        if (in_array(substr($options['file'], 0, 3), array('ltr', 'rtl'))) {
            if (substr($options['file'], 0, 3) === $options['language_direction']) {
            } else {
                return true;
            }
        }

        return false;
    }

    /**
     * Verify Skip File
     *
     * @param   array  $options
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function verifySkipFile(array $options = array())
    {
        if (strtolower(substr($options['file'], 0, 4)) == 'hold') {
            return true;
        }

        return false;
    }

    /**
     * Verify name is actually a file
     *
     * @param   array  $options
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
     * @param   array  $options
     *
     * @return  boolean
     * @since   1.0.0
     */
    protected function verifyNotFileExtension(array $options = array())
    {
        $pathinfo = pathinfo($options['file']);

        if ($pathinfo->extension === $options['extension']) {
        } else {
            return false;
        }

        return true;
    }
}
