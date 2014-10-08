<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BootIgniter Pack
 * @subpackage  Notice
 * @category    Controller
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://github.com/feryardiant/bootigniter/blob/master/LICENSE
 * @since       Version 0.1.5
 */

// -----------------------------------------------------------------------------

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
