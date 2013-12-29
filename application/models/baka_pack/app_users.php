<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

class App_users extends CI_Model
{

    /**
     * Default class constructor
     */
    public function __construct()
    {
        parent::__construct();

        log_message('debug', "#Baka_pack: User Application model Class Initialized");
    }

    public function create_user( $user_data, $use_username )
    {
        $email_activation =  get_app_config('email_activation');

        if ( $data = $this->authen->create_user(
            $use_username ? $user_data['username'] : '',
            $user_data['email'],
            $user_data['password'],
            $email_activation ) )
        {
            // success
            $this->load->library('baka_pack/baka_email');

            if ( $email_activation )
            {
                // send "activate" email
                $data['activation_period'] = Setting::get('auth_email_activation_expire') / 3600;

                $this->baka_email->send('activate', $user_data['email'], $data);

                $this->baka_lib->set_message('email_activation_sent');
            }
            else if ( get_app_config('email_account_details'))
            {
                // send "welcome" email
                $this->baka_email->send('welcome', $user_data['email'], $data);

                $this->baka_lib->set_message('email_welcome_sent');
            }

            // Clear password (just for any case)
            unset($data['password']); 

            $this->baka_lib->set_message('auth_registration_success');

            return $data;
        }
        else
        {
            $this->baka_lib->set_error('auth_registration_failed');

            return FALSE;
        }
    }

    public function update_user( $user_id, $user_data )
    {
        return false;
    }
}