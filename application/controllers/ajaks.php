<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
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
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

/**
 * Ajaks Class
 *
 * @subpackage  Controller
 */
class Ajaks extends BAKA_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->verify_login()
    }

    private function index()
    {
        return;
    }

    public function upload()
    {
        if (!$this->load->is_loaded('baka_pack/median'))
        {
            $this->load->library('baka_pack/median', array(
                'allowed_types' => $this->input->get('types'),
                'file_limit'    => $this->input->get('limit'),
                ));
        }

        // echo json_encode(array());
        if ($upload = $this->median->do_upload())
        {
            $out = array(
                'success' => true,
                'data'    => $upload,
                );
        }
        else
        {
            $out = array(
                'error' => Messg::get('error')
                );
        }

        echo json_encode($out);
    }
}

/* End of file ajaks.php */
/* Location: ./application/controllers/ajaks.php */