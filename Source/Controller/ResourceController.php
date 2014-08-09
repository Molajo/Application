<?php
/**
 * Resource Controller
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Controller;

use CommonApi\Controller\ResourceInterface;
use Molajo\Controller\Resource\MenuitemPageType;

/**
 * Resource Controller
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class ResourceController extends MenuitemPageType implements ResourceInterface
{
    /**
     * Get Resource Data for Route
     *
     * @return  object
     * @since   1.0
     */
    public function getResource()
    {
        if ($this->page_type === 'Dashboard') {
            return $this->resource;
        }

        if ($this->page_type === 'Item' || $this->page_type === 'Edit' || $this->page_type === 'Delete') {
            $this->getResourceItem();

        } elseif ($this->page_type === 'List') {
            $this->getResourceList();

        } else {
            $this->getResourceMenu();
        }

        return $this->resource;
    }
}
