<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function set_toolbar( $tool_buttons )
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
				$output	.= ( $dropdown ? '<li>' : '' ).anchor( $l_url, $l_label, 'class="'.( $dropdown ? '' : $btn_class.( isset($s_btn[1]) ? 'btn-'.$s_btn[1] : '' ) ).'"' ).( $dropdown ? '</li>' : '' );
			}

			if ( $dropdown )
				$output .= '</ul>';
		}
		else
		{
			$button	 = explode('|', $label);
			$output	.= anchor( $url, $button[0], 'class="'.$btn_class.( isset($button[1]) ? 'btn-'.$button[1] : '' ).'"' );
		}

		$output	.= '</div>';
	}
	
	$output	.= '</div>';

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

function form_alert( $message = '' )
{
	$return = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><ul>'.$message.'</ul></div>';

	return !empty( $message ) ? $return : '' ;
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

function form_datepicker($data = '', $value = '', $extra = '')
{
	Baka_theme::add_style('datepicker-css', 'assets/vendors/bootstrap-datepicker/css/datepicker.css');
	Baka_theme::add_script('datepicker-js', 'assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js', 'foot');

	if (!is_array($data))
	{
		$data	= array('name' => $data);
		$value	= format_date($value);
	}
	else
	{
		$data['value'] = format_date($data['value']);
	}

	if (!array_key_exists('data-provide', $data))
	{
		$data['data-provide'] = 'datepicker';
	}

	Baka_theme::add_script('datepicker-script', "$('[data-provide=\"datepicker\"]').datepicker({
		autoclose: true,
		todayHighlight: true,
		format: 'dd-mm-yyyy',
		language: 'id',
		mask: '99-99-9999'
	})\n", 'foot');

	return form_input($data, $value, $extra);
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
	Baka_theme::add_script('fine-uploader', 'assets/vendors/jquery.fineuploader/jquery.fineuploader-'.$version.'.min.js', 'foot');
	Baka_theme::add_script('form-upload', $script, 'foot');

	return $output;
}

/* End of file apps_form_helper.php */
/* Location: ./application/helpers/baka_core/apps_form_helper.php */