<?php
/**
 * Field Handler
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource\Adapter;

use CommonApi\Resource\ResourceInterface;

/**
 * Field Handler
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
final class Field extends NamespaceHandler implements ResourceInterface
{
    /**
     * Fields
     *
     * @var    array
     * @since  1.0.0
     */
    protected $fields;

    /**
     * Constructor
     *
     * @param  string $base_path
     * @param  array  $resource_map
     * @param  array  $namespace_prefixes
     * @param  array  $valid_file_extensions
     * @param  array  $cache_callbacks
     * @param  array  $handler_options
     *
     * @since  1.0.0
     */
    public function __construct(
        $base_path,
        array $resource_map = array(),
        array $namespace_prefixes = array(),
        array $valid_file_extensions = array(),
        array $cache_callbacks = array(),
        array $handler_options = array()
    ) {
        parent::__construct(
            $base_path,
            $resource_map,
            $namespace_prefixes,
            $valid_file_extensions,
            $cache_callbacks
        );

        $this->fields = $handler_options['fields'];
    }

    /**
     * Locates resource associated with Namespace
     *
     * @param   string $resource_namespace
     * @param   array  $options
     *
     * @return  object
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function get($resource_namespace, array $options = array())
    {
        return $resource_namespace;
    }

    /**
     * Handle located folder/file associated with URI Namespace for Resource
     *
     * @param   string $located_path
     * @param   array  $options
     *
     * @return  string
     * @since   1.0.0
     */
    public function handlePath($located_path, array $options = array())
    {
        if (isset($this->fields[$located_path])) {
            return $this->buildAttributeArray($this->fields[$located_path]);
        }

        return null;
    }

    /**
     * Build Attribute Array for Field
     *
     * @param   object $field
     *
     * @return  array
     * @since   1.0.0
     */
    protected function buildAttributeArray($field)
    {
        $field_attributes = array();

        foreach ($field as $key => $value) {
            $field_attributes[$key] = $value;
        }

        return $field_attributes;
    }

    /**
     * Retrieve a collection of a specific handler
     *
     * @param   string $scheme
     * @param   array  $options
     *
     * @return  mixed
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function getCollection($scheme, array $options = array())
    {
        return $this->fields;
    }
}
