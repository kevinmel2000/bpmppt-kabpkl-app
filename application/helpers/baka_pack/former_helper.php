<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

function set_toolbar( $tool_buttons, $page_link )
{
	if ( count($tool_buttons) == 0 )
		return FALSE;

	$btn_class	= 'btn btn-sm '; 
	$output		= '<div class="btn-toolbar">';

	foreach ( $tool_buttons as $url => $label )
	{
		$output	.= '<div class="btn-group">';
		
		if ( is_array($label) )
		{
			$s_btn		= explode('|', $url);
			$dropdown	= ( strpos($s_btn[0], ':dd') !== FALSE ? TRUE : FALSE );

			if ( $dropdown )
			{
				$output .= '<button type="button" class="'.$btn_class.( isset($s_btn[1]) ? 'btn-'.$s_btn[1] : '' ).' dropdown-toggle" data-toggle="dropdown">'.str_replace(':dd', '', $s_btn[0]).' <span class="caret"></span></button>';
				$output .= '<ul class="dropdown-menu" role="menu">';
			}

			foreach ( $label as $l_url => $l_label )
			{
				$l_attr = '';

				if ( strpos($l_label, '&') !== FALSE )
				{
					$l_tmp = explode('&', $l_label);

					$l_label = $l_tmp[0];

					$l_attr = _parse_data_attr( $l_tmp[1] );
				}

				$item_id = 'toolbar-btn-'.str_replace(' ', '-', strtolower($l_label));
				$item = anchor( $page_link.$l_url, $l_label,
					'id="'.$item_id.'" class="'.( $dropdown ? '' : $btn_class.( isset($s_btn[1]) ? 'btn-'.$s_btn[1] : '' ) ).'" '.$l_attr );
				
				$output	.= ( $dropdown ? '<li>'.$item.'</li>' : $item );
			}

			if ( $dropdown )
				$output .= '</ul>';
		}
		else
		{
			$button	 = explode('|', $label);
			$output	.= anchor( $page_link.$url, $button[0], 'id="toolbar-btn-'.str_replace(' ', '-', strtolower($button[0])).'" class="'.$btn_class.( isset($button[1]) ? 'btn-'.$button[1] : '' ).'"' );
		}

		$output	.= '</div>';
	}
	
	$output	.= '</div>';

	return $output;
}

function _parse_data_attr( $string )
{
	$output = '';

	if ( strpos($string, ',') !== FALSE )
	{
		foreach ( explode(',', $string) as $data )
		{
			$output .= _parse_data_attr( $data );
		}
	}
	else
	{
		$output .= ' data-'.$string;
	}

	return $output;
}

function form_search( $target )
{
	$output  = form_open( $target, array('name'=>'search-bar', 'method'=>'get'));
	$output .= '<div class="input-group input-group-sm">';
	$output .= form_input(array('name'=>'search', 'id'=>'search', 'value'=>set_value('search'), 'class'=>'form-control', 'type'=>'search'));
	$output .= '<span class="input-group-btn">'.form_submit(array('id'=>'s','class'=>'btn btn-default', 'value'=>'Cari')).'</span>';
	$output .= '</div><!-- /input-group -->';
	$output .= form_close();

	return $output;
}

function form_alert()
{
	$ci =& get_instance();

	$messages	= array();
	$class		= 'warning';

	if ( $messages	= $ci->session->flashdata('message') )
	{
		$class = 'warning';
	}
	else if ( $messages	= $ci->session->flashdata('success') )
	{
		$class = 'success';
	}
	else if ( $messages	= $ci->session->flashdata('info') )
	{
		$class = 'info';
	}
	else if ( $messages	= $ci->session->flashdata('error') )
	{
		$class = 'danger';
	}

	$output = '';

	$dismiss = '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>';

	if ( is_array( $messages ) AND count( $messages ) > 0 )
	{
		$output .= '<div class="alert alert-'.$class.'">'.$dismiss.'<ul>';
		
		foreach ( $messages as $message )
		{
			$output .= '<li>'.$message.'</li>';
		}

		$output .= '</ul></div>';
	}
	else if ( is_string( $messages ) AND strlen( $messages ) > 0 )
	{
		$output = '<div class="alert alert-'.$class.'">'.$dismiss.'<p>'.$messages.'</p></div>';
	}

	return $output;
}

