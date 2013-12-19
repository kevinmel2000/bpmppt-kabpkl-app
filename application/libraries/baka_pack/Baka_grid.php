<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Baka Pack
 *
 * My very own Codeigniter core library that used on all of my projects
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
 * @license     http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @since       Version 0.1
 */

// -----------------------------------------------------------------------------

/**
 * BAKA Grid Utility Class
 *
 * @package		Baka_pack
 * @subpackage	Libraries
 * @category	Grid
 * @author		Fery Wardiyanto (http://github.com/feryardiant/)
 */
class Baka_grid Extends Baka_lib
{
	private $limit;
	private $offset		= 0;
	private $segment	= 5;
	private $page_link;
	private $action_buttons = array();

	private $db_table	= array();
	private $db_result_count;
	private $db_result;
	private $db_query;
	private $db_num_rows;

	private $table_cols	= array();
	private $table_id	= 'id';

	public function __construct( $db_query = NULL )
	{
		$this->offset	= $this->uri->segment( $this->segment );
		$this->limit	= get_app_setting('app_data_show_limit');

		if ( ! is_null($db_query) )
		{
			$this->initialize( $db_query );
		}

		log_message('debug', "#Baka_pack: Grid Library Class Initialized");
	}

	/**	--------------------------------------------------------------------------------
	 *	Extending Native CI Active Record Class
	 **	-------------------------------------------------------------------------------- */

	public function get( $table = '' )
	{
		if (!empty($this->db_select) )
		{
			$this->db->select( implode(',', $this->db_select) );
			// $this->db->from( $this->db_table );
		}

		if (!empty($this->db_joins) )
		{
			foreach ($this->db_joins as $join)
			{
				$this->db->join($join[0], $join[1], $join[2]);
			}
		}

		if (!empty($this->db_wheres) )
		{
			foreach ($this->db_wheres as $where)
			{
				list( $w_key, $w_val ) = $where;

				$this->db->where( $w_key, $w_val );
			}
		}

		if (!empty($this->db_groups) )
		{
			$this->db->group_by( $this->db_groups );
		}

		$db_table = ( $table != '' ? $table : $this->db_table );

		$this->count = $this->db->get( $db_table )->num_rows();
		// $this->db->free_result();
		$this->query = $this->db->get( $db_table, $this->limit, $this->offset );

		return $this;
	}

	/**	--------------------------------------------------------------------------------
	 *	Grid Builder
	 **	-------------------------------------------------------------------------------- */

	public function initialize( $db_query )
	{
		$this->db_query = $db_query;

		return $this;
	}

	public function identifier( $identifier )
	{
		$this->table_id = $identifier;

		return $this;
	}

	public function set_baseurl( $page_link )
	{
		$this->page_link = $page_link;

		return $this;
	}

	public function set_column( $head_data, $field_data, $width_data = '', $sortble = FALSE, $replacement = FALSE )
	{
		if ( is_array($head_data) )
		{
			foreach ( $head_data as $data )
			{
				extract( $data );

				$this->set_column( $heading, $field, $width, $sortable, $format );
			}
		}
		else
		{
			$head_data = ( $sortble ? anchor( $this->page_link.'sort:'.$field_data.'~asc', $head_data) : $head_data );

			$this->table_cols[] = array(
				'heading'	=> $head_data,
				'field'		=> $field_data,
				'width'		=> $width_data,
				'format'	=> $replacement );
		}

		return $this;
	}

	public function set_buttons( $page_link, $icon_class = '', $btn_class = '', $btn_title = '' )
	{
		if ( is_array($page_link) )
		{
			foreach ( $page_link as $data )
			{
				extract( $data );

				$this->set_buttons( $link, $icon, $class, $title );
			}
		}
		else
		{
			$this->action_buttons[] = array(
				'link'	=> $page_link,
				'icon'	=> $icon_class,
				'class'	=> $btn_class,
				'title'	=> $btn_title );
		}

		return $this;
	}

