<?php
/**
 * Resourcedefaults Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Resourcedefaults;

use CommonApi\IoC\FactoryInterface;
use CommonApi\IoC\FactoryBatchInterface;
use Exception;
use Molajo\IoC\FactoryMethod\Base as FactoryMethodBase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;

/**
 * Resourcedefaults Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class ResourcedefaultsFactoryMethod extends FactoryMethodBase implements FactoryInterface, FactoryBatchInterface
{
    /**
     * Folder Name
     *
     * @var    string
     * @since  1.0.0
     */
    protected $folder_name = 'vendor/molajo/application/Source/Resource/Adapter/Xml';

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
    protected $extensions = array();

    /**
     * Constructor
     *
     * @param   $options
     *
     * @since   1.0.0
     */
    public function __construct(array $options = array())
    {
        $options['product_namespace'] = 'Molajo\\Resource\\Adapter\\Defaultxml';
        $options['product_name']      = basename(__DIR__);

        parent::__construct($options);
    }

    /**
     * Instantiate a new handler and inject it into the Adapter for the FactoryInterface
     *
     * @return  array
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function setDependencies(array $reflection = array())
    {
        $this->reflection = array();

        $this->extensions = $this->readFile($this->base_path . '/Bootstrap/Files/Model/Extensiondefaults.json');

        $this->default_xml = array();

        foreach (
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($this->base_path . '/' . $this->folder_name,
                    RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST) as $name => $item
        ) {
            if ($item->isDir()) {
            } else {
                $this->readXmlFile($name);
            }
        }

        return $this->dependencies;
    }

    /**
     * Instantiate Class
     *
     * @return  object
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function instantiateClass()
    {
        try {
            $this->product_result = new $this->product_namespace(
                $this->default_xml,
                $this->extensions
            );

        } catch (Exception $e) {

            throw new RuntimeException(
                'IoC Factory Method Adapter Instance Failed for ' . $this->product_namespace
                . ' failed.' . $e->getMessage()
            );
        }

        return $this->product_result;
    }

    /**
     * Read the XML file
     *
     * @param   string $file_name
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function readXmlFile($file_name)
    {
        $contents                      = file_get_contents($file_name);
        $this->default_xml[$file_name] = $contents;

        return $this;
    }
}