function form_persyaratan( $caption, $persyaratan = array(), $syarats = '' )
{
	$values = $syarats != '' ? unserialize($syarats) : array();

	if (is_array($persyaratan) && count($persyaratan) > 0)
	{
		$output  = form_fieldset($caption);
		$output .= "<div id=\"control_input_syarat_pengajuan\" class=\"control-group\">\n\t";
		$output .= form_hidden( 'total_syarat', count($persyaratan));
		$output .= form_label( 'Persyaratan', 'input_syarat_pengajuan', array('class'=>'control-label'));
		$output .= "\n\t<div class=\"controls\">";

		foreach ($persyaratan as $id => $syarat)
		{
			$output .= form_label( form_checkbox(array('name'=>'surat_syarat[]','id'=>'input_syarat_'.$id,'value'=>$id,'checked'=>in_array($id, $values))).' '.$syarat, 'input_syarat_'.$id, array('class'=>'checkbox'));
		}

		$output .= "\n\t</div>\n</div>";
		$output .= form_fieldset_close();

		return $output;
	}
}

function form_uploader( $label = 'Unggah berkas', $endpoint = 'ajax_request/fine_uploader/berkas', $allowed_type = '' )
{
	$CI =& get_instance();

	$endpoint	= site_url( $endpoint );
	$sizeLimit	= return_bytes( ini_get('upload_max_filesize') );
	$allowed	= !empty($allowed_type) ? $allowed_type : baka_get_ajax_conf('allowed_types');

	$content = '<i class="fontAwesome-upload"></i> '.$label;
	$progress= '<div class="progress progress-striped active"><div class="bar"></div></div>';

	$script  = "var fub = $('#fine-uploader'),"
			 . "messages = $('#upload-response'),"
			 . "progress_bar = '".$progress."',"
			 . "uploader = new qq.FineUploaderBasic({"
			 . "	button: fub[0],"
			 . "	request: { endpoint: '".$endpoint."' },"
			 . "	validation: { allowedExtensions: ".$sizeLimit.", sizeLimit: ".$allowed." },"
			 . "	callbacks: {"
			 . "		onSubmit: function(id, fileName) {"
			 . "			$('#no-data').remove();"
			 . "			messages.append('<tr id=\"file-'+id+'\"></tr>');"
			 . "		},"
			 . "		onUpload: function(id, fileName) {"
			 . "			$('#file-'+id).html('<td><span>Memeriksa...</span></td>'+'<td>'+progress_bar.css('width:0%')+'</td>');"
			 . "		},"
			 . "		onProgress: function(id, fileName, loaded, total) {"
			 . "			if (loaded < total) {"
			 . "				bar = Math.round(loaded / total * 100);"
			 . "				progress = bar+'% of '+Math.round(total / 1024)+' kB';"
			 . "				$('#file-'+id).html('<td><span>Mengunggah '+progress+'</span></td><td>'+progress_bar.css('width:'+bar+'')+'</td>');"
			 . "			} else {"
			 . "				$('#file-'+id).html('<td><span>Menyimpan '+fileName+'</span></td><td>'+progress_bar.css('width:100%')+'</td>');"
			 . "			}"
			 . "		},"
			 . "		onComplete: function(id, fileName, responseJSON) {"
			 . "			if (responseJSON.success) {"
			 . "				$('#file-'+id).addClass('success')"
			 . "					.html('<td><a href=\"'+responseJSON.error.url_berkas+'/'+responseJSON.error.nama_berkas+'\" rel=\"fancy\">'+fileName+'</a>'+"
			 . "					'<input type=\"hidden\" name=\"lampiran[]\" value=\"'+responseJSON.error.nama_berkas+'\"></td>'+"
			 . "					'<td><span class=\"muted\">Ukuran:</span> '+Math.round(responseJSON.error.ukuran_berkas / 1024)+"
			 . "					'<span class=\"muted\">KB, Type:</span> '+responseJSON.error.mime_berkas+'</td>');"
			 . "				$('#file-'+id).removeClass('success');"
			 . "			} else {"
			 . "				$('#file-'+id).addClass('error').html('<td>'+fileName+'</td><td><i class=\"icon-exclamation-sign\"></i> Error: '+responseJSON.error+'</div></td>');"
			 . "			}"
			 . "		}"
			 . "	}"
			 . "});";

	$output  = "<span id='fine-uploader' class='btn btn-primary' >".$content."</span>"
			 . "<table class='table table-striped table-hover table-bordered'>"
			 . "	<thead>"
			 . "		<tr><th width='50%'>Nama</th><th width='50%'>Status</th></tr>"
			 . "	</thead>"
			 . "	<tbody id='upload-response'>"
			 . "		<tr id='no-data'><td colspan='2'>Belum ada data dilampirkan.</td></tr>"
			 . "	</tbody>"
			 . "</table>";

	$version = '3.5.0';

	Baka_theme::add_style('fine-uploader', 'assets/vendors/jquery.fineuploader/fineuploader-'.$version.'.css', 'foot');
	Asssets::set_script('fine-uploader', 'assets/vendors/jquery.fineuploader/jquery.fineuploader-'.$version.'.min.js', 'foot');
	Asssets::set_script('form-upload', $script, 'foot');

	return $output;
}

/* End of file former_helper.php */
/* Location: ./application/helpers/baka_pack/former_helper.php */