	private function _act_btn( $data_id )
	{
		$output = '';

		if ( count($this->action_buttons) > 0 )
		{
			$output .= '<div class="btn-group btn-group-justified">';

			foreach ( $this->action_buttons as $btn_key => $btn_val )
			{
				extract($btn_val);

				$output .= anchor(
					$this->page_link.$link.$data_id,
					'<span class="glyphicon glyphicon-'.$icon.'"></span>',
					'title="'.$title.'" data-toggle="tooltip" class="btn btn-sm btn-'.$class.'"');
			}

			$output .= '</div>';
		}

		return $output;
	}

	public function set_segment( $segment = 0 )
	{
		$this->segment	= $segment;
		$this->offset	= $this->uri->segment( $this->segment );

		return $this;
	}

	private function count_results()
	{
		return $this->db_result_count;
	}

	private function table_footer()
	{
		$output = '<div class="panel-footer clearfix">';

		/**
		 * Set text info
		 */
		if ( (int) $this->db_result_count > 0 )
		{
			if ( $this->db_result_count >= $this->limit )
				$text_info = 'Menampilkan '.$this->db_num_rows.' data dari total '.$this->db_result_count.' data keseluruhan';
			else
				$text_info = 'Menampilkan '.$this->db_result_count.' dari keseluruhan data';
		}
		else
			$text_info = 'Belum ada data';

		$output .= twb_text( $text_info, 'muted info' );

		/**
		 * Setup pagination using native CI pagination library
		 */
		if ( !$this->load->is_loaded('pagination') )
			$this->load->library('pagination');

		$configs = array(
			'base_url'			=> site_url( $this->page_link . '/page/' ),
			'total_rows'		=> $this->count_results(),
			'uri_segment'		=> $this->segment,
			'per_page'			=> $this->limit,
			'full_tag_open'		=> '<ul class="pagination pagination-sm pull-right">',
			'first_link'		=> '&larr; Awal',
			'first_tag_open'	=> '<li class="first">',
			'first_tag_close'	=> '</li>',
			'prev_link'			=> '&laquo;',
			'prev_tag_open'		=> '<li class="prev">',
			'prev_tag_close'	=> '</li>',
			'cur_tag_open'		=> '<li class="active"><span>',
			'cur_tag_close'		=> '</span></li>',
			'num_tag_open'		=> '<li class="number">',
			'num_tag_close'		=> '</li>',
			'next_link'			=> '&raquo;',
			'next_tag_open'		=> '<li class="next">',
			'next_tag_close'	=> '</li>',
			'last_link'			=> 'Akhir &rarr;',
			'last_tag_open'		=> '<li class="last">',
			'last_tag_close'	=> '</li>',
			'full_tag_close'	=> '</ul>',
			);

		$this->pagination->initialize( $configs ); 

		$output .= $this->pagination->create_links();

		$output .= '</div>';

		return $output;
	}

	private function filter_callback( $field, $row )
	{
		if ( strpos($field, 'callback_') !== FALSE )
		{
			// Mastiin kalo field ini butuh callback
			$field	= str_replace('callback_', '', $field);

			// Misahin antara nama function dan param
			$func	= explode(':', $field);

			// Misahin param, kalo memang ada lebih dari 1 
			$params	= strpos($func[1], '|') !== FALSE ? explode('|', $func[1]) : array($func[1]);

			// Manggil nilai dari $row berdasarkan field dari $param
			foreach ( $params as $param )
			{
				$args[] = isset($row->$param) ? $row->$param : $param ;
			}

			// Mastiin kalo function yg dimaksud ada dan bisa dipanggil
			$output	= (function_exists($func[0]) and is_callable($func[0]))
				? call_user_func_array($func[0], $args)
				: '' ;
		}
		else
		{
			$output = $row->$field;
		}

		return $output;
	}

