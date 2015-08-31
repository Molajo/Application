<?php
/**
 * Default Xml
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Resource\Adapter;

use CommonApi\Exception\RuntimeException;

/**
 * Default Xml
 *
 * @package    Molajo
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
final class Defaultxml
{
    /**
     * Extension Type to Catalog Type Id
     *
     * @var    array
     * @since  1.0.0
     */
    protected $extension_catalog_type_ids
        = array(
            'Plugins'   => 5000,
            'Themes'    => 7000,
            'Pages'     => 8000,
            'Templates' => 9000,
            'Wraps'     => 10000,
            'Resources' => 12000
        );

    /**
     * Default Xml
     *
     * @var    array
     * @since  1.0.0
     */
    protected $default_xml = array();

    /**
     * Extensions
     *
     * @var    object
     * @since  1.0.0
     */
    protected $extensions;

    /**
     * Resource Namespace
     *
     * @var    string
     * @since  1.0.0
     */
    protected $resource_namespace = null;

    /**
     * Extension Type
     *
     * @var    string
     * @since  1.0.0
     */
    protected $extension_type = null;

    /**
     * Namespace Segments
     *
     * @var    array
     * @since  1.0.0
     */
    protected $namespace_segments = array();

    /**
     * Extension Key
     *
     * @var    string
     * @since  1.0.0
     */
    protected $extension_key = null;

    /**
     * Extension
     *
     * @var    string
     * @since  1.0.0
     */
    protected $extension = null;

    /**
     * Constructor
     *
     * @param  array $default_xml
     *
     * @since  1.0.0
     */
    public function __construct(
        array $default_xml = array(),
        $extensions = null
    ) {
        $this->default_xml = $default_xml;
        $this->extensions  = $extensions;
    }

    /**
     * Get Default
     *
     * @param   string $resource_namespace
     *
     * @return  string
     * @throws  \CommonApi\Exception\RuntimeException
     * @since   1.0.0
     */
    public function get($resource_namespace)
    {
        $this->resource_namespace = $resource_namespace;
        $this->namespace_segments = explode('\\', $this->resource_namespace);
        $count                    = count($this->namespace_segments);

        // Molajo/Plugins/Article/Configuration.xml/
        if ($this->namespace_segments[1] === 'Plugins') {
            $located_path = $this->handleDefaultPluginsPath();

            // Molajo/Themes/Foundation5/Configuration.xml/
        } elseif ($this->namespace_segments[1] === 'Themes' && $count === 5) {
            $located_path = $this->handleDefaultThemesPath();

            // Molajo/Themes/Views/Pages/Article/Configuration.xml/
        } elseif ($this->namespace_segments[1] === 'Themes') {
            $located_path = $this->handleDefaultViewsPath();

            // Molajo/Resources/Article/Configuration.xml/
        } elseif ($this->namespace_segments[1] === 'Resources') {
            $located_path = $this->handleDefaultResourcesPath();

        } else {
            throw new RuntimeException('Defaultxml: Unknown Extension Type: ' . $this->resource_namespace);
        }

        $default_xml = $this->getDefaultXml($located_path);

        $default_xml = $this->setPlaceholders($default_xml);

        return $default_xml;
    }

    /**
     * Handle Default Plugins Path
     *
     * @return  string
     * @since   1.0.0
     */
    protected function handleDefaultPluginsPath()
    {
        $this->extension_key = 'Plugins ' . strtolower($this->namespace_segments[2]);

        return __DIR__ . '/Xml/Plugins/' . $this->namespace_segments[3];
    }

    /**
     * Handle Default Themes Path
     *
     * @return  string
     * @since   1.0.0
     */
    protected function handleDefaultThemesPath()
    {
        $this->extension_key = 'Themes ' . strtolower($this->namespace_segments[2]);

        return __DIR__ . '/Xml/Themes/' . $this->namespace_segments[3];
    }

    /**
     * Handle Default Views Path
     *
     * @return  string
     * @since   1.0.0
     */
    protected function handleDefaultViewsPath()
    {
        $this->extension_key = ucfirst(strtolower($this->namespace_segments[4]))
            . ' '
            . strtolower($this->namespace_segments[5]);

        return __DIR__ . '/Xml/Themes/Views/' . $this->namespace_segments[4] . '/' . $this->namespace_segments[6];
    }

    /**
     * Handle Default Resource Path
     *
     * @return  string
     * @since   1.0.0
     */
    protected function handleDefaultResourcesPath()
    {
        $this->extension_key = 'Resources ' . strtolower($this->namespace_segments[2]);

        return __DIR__ . '/Xml/Resources/' . $this->namespace_segments[3];
    }

    /**
     * Get Default Xml
     *
     * @param   string $located_path
     *
     * @return  string
     * @since   1.0.0
     */
    protected function getDefaultXml($located_path)
    {
        if (file_exists($located_path)) {
            return $this->default_xml[$located_path];
        }

        throw new RuntimeException('Resource Defaultxml Adapter: No file found for: ' . $this->resource_namespace);
    }

    /**
     * Set placeholder values for default xml
     *
     * @param   string $default_xml
     *
     * @return  string
     * @since   1.0.0
     */
    protected function setPlaceholders($default_xml)
    {
        $this->getExtension();

        $default_xml = str_replace('{name}', $this->extension->name, $default_xml);
        $default_xml = str_replace('{alias}', $this->extension->alias, $default_xml);
        $default_xml = str_replace('{namespace}', $this->extension->namespace, $default_xml);

        $default_xml = str_replace(
            '{content_catalog_type_id}',
            $this->extension->content_catalog_type_id,
            $default_xml
        );

        $default_xml = str_replace(
            '{extension_catalog_type_id}',
            $this->extension->extension_catalog_type_id,
            $default_xml
        );

        return $this->setCustomfields($default_xml);
    }

    /**
     * Get extension
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function getExtension()
    {
        $this->extension = $this->extensions[$this->extension_key];

        return $this;
    }

    /**
     * Get extension
     *
     * @param   object $default_xml
     *
     * @return  object
     * @since   1.0.0
     */
    protected function setCustomfields($default_xml)
    {
        $contentfields = json_decode($this->extension->contentfields);

        $xml = '';

        if (count($contentfields) > 0) {
            foreach ($contentfields->field_keys as $key) {

                $fields = $contentfields->fields->$key;

                if (count($fields) > 0) {
                    $xml .= '<customfield name="' . strtolower(trim($key)) . '">' . chr(10);
                    foreach ($fields as $field) {
                        $xml .= '   <include field="' . strtolower(trim($field)) . '"/>' . chr(10);
                    }
                    $xml .= '</customfield>' . chr(10);
                }
            }
        }

        if ($xml === '') {
        } else {
            $xml = '<customfields>' . chr(10) . $xml . '</customfields>';
        }

        return str_replace('{customfields}', $xml, $default_xml);
    }
}
