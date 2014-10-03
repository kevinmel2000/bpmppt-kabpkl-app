<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BootIgniter Pack
 * @subpackage  Ajaks
 * @category    Controller
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://github.com/feryardiant/bootigniter/blob/master/LICENSE
 * @since       Version 0.1.5
 */

// -----------------------------------------------------------------------------

class Ajaks extends BI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->verify_login(uri_string());
    }

    private function index()
    {
        return;
    }

    public function upload()
    {
        $this->load->library('biupload', array(
            'allowed_types' => $this->input->get('types'),
            'file_limit'    => $this->input->get('limit'),
            ));

        // echo json_encode(array());
        if ( $upload = $this->biupload->do_upload() )
        {
            $out = array( 'success' => true, 'data' => $upload, );
        }
        else
        {
            $out = array( 'success' => false, 'message' => implode(', ', get_message('error')) );
        }

        echo json_encode($out);
    }
}

/* End of file ajaks.php */
/* Location: ./application/controllers/ajaks.php */
