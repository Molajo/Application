<?php
/**
 * Extension Defaults
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource;

use CommonApi\Fieldhandler\FieldhandlerInterface;
use CommonApi\Query\QueryInterface;
use stdClass;

/**
 * Extension Defaults
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
final class Defaults
{
    /**
     * Fieldhandler Usage Trait
     *
     * @var     object  CommonApi\Fieldhandler\FieldhandlerUsageTrait
     * @since   1.0.0
     */
    use \CommonApi\Fieldhandler\FieldhandlerUsageTrait;

    /**
     * Query Usage Trait
     *
     * @var     object  CommonApi\Query\QueryUsageTrait
     * @since   1.0.0
     */
    use \CommonApi\Query\QueryUsageTrait;

    /**
     * Extensions Filename
     *
     * @var    string
     * @since  1.0.0
     */
    protected $defaults_filename;

    /**
     * Extension Properties
     *
     * @var    array
     * @since  1.0.0
     */
    protected $extension_properties = array();

    /**
     * Extension Type to Catalog Type Id
     *
     * @var    array
     * @since  1.0.0
     */
    protected $extension_catalog_type_ids
        = array(
            5000  => 'Plugins',
            7000  => 'Themes',
            8000  => 'Pages',
            9000  => 'Templates',
            10000 => 'Wraps',
            12000 => 'Resources'
        );

    /**
     * Constructor
     *
     * @param  QueryInterface        $resource
     * @param  FieldhandlerInterface $fieldhandler
     * @param  string                $defaults_filename
     *
     * @since  1.0
     */
    public function __construct(
        QueryInterface $resource,
        FieldhandlerInterface $fieldhandler,
        $defaults_filename = null
    ) {
        $this->resource          = $resource;
        $this->fieldhandler      = $fieldhandler;
        $this->defaults_filename = $defaults_filename;
    }

    /**
     * Catalog Types
     *
     * @return  stdClass
     * @since   1.0.0
     */
    public function get()
    {
        $this->getExtensions();

        $x = json_encode($this->extension_properties, JSON_PRETTY_PRINT);

        file_put_contents($this->defaults_filename, $x);

        return $x;
    }

    /**
     * Get Extensions
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function getExtensions()
    {
        $this->setQueryController('Molajo//Model//Datasource//ExtensionInstances.xml');

        $this->setExtensionsQueryValues();

        $this->setExtensionsSql();

        $items = $this->runQuery();

        return $this->processExtensions($items);
    }

    /**
     * Set Extensions Query Values
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setExtensionsQueryValues()
    {
        $this->setQueryControllerDefaults(
            $process_events = 0,
            $query_object = 'list',
            $get_customfields = 0,
            $use_special_joins = 0,
            $use_pagination = 0,
            $check_view_level_access = 0,
            $get_item_children = 0
        );

        return $this;
    }

    /**
     * Set Extensions Query Sql
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function setExtensionsSql()
    {
        $prefix = $this->query->getModelRegistry('primary_prefix', 'a');

        $this->query->select($prefix . '.' . 'id');
        $this->query->select($prefix . '.' . 'extension_id');
        $this->query->select($prefix . '.' . 'catalog_type_id');
        $this->query->select($prefix . '.' . 'title');
        $this->query->select($prefix . '.' . 'namespace');
        $this->query->select($prefix . '.' . 'alias');
        $this->query->select($prefix . '.' . 'contentfields');

        $list = '5000, 7000, 8000, 9000, 10000, 12000';

        $this->query->where('column', $prefix . '.' . 'catalog_type_id', 'IN', 'string', $list);
        $this->query->where('column', $prefix . '.' . 'id', '<>', 'column', $prefix . '.' . 'catalog_type_id');

        $this->query->orderBy($prefix . '.' . 'catalog_type_id');
        $this->query->orderBy($prefix . '.' . 'title');

        return $this;
    }

    /**
     * Process Extensions
     *
     * @param   array $items
     *
     * @return  array|stdClass
     * @since   1.0.0
     */
    protected function processExtensions($items)
    {
        foreach ($items as $item) {

            $new_item = new stdClass();

            $new_item->extension_type            = $this->extension_catalog_type_ids[$item->catalog_type_id];
            $new_item->id                        = $item->id;
            $new_item->name                      = $item->title;
            $new_item->alias                     = $item->alias;
            $new_item->namespace                 = $item->namespace;
            $new_item->extension_catalog_type_id = $item->catalog_type_id;

            if ($new_item->extension_type === 'Resources') {
                $new_item->content_catalog_type_id = $item->id;
            } else {
                $new_item->content_catalog_type_id = $item->catalog_type_id;
            }

            $new_item->contentfields = $item->contentfields;

            $key = trim($new_item->extension_type) . ' ' . trim($new_item->alias);

            $this->extension_properties[$key] = $new_item;
        }

        return $this;
    }
}
