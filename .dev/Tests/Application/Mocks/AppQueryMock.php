<?php
/**
 * Query Class
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Query;

use CommonApi\Query\QueryInterface;
use stdClass;

/**
 * Query Class
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class AppQueryMock implements QueryInterface
{
    /**
     * Get SQL (optionally setting the SQL)
     *
     * @param   null|string $sql
     *
     * @return  string
     * @since   1.0.0
     */
    public function getSql($sql = null)
    {
        return 'SELECT `a`.`*`, `b`.`id` as `catalog_id`
          FROM `molajo_applications` `a`,
            `molajo_catalog` `b`
          WHERE `a`.`name` = "admin"
            AND `b`.`extension_instance_id` = 2000
            AND `b`.`source_id` = `a`.`id`
            AND `b`.`enabled` = 1
          ';
    }

    /**
     * Clear Query String
     *
     * @return  $this
     * @since   1.0.0
     */
    public function clearQuery()
    {

    }

    /**
     * Set Query Type - create, select (default), update, delete, exec
     *
     * @param   string $query_type
     *
     * @return  $this
     * @since   1.0.0
     */
    public function setType($query_type = 'select')
    {

    }

    /**
     * Retrieves the PHP date format compliant with the database driver
     *
     * @return  string
     * @since   1.0.0
     */
    public function getDateFormat()
    {

    }

    /**
     * Retrieves the current date and time formatted in a manner compliant with the database driver
     *
     * @return  string
     * @since   1.0.0
     */
    public function getDate()
    {

    }

    /**
     * Returns a value for null date that is compliant with the database driver
     *
     * @return  string
     * @since   1.0.0
     */
    public function getNullDate()
    {

    }

    /**
     * Set Distinct Indicator
     *
     * @param   boolean $distinct
     *
     * @return  $this
     * @since   1.0.0
     */
    public function setDistinct($distinct = false)
    {

    }

    /**
     * Used for select, insert, and update to specify column name, alias (optional)
     *  For Insert and Update, only, value and data_type
     *
     * @param   string      $column_name
     * @param   null|string $alias
     * @param   null|string $value
     * @param   null|string $data_type
     *
     * @return  $this
     * @since   1.0.0
     * @throws \CommonApi\Exception\RuntimeException
     */
    public function select($column_name, $alias = null, $value = null, $data_type = null)
    {

    }

    /**
     * Set From table name and optional value for alias
     *
     * @param   string      $table_name
     * @param   null|string $alias
     *
     * @return  $this
     * @since   1.0.0
     */
    public function from($table_name, $alias = null)
    {

    }

    /**
     * Create a grouping for conditions for 'and' or 'or' treatment between groups of conditions
     *
     * @param   string $group
     * @param   string $group_connector
     *
     * @return  $this
     * @since   1.0.0
     */
    public function whereGroup($group, $group_connector = 'and')
    {

    }

    /**
     * Set Where Conditions for Query
     *
     * @param   string      $left_filter
     * @param   string      $left
     * @param   string      $condition
     * @param   string      $right_filter
     * @param   string      $right
     * @param   string      $connector
     * @param   null|string $group
     *
     * @return  $this
     * @since   1.0.0
     */
    public function where(
        $left_filter = 'column',
        $left,
        $condition,
        $right_filter = 'column',
        $right,
        $connector = 'and',
        $group = null
    ) {

    }

    /**
     * Set Group By column name and optional value for alias
     *
     * @param   string $column_name
     *
     * @return $this
     * @since  1.0
     */
    public function groupBy($column_name)
    {

    }

    /**
     * Create a grouping for having statements for 'and' or 'or' treatment between groups of conditions
     *
     * @param   string $group
     * @param   string $group_connector
     *
     * @return  $this
     * @since   1.0.0
     */
    public function havingGroup($group, $group_connector = 'and')
    {

    }

    /**
     * Set Having Conditions for Query
     *
     * @param   string $left_filter
     * @param   string $left
     * @param   string $condition
     * @param   string $right_filter
     * @param   string $right
     * @param   string $connector
     *
     * @return  $this
     * @since   1.0.0
     */
    public function having(
        $left_filter = 'column',
        $left,
        $condition,
        $right_filter = 'column',
        $right,
        $connector = 'and'
    ) {

    }

    /**
     * Set Order By column name and optional value for alias
     *
     * @param   string      $column_name
     * @param   null|string $direction
     *
     * @return  $this
     * @since   1.0.0
     */
    public function orderBy($column_name, $direction = 'ASC')
    {

    }

    /**
     * Set Offset and Limit
     *
     * @param   int $offset
     * @param   int $limit
     *
     * @return  $this
     * @since   1.0.0
     */
    public function setOffsetAndLimit($offset = 0, $limit = 15)
    {

    }

    /**
     * Escape the value
     *
     * @param   string $value
     *
     * @return  string
     * @since   1.0.0
     */
    public function escape($value)
    {

    }

    /**
     * Escape the name value
     *
     * @param   string $name
     *
     * @return  string
     * @since   1.0.0
     */
    public function escapeName($name)
    {

    }

    /**
     * Return Object List
     *
     * @param   string $sql
     *
     * @return  array
     * @since   1.0.0
     */
    public function loadObjectList($sql)
    {
        $query_results = array();

        $row = new stdClass();

        $row->id          = 2;
        $row->name        = 'admin';
        $row->description = 'describing words';
        $row->metadata
                          = '
        {"title":"Molajo Administrator",
"description":"",
"keywords":"",
"robots":"follow,index",
"author":""}';

        $row->parameters
            = '{
        "application_home_catalog_id":"100",
        "application_default_theme_id":"9010"
        }';

        $row->catalog_id      = 5555;
        $row->catalog_type_id = 2000;

        $query_results[] = $row;

        return $query_results;
    }
}
