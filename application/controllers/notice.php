<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Notice Controller
 *
 * @subpackage  Controller
 */
class Notice extends BI_Controller
{
    public function index( $page = '' )
    {
        $this->lang->load('binotice');

        $page = str_replace('-', '_', $page);
        $this->data['heading'] = $this->bitheme->set_title(_x('notice_'.$page.'_title'));
        $this->data['message'] = _x('notice_'.$page.'_message');

        $this->load->theme('errors/general', $this->data, 'notice');
    }
}

/* End of file error.php */
/* Location: ./application/controllers/error.php */
