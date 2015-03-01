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
abstract class Assets extends AssetSelection
{
    /**
     * Handle located folder/file associated with URI Namespace for Resource
     *
     * @param   string $located_path
     * @param   array  $options
     *
     * @return  mixed
     * @since   1.0.0
     */
    public function handlePath($located_path, array $options = array())
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
        $this->setAssetOptions();

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
     * Set Asset Options based on type
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setAssetOptions()
    {
        if (strtolower(substr($this->scheme_name, 0, 3)) === 'css') {
            $this->asset_options = $this->asset_options_by_type['css'];
        } else {
            $this->asset_options = $this->asset_options_by_type['js'];
        }

        return $this;
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
