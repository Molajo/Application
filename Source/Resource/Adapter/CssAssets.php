<?php
/**
 * Css Assets Resource Adapter
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
abstract class CssAssets extends Assets
{
    /**
     * Option Names
     *
     * @var    array
     * @since  1.0.0
     */
    protected $css_options_names
        = array(
            'priority'    => 'integer',
            'mimetype'    => 'string',
            'media'       => 'string',
            'conditional' => 'string',
            'attributes'  => 'array'
        );

    /**
     * Create a row containing the CSS information
     *
     * @param   string $css_path_or_string
     * @param   array  $options
     *
     * @return  stdClass
     * @since   1.0.0
     */
    protected function setCssRow($css_path_or_string, array $options = array())
    {
        $row                     = new stdClass();
        $row->css_path_or_string = $css_path_or_string;

        foreach ($this->css_options_names as $name => $filter) {

            if (isset($options[$name])) {
                $value = $options[$name];
            } else {
                $value = null;
            }

            $row->$name = $this->setOptionValue($value, $filter);
        }

        return $row;
    }
}
