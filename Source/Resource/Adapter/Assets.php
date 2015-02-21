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
abstract class Assets extends AssetBase
{
    /**
     * Handle located folder/file associated with URI Namespace for Resource
     *
     * @param   string $scheme
     * @param   string $located_path
     * @param   array  $options
     *
     * @return  mixed
     * @since   1.0.0
     */
    public function handlePath($scheme, $located_path, array $options = array())
    {
        if (is_dir($located_path)) {
            $this->addAssetFolder($located_path, $options);

        } elseif (file_exists($located_path)) {
            $this->addAssetFile($located_path, $options);

        } else {
            $this->addAssetString($options);
        }

        return $this;
    }


    /**
     * addAssetFolder - Loads the CSS files located within the identified folder
     *
     * @param   string $file_path
     * @param   array  $options
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function addAssetFolder($file_path, $options)
    {
        $files = scandir($file_path);

        if (count($files) === 0) {
            return $this;
        }

        foreach ($files as $file) {
            $this->addAssetFile($file_path . '/' . $file, $options);
        }

        return $this;
    }

    /**
     * Add Asset Filename to Page Array
     *
     * @param   string $file_path
     * @param   array  $options
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function addAssetFile($file_path, array $options = array())
    {
        if (is_file($file_path) === false) {
            return $this;
        }

        if ($this->skipFile($file_path, $this->language_direction) === true) {
            return $this;
        }

        if ($this->skipDuplicate($file_path) === true) {
            return $this;
        }

        $row = $this->setAssetRow($file_path, $options);

        $this->asset_array[] = $row;

        return $this;
    }

    /**
     * Add Asset Filename to the page array
     *
     * @param   array $options
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function addAssetString(array $options = array())
    {
        if ($this->skipAssetString($options) === true) {
            return $this;
        }

        $asset_string = $options['asset_string'];
        unset($options['asset_string']);

        $row = $this->setAssetRow($asset_string, $options);

        $this->asset_array[] = $row;

        return $this;
    }

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
        if (strtolower(substr($options['filename'], 0, 4)) == 'hold') {
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
        if ($options['extension'] === $this->asset_type) {
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

    /**
     * Create a row containing the CSS information
     *
     * @param   string $path_or_string
     * @param   array  $options
     *
     * @return  stdClass
     * @since   1.0.0
     */
    protected function setAssetRow($path_or_string, array $options = array())
    {
        $row                 = new stdClass();
        $row->path_or_string = $path_or_string;

        foreach ($this->asset_options as $name => $filter) {

            if (isset($options[$name])) {
                $value = $options[$name];
            } else {
                $value = null;
            }

            $row->$name = $this->filterOptionValue($value, $filter);
        }

        return $row;
    }

    /**
     * Filter Option Value
     *
     * @param   mixed  $value
     * @param   string $filter
     *
     * @return  string
     * @since   1.0.0
     */
    protected function filterOptionValue($value, $filter)
    {
        if ($filter === 'array') {

            if (is_array($value)) {
                $value = trim(implode(' ', $value));
                return (string)$value;

            } else {
                return '';
            }
        }

        return filter_var($value, $filter);
    }
}
