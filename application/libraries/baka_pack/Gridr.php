<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Baka Pack
 *
 * My very own Codeigniter Boilerplate Library that used on all of my projects
 * 
 * NOTICE OF LICENSE
 * 
 * Licensed under the Open Software License version 3.0
 * 
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 *
 * @package     Baka_pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0
 * @version     Version 0.1.4
 * @since       Version 0.1.0
 */

// -----------------------------------------------------------------------------

/**
 * BAKA Grid Utility Class
 *
 * @subpackage  Libraries
 * @category    Grid
 */
class Gridr
{
    /**
     * Codeigniter superobject
     *
     * @var  resources
     */
    protected $_ci;

    protected $limit;

    protected $offset     = 0;

    protected $segment    = 5;

    protected $page_link;

    protected $action_buttons = array();

    protected $db_table   = array();

    protected $db_result_count;

    protected $db_result;

    protected $db_query;

    protected $db_num_rows;

    protected $table_cols = array();

    protected $table_id   = 'id';

    /**
     * Default class constructor
     */
    public function __construct($db_query = NULL)
    {
        $this->_ci =& get_instance();

        $this->offset = $this->_ci->uri->segment($this->segment);
        $this->limit  = Setting::get('app_data_show_limit');

        if (!is_null($db_query))
        {
            $this->set_query($db_query);
        }

        log_message('debug', "#Baka_pack: Gridr Library Class Initialized");
    }

    /** --------------------------------------------------------------------------------
     *  Extending Native CI Active Record Class
     ** -------------------------------------------------------------------------------- */

    public function get($table = '')
    {
        if (!empty($this->db_select))
        {
            $this->_ci->db->select(implode(',', $this->db_select));
            // $this->_ci->db->from($this->db_table);
        }

        if (!empty($this->db_joins))
        {
            foreach ($this->db_joins as $join)
            {
                $this->_ci->db->join($join[0], $join[1], $join[2]);
            }
        }

        if (!empty($this->db_wheres))
        {
            foreach ($this->db_wheres as $where)
            {
                list($w_key, $w_val) = $where;

                $this->_ci->db->where($w_key, $w_val);
            }
        }

        if (!empty($this->db_groups))
        {
            $this->_ci->db->group_by($this->db_groups);
        }

        $db_table = ($table != '' ? $table : $this->db_table);

        $this->count = $this->_ci->db->get($db_table)->num_rows();
        // $this->_ci->db->free_result();
        $this->query = $this->_ci->db->get($db_table, $this->limit, $this->offset);

        return $this;
    }

    /** --------------------------------------------------------------------------------
     *  Grid Builder
     ** -------------------------------------------------------------------------------- */

    public function initialize($db_query)
    {
        $this->db_query = $db_query;

        return $this;
    }

    public function set_query($db_query)
    {
        $this->db_query = $db_query;

        return $this;
    }

    public function identifier($identifier)
    {
        $this->table_id = $identifier;

        return $this;
    }

    public function set_baseurl($page_link)
    {
        $this->page_link = $page_link;

        return $this;
    }

    public function set_column($head_data, $field_data, $width_data = '', $sortble = FALSE, $replacement = FALSE)
    {
        if (is_array($head_data))
        {
            foreach ($head_data as $data)
            {
                extract($data);

                $this->set_column($heading, $field, $width, $sortable, $format);
            }
        }
        else
        {
            $head_data = ($sortble ? anchor($this->page_link.'sort:'.$field_data.'~asc', $head_data) : $head_data);

            $this->table_cols[] = array(
                'heading'   => $head_data,
                'field'     => $field_data,
                'width'     => $width_data,
                'format'    => $replacement);
        }

        return $this;
    }

    public function set_buttons($page_link, $btn_title = '')
    {
        if (is_array($page_link))
        {
            foreach ($page_link as $link => $title)
            {
                $this->set_buttons($link, $title);
            }
        }
        else
        {
            $this->action_buttons[$page_link] = $btn_title;
        }

        return $this;
    }

    public function set_segment($segment = 0)
    {
        $this->segment  = $segment;
        $this->offset   = $this->uri->segment($this->segment);

        return $this;
    }

    protected function count_results()
    {
        return $this->db_result_count;
    }

    protected function filter_callback($field, $row)
    {
        if (strpos($field, 'callback_') !== FALSE)
        {
            // Mastiin kalo field ini butuh callback
            $field  = str_replace('callback_', '', $field);

            // Misahin antara nama function dan argument
            $func   = explode(':', $field);

            // Misahin param, kalo memang ada lebih dari 1 
            $params = strpos($func[1], '|') !== FALSE ? explode('|', $func[1]) : array($func[1]);

            // Manggil nilai dari $row berdasarkan field dari $param
            foreach ($params as $param)
            {
                $args[] = isset($row->$param) ? $row->$param : $param ;
            }

            if ($func[0] == 'anchor')
            {
                $args[0] = $this->page_link.$args[0];
            }

            // Mastiin kalo function yg dimaksud ada dan bisa dipanggil
            $output = (function_exists($func[0]) and is_callable($func[0]))
                ? call_user_func_array($func[0], $args)
                : '' ;
        }
        else
        {
            $output = $row->$field;
        }

        return $output;
    }

