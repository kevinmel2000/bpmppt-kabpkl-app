<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
 * Ajaks Class
 *
 * @subpackage  Controller
 */
class Ajaks extends BAKA_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->verify_login();
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