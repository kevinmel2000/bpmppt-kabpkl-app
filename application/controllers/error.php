<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Error Class
 *
 * @subpackage  Controller
 */
class Error extends BAKA_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->verify_login(uri_string());
    }

    public function index( $page = '' )
    {
        $this->notice( $page );
    }

    public function e404()
    {
        $this->data['heading'] = $this->themee->set_title('404 Halaman tidak ditemukan');
        $this->data['message'] = '';

        log_message('error', '404 Page Not Found --> '.current_url());

        $this->load->theme('errors/error_view', $this->data);
    }

    public function notice( $page = '' )
    {
        $page = str_replace('-', '_', $page);

        $this->set_panel_title( _x('notice_'.$page.'_title') );
        $this->set_panel_body( _x('notice_'.$page.'_message') );

        $this->load->theme('pages/notice', $this->data);
    }
}

/* End of file error.php */
/* Location: ./application/controllers/error.php */