    public function generate($query = FALSE)
    {
        $db_query = $query ? $query : $this->db_query;

        if (is_array($db_query))
        {
            $db_query = array_to_object($db_query);
        }

        if (method_exists($db_query, 'get'))
        {
            $db_query_get = $db_query->get();

            // $get_query          = $db_query->limit($this->limit, $this->offset)->get();
            $this->db_result       = $db_query_get->result();
            $this->db_result_count = $db_query_get->num_rows();
            $this->db_num_rows     = $db_query_get->num_rows();

        }
        else if (method_exists($db_query, 'result'))
        {
            $this->db_result       = $db_query->result();
            $this->db_result_count = $db_query->num_rows();
            $this->db_num_rows     = $db_query->num_rows();
        }
        else
        {
            $this->db_result       = $db_query;
            $this->db_result_count = count($db_query);
            $this->db_num_rows     = count($db_query);
        }

        if (!$this->_ci->load->is_loaded('table'))
        {
            $this->_ci->load->library('table');
        }

        $this->_ci->table->set_template(array('table_open' => '<table class="table-dt table table-striped table-hover table-condensed">'));

        /**
         * Columns heading loop
         */
        foreach ($this->table_cols as $col_key => $col_val)
        {
            $heading[] = array(
                'data'  => $col_val['heading'],
                'class' => 'heading-'.str_replace(' ', '-', strtolower($col_val['heading'])),
                'width' => $col_val['width']);
        }

        /**
         * Columns action button
         */
        if (count($this->action_buttons) > 0)
        {
            $heading[]  = array(
                'data'  => 'Aksi',
                'class' => 'heading-action text-center',
                'width' => '5%');
        }

        /**
         * Setup Heading
         */
        $this->_ci->table->set_heading($heading);

        /**
         * If you have non zero rows
         */
        if ($this->db_num_rows > 0)
        {
            /**
             * Loop them
             */
            foreach ($this->db_result as $row)
            {
                $table_id = $row->{$this->table_id};

                foreach ($this->table_cols as $cell_key => $cell_val)
                {
                    // Ganti format tampilan
                    if ($cell_val['format'] !== FALSE)
                    {
                        $fields = array();

                        /**
                         * @todo  Antisipasi error kalo field tidak ada atau penulisan field salah.
                         */
                        if (strpos($cell_val['field'], ',') !== FALSE)
                        {
                            foreach (array_map('trim', explode(",", $cell_val['field'])) as $col)
                            {
                                $fields[]  = $this->filter_callback($col, $row);
                                $row_class = $col;
                            }
                        }
                        else
                        {
                            $fields = array($this->filter_callback($cell_val['field'], $row));
                            $row_class = $cell_val['field'];
                        }

                        $row_field = vsprintf($cell_val['format'], $fields);
                    }
                    else
                    {
                        $row_field = $this->filter_callback($cell_val['field'], $row);
                        $row_class = $cell_val['field'];
                    }

                    // Clean up class name
                    if (strpos($row_class, 'callback_') !== FALSE)
                    {
                        $row_class = str_replace('callback_', '', $row_class);
                    }

                    if (strpos($cell_val['field'], ',') !== FALSE)
                    {
                        list($row_class) = array_map('trim', explode(",", $cell_val['field']));
                    }

                    // nerapin di cell
                    $cell[$table_id][] = array(
                        'data'  => $row_field,
                        'class' => 'field-'.str_replace('_', '-', $row_class),
                        'width' => $cell_val['width']);
                }

                if (count($this->action_buttons) > 0)
                {
                    $actions = array();

                    foreach ($this->action_buttons as $link => $title)
                    {
                        if (substr($link, -1) != '/')
                        {
                            $link .= '/';
                        }

                        $actions[$link.$table_id] = $title;
                    }

                    $cell[$table_id][] = array(
                        // 'data'  => $this->_act_btn($table_id, $this->action_buttons),
                        'data'  => twbs_button_dropdown(
                            $actions,
                            $this->page_link,
                            array(
                                'group-class' => 'btn-justified',
                                'btn-type'    => 'default',
                                'btn-text'    => '<span class="glyphicon glyphicon-cog"></span>',
                                )
                            ),
                        'class' => 'field-action text-center',
                        'width' => '5%');
                }

                $this->_ci->table->add_row($cell[$table_id]);
            }
        }

        $output = $this->_ci->table->generate();

        $this->_ci->table->clear();

        // $output .= $this->table_footer();

        Asssets::set_script('datatable', 'lib/jquery.dataTables.min.js', 'jquery', '2.0.3');
        // Asssets::set_style('datatable', 'lib/jquery.dataTables.css');

        $script = "$('.table-dt').dataTable({"
                . "    'dom': '<\'dt-header\'lf>t<\'dt-footer\'ip>'"
                . "});";

        Asssets::set_script('datatable-trigger', $script, 'datatable');

        $this->clear();

        return $output;
    }

    /**
     * Clean up
     *
     * @since   forever
     * @return  void
     */
    protected function clear()
    {
        $this->db_table         = array();
        $this->db_result_count  = NULL;
        $this->db_result        = NULL;
        $this->db_query         = NULL;
        $this->db_num_rows      = NULL;

        $this->table_cols       = array();
        $this->action_buttons   = array();
    }
}

/* End of file Gridr.php */
/* Location: ./application/libraries/baka_pack/Gridr.php */