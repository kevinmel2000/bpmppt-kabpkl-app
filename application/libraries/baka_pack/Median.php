<?php if (! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * CodeIgniter Baka Pack
 *
 * My very own Codeigniter Boilerplate Library that used on all of my projects
 *
 * NOTICE OF LICENSE
 *
 * Everyone is permitted to copy and distribute verbatim or modified 
 * copies of this license document, and changing it is allowed as long 
 * as the name is changed.
 *
 *            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE 
 *  TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION 
 *
 * 0. You just DO WHAT THE FUCK YOU WANT TO.
 *
 * @package     Baka_pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://www.wtfpl.net
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

/**
 * BAKA Median Class
 *
 * @subpackage  Libraries
 * @category    Media
 */
class Median
{
    /**
     * Codeigniter superobject
     *
     * @var  mixed
     */
    protected $_ci;

    protected $allowed_types = 'gif|jpg|jpeg|png';

    protected $post_max_size;

    protected $upload_max_size;

    protected $file_limit = 5;

    protected $destination;

    protected $encript_name = TRUE;

    protected $field_name = 'userfile';

    protected $_template = array(
        'drop-area-selector-text'       => 'Drop files here to upload',
        'drop-processing-selector-text' => 'Processing dropped files...',
        'upload-button-selector-text'   => 'Upload files',
        'file-type-not-allowed-text'    => 'Tipe berkas tidak diijinkan',
        'file-size-too-large-text'      => 'Ukuran berkas terlalu besar',
        'directory-not-writable-text'   => 'Uploads directory isn\'t writable',
        );

    protected $_data = array();

    /**
     * Default class constructor
     */
    public function __construct(array $configs = array())
    {
        $this->_ci =& get_instance();

        $this->allowed_types    = get_conf('allowed_types');
        $this->post_max_size    = return_bytes(ini_get('post_max_size'));
        $this->upload_max_size  = return_bytes(ini_get('upload_max_filesize'));
        $this->destination      = get_conf('upload_path');

        if (!empty($configs))
        {
            $this->init($configs);
        }

        if ($this->_ci->input->get('do-upload'))
        {
            return $this->do_upload();
        }

        log_message('debug', "#Baka_pack: Media Class Initialized");
    }

    /**
     * Initialize method
     *
     * @param   array   $configs  Configuration Overwrite
     * @return  void
     */
    public function init($configs)
    {
        foreach ($configs as $key => $val)
        {
            if (isset($this->$key))
            {
                $this->$key = $val;
            }
        }

        return $this;
    }

    public function get_html()
    {
        $attr  = 'data-allowed-ext="'.$this->allowed_types.'" ';
        $attr .= 'data-item-limit="'.$this->file_limit.'" ';
        $attr .= 'data-size-limit="'.$this->post_max_size.'" ';

        return '<div class="fine-uploader row" '.$attr.'></div>';
    }

    public function template()
    {
        Asssets::set_script('jq-fineuploader', 'lib/jquery.fineuploader.min.js', 'bootstrap', '4.4.0');

        $script = "$('.fine-uploader').each(function() {\n"
                . "    var fu = $(this),\n"
                . "        fuLimit = fu.data('item-limit'),\n"
                . "        fuTypes = fu.data('allowed-ext')\n\n"
                . "    fu.fineUploader({\n"
                . "        template: 'qq-template',\n"
                . "        request: {\n"
                . "            endpoint: '".base_url('ajaks/upload')."?limit='+fuLimit+'&types='+fuTypes,\n"
                . "            inputName: '".$this->field_name."'\n"
                . "        },\n"
                . "        validation: {\n"
                . "            allowedExtensions: fuTypes.split('|'),\n"
                . "            itemLimit: fuLimit,\n"
                . "            sizeLimit: fu.data('size-limit')\n"
                . "        },\n"
                . "        retry: {\n"
                . "            enableAuto: true,\n"
                . "            showButton: true,\n"
                . "            maxAutoAttempts: 3\n"
                . "        },\n"
                . "        text: {\n"
                . "            failUpload: 'Upload gagal',\n"
                . "            formatProgress: '{percent}% dari {total_size}',\n"
                . "            paused: 'Tertunda',\n"
                . "            waitingForResponse: 'Dalam proses...',\n"
                . "        },\n"
                . "        messages: {\n"
                . "            emptyError: '{file} is empty, please select files again without it.',\n"
                . "            maxHeightImageError: 'Image is too tall.',\n"
                . "            maxWidthImageError: 'Image is too wide.',\n"
                . "            minHeightImageError: 'Image is not tall enough.',\n"
                . "            minWidthImageError: 'Image is not wide enough.',\n"
                . "            minSizeError: '{file} is too small, minimum file size is {minSizeLimit}.',\n"
                . "            noFilesError: 'No files to upload.',\n"
                . "            onLeave: 'The files are being uploaded, if you leave now the upload will be canceled.',\n"
                . "            retryFailTooManyItemsError: 'Retry failed - you have reached your file limit.',\n"
                . "            sizeError: '{file} terlalu besar, ukuran maksimum adalah {sizeLimit}.',\n"
                . "            tooManyItemsError: 'Too many items ({netItems}) would be uploaded. Item limit is {itemLimit}.',\n"
                . "            typeError: '{file} has an invalid extension. Valid extension(s): {extensions}.'\n"
                . "        }\n"
                . "    });\n"
                . "});";

        Asssets::set_script('jq-fineuploader-trigger', $script, 'jq-fineuploader');

        $out = '<script type="text/template" id="qq-template">'
             . '<div class="col-md-12"><div class="qq-upload-selector">'
             . '    <div class="qq-upload-drop-area-selector" qq-hide-dropzone>'
             . '        <span>'.$this->_template['drop-area-selector-text'].'</span>'
             . '    </div>'
             . '    <div class="qq-upload-button-selector btn btn-default">'
             . '        <span>'.$this->_template['upload-button-selector-text'].'</span>'
             . '    </div>'
             . '    <span class="qq-drop-processing-selector qq-hide">'
             . '        <span class="qq-drop-processing-spinner-selector"></span>'
             . '        <span>'.$this->_template['drop-processing-selector-text'].'</span>'
             . '    </span>'
             . '    <ul class="qq-upload-list-selector row">'
             . '        <li class="col-md-12">'
             . '            <span class="qq-upload-spinner-selector"></span>'
             . '            <span class="qq-upload-file-selector"></span>'
             // . '            <span class="qq-edit-filename-icon-selector"></span>'
             // . '            <input class="qq-edit-filename-selector" tabindex="0" type="text">'
             . '            <span class="qq-upload-size-selector"></span>'
             . '            <span class="qq-upload-status-text-selector"></span>'
             // . '            <div class="upload-action-buttons btn-group">'
             // . '                <button type="button" class="btn btn-default qq-upload-cancel-selector"><i class="fa fa-ban"></i></button>'
             // . '                <button type="button" class="btn btn-default qq-upload-retry-selector"><i class="fa fa-refresh"></i></button>'
             // . '                <button type="button" class="btn btn-default qq-upload-delete-selector"><i class="fa fa-trash-o"></i></button>'
             // . '            </div>'
             . '            <div class="qq-progress-bar-container-selector">'
             . '                <div class="qq-progress-bar-selector"></div>'
             . '            </div>'
             . '        </li>'
             . '    </ul>'
             . '</div></div>'
             . '</script>';

        return $out;
    }

    /**
     * Get uploaded datas
     *
     * @return  array
     */
    public function uploaded_data()
    {
        return $this->_data;
    }

    public function upload_policy()
    {
        $_types         = explode('|', $this->allowed_types);
        $_c_types       = count($_types);
        $_file_types    = '';

        for ($i = 0; $i < $_c_types; $i++)
        {
            $_file_types .= '<i class="bold">.'.strtoupper($_types[$i]).'</i>';
            $_file_types .= ($i == ($_c_types-2) ? ' dan ' : '; ');
        }

        return '. Batas jumlah upload adalah: <i class="bold">'.$this->file_limit.'</i> berkas dan hanya berkas dengan extensi: '.$_file_types.' yang diijinkan.';
    }

    public function do_upload()
    {
        if (isset($_FILES[$this->field_name]))
        {
            $this->_ci->load->library('upload', array(
                'upload_path'   => $this->destination,
                'allowed_types' => $this->allowed_types,
                'encrypt_name'  => $this->encript_name,
                'max_size'      => $this->upload_max_size,
                ));

            if ($this->_ci->upload->do_upload($this->field_name))
            {
                return $this->_ci->upload->data();
            }
            else
            {
                Messg::set('error', $this->_ci->upload->display_errors());
                return FALSE;
            }
        }
        else
        {
            Messg::set('error', $_FILES[$this->field_name]);
            return FALSE;
        }
    }
}

/* End of file Median.php */
/* Location: ./application/libraries/Baka_pack/Median.php */