	public function make_table( $query = FALSE )
	{
		$db_query = $query
			? $query
			: $this->db_query;

		if ( is_array( $db_query ) )
			array_to_object( $db_query );

		if ( method_exists($db_query, 'get') )
		{
			$db_kueri = clone $db_query;
			$this->db_result_count = $db_kueri->get()->num_rows();

			$get_query			= $db_query->limit($this->limit, $this->offset)->get();
			$this->db_result	= $get_query->result();
			$this->db_num_rows	= $get_query->num_rows();

		}
		else if ( method_exists($db_query, 'result') )
		{
			$this->db_result		= $db_query->result();
			$this->db_result_count	= $db_query->num_rows();
			$this->db_num_rows		= $this->db_result_count;
		}
		else
		{
			$this->db_result		= $db_query;
			$this->db_result_count	= count($db_query);
			$this->db_num_rows		= $this->db_result_count;
		}

		if ( !$this->load->is_loaded('table') )
			$this->load->library('table');

		$this->table->set_template( array(
			'table_open' => '<table class="table table-striped table-hover table-condensed">' ) );

		foreach ( $this->table_cols as $head_key => $head_val )
		{
			$heading[] = array(
				'data'	=> $head_val['heading'],
				'class'	=> 'heading-'.str_replace(' ', '-', strtolower($head_val['heading'])),
				'width'	=> $head_val['width'] );
		}

		if ( count($this->action_buttons) > 0 )
		{
			$heading[]	= array(
				'data'	=> 'Aksi',
				'class'	=> 'heading-action',
				'width'	=> '15%' );
		}

		$this->table->set_heading( $heading );

		if ( $this->db_num_rows > 0 )
		{
			foreach ( $this->db_result as $row )
			{
				$table_id = $row->{$this->table_id};

				foreach ( $this->table_cols as $cell_key => $cell_val )
				{
					extract( $cell_val );

					// Ganti format tampilan
					if ( $format !== FALSE )
					{
						$fields = array();

						/**
						 * @todo  Antisipasi error kalo field tidak ada atau penulisan field salah.
						 */
						if ( strpos($field, ',') !== FALSE )
						{
							foreach ( array_map('trim', explode(",", $field)) as $col )
							{
								$fields[] = $this->filter_callback($col, $row);
								$row_class = $col;
							}
						}
						else
						{
							$fields = array($this->filter_callback($field, $row));
							$row_class = $field;
						}

						$row_field = vsprintf( $format, $fields );
					}
					else
					{
						$row_field = $this->filter_callback($field, $row);
						$row_class = $field;
					}

					// Clean up class name
					if ( strpos($field, 'callback_') !== FALSE )
						$row_class = str_replace('callback_', '', $field);

					if ( strpos($field, ',') !== FALSE )
						list($row_class) = array_map('trim', explode(",", $field));

					// nerapin di cell
					$cell[$table_id][] = array(
						'data'	=> $row_field,
						'class'	=> 'field-'.str_replace('_', '-', $row_class),
						'width'	=> $width );
				}

				if ( count($this->action_buttons) > 0 )
				{
					$cell[$table_id][] = array(
						'data'	=> $this->_act_btn( $table_id ),
						'class'	=> 'data-action',
						'width'	=> '15%' );
				}

				$this->table->add_row( $cell[$table_id] );
			}
		}

		$output = $this->table->generate();

		$this->table->clear();

		$output .= $this->table_footer();

		$this->clear();

		return $output;
	}

	private function clear()
	{
		$this->db_table			= array();
		$this->db_result_count	= NULL;
		$this->db_result		= NULL;
		$this->db_query			= NULL;
		$this->db_num_rows		= NULL;

		$this->table_cols		= array();
		$this->action_buttons	= array();
	}

	private function _set_rows( $obj )
	{
		if ( is_array( $obj ) )
			array_to_object( $obj );

		if ( method_exists($obj, 'get') )
		{
			$db_kueri = clone $obj;
			$this->db_result_count = $db_kueri->count_all_results();

			var_dump( $db_kueri->get() );
			$get_query			= $obj->limit($this->limit, $this->offset)->get();
			$this->db_result	= $get_query->result();
			$this->db_num_rows	= $get_query->num_rows();

		}
		else if ( method_exists($obj, 'result') )
		{
			$this->db_result		= $obj->result();
			$this->db_result_count	= $obj->num_rows();
			$this->db_num_rows		= $this->db_result_count;
		}
		else
		{
			$this->db_result		= $obj;
			$this->db_result_count	= count($obj);
			$this->db_num_rows		= $this->db_result_count;
		}

		if ( count($this->table_cols) == 0 )
		{
			foreach ($this->db_result as $key => $val )
			{
				if ($key==0)
				{
					foreach ($val as $k => $v)
						$this->set_column( $k, $v );
				}
			}
		}
	}
}

/* End of file Baka_grid.php */
/* Location: ./system/application/libraries/Baka_pack/Baka_grid.php */