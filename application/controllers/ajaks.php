<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://creasico.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/creasico/bpmppt/blob/master/LICENSE)
 * @subpackage  Ajaks
 * @category    Controller
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

    public function download()
    {
        if (!$this->load->is_loaded('biupdate'))
        {
            $this->load->library('biupdate');
        }

        $url = 'https://github.com/creasico/bpmppt/zipball/4ebea4095a67fd2503984b7d490b80cd5bae8075';
        echo $this->biupdate->download($url) ? 'Sukses' : 'Error';
    }
}

/* End of file ajaks.php */
/* Location: ./application/controllers/ajaks.php */
