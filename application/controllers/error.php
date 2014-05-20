<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * DON'T BE A DICK PUBLIC LICENSE <http://dbad-license.org>
 * 
 * Version 0.1.4, May 2014
 * Copyright (C) 2014 Fery Wardiyanto <ferywardiyanto@gmail.com>
 *  
 * Everyone is permitted to copy and distribute verbatim or modified copies of
 * this license document, and changing it is allowed as long as the name is
 * changed.
 * 
 * DON'T BE A DICK PUBLIC LICENSE
 * TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 * 
 * 1. Do whatever you like with the original work, just don't be a dick.
 * 
 *    Being a dick includes - but is not limited to - the following instances:
 * 
 *    1a. Outright copyright infringement - Don't just copy this and change the name.  
 *    1b. Selling the unmodified original with no work done what-so-ever,
 *        that's REALLY being a dick.  
 *    1c. Modifying the original work to contain hidden harmful content.
 *        That would make you a PROPER dick.  
 * 
 * 2. If you become rich through modifications, related works/services, or
 *    supporting the original work, share the love. Only a dick would make loads
 *    off this work and not buy the original work's creator(s) a pint.
 * 
 * 3. Code is provided with no warranty. Using somebody else's code and bitching
 *    when it goes wrong makes you a DONKEY dick. Fix the problem yourself.
 *    A non-dick would submit the fix back.
 *
 * @package     CodeIgniter Baka Pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

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

        $this->verify_login();
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
        switch( $page )
        {   
            // Registration
            case '404':
                $page_title     = '404 Halaman tidak ditemukan';
                $page_message   = 'The page you requested was not found.';
                break;

            // Registration
            case 'registration-success':
                $page_title     = 'Successful Registration';
                $page_message   = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim, at animi error porro alias nesciunt rem explicabo a vitae voluptas officiis sint delectus blanditiis repellat velit voluptatum natus dolor amet! ';
                break;
            case 'registration-disabled':
                $page_title     = 'Registration Disabled';
                $page_message   = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis, suscipit, dicta sint tempore accusantium unde assumenda autem fugiat adipisci molestiae sequi praesentium soluta consequatur facilis similique blanditiis non et perferendis. ';
                break;

            // Activation
            case 'activation-sent':
                $page_title     = 'Activation Email Sent';
                $page_message   = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, distinctio, accusamus, aut repellendus odio numquam est quos incidunt quaerat magni facere labore mollitia qui natus asperiores beatae quas sed ut. ';
                break;
            case 'activation-complete':
                $page_title     = 'Activation Complete';
                $page_message   = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus, voluptates, laboriosam, in, quae quos excepturi nobis non aperiam tempora labore reiciendis temporibus a rem eos explicabo? Distinctio voluptatibus voluptas recusandae. ';
                break;
            case 'activation-failed':
                $page_title     = 'Activation Failed';
                $page_message   = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi voluptatem facere repudiandae aliquam saepe. Quidem, omnis, cum excepturi autem alias iusto fugit ea similique ad sed necessitatibus veniam odit laboriosam. ';
                break;

            // Password
            case 'password-changed':
                $page_title     = 'Password Changed';
                $page_message   = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas, rem, expedita, error excepturi a quis velit sunt tempore omnis illum quisquam facilis. Veritatis, aspernatur, fugit voluptatibus eum alias est aliquam! ';
                break;
            case 'password-sent':
                $page_title     = 'New Password Sent';
                $page_message   = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae, repellat, quidem, accusantium cupiditate alias corrupti deleniti tempora aliquid impedit vel rem porro sapiente pariatur nesciunt doloribus dolores harum? Doloribus, magnam! ';
                break;
            case 'password-reset':
                $page_title     = 'Password Reset';
                $page_message   = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Earum, quidem, ad vel rerum dolorem alias consequatur dolorum quisquam voluptatibus officiis excepturi neque optio ea reiciendis temporibus nemo dignissimos voluptas unde. ';
                break;
            case 'password-failed':
                $page_title     = 'Password Failed';
                $page_message   = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis, accusamus, vitae, voluptates ea nostrum maxime tenetur dolores cupiditate perspiciatis perferendis nobis facere accusantium totam incidunt optio. Repudiandae id beatae praesentium. ';
                break;

            // Email
            case 'email-sent':
                $page_title     = 'Confirmation Email Sent';
                $page_message   = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo, voluptatum, voluptatibus mollitia ex blanditiis obcaecati debitis laudantium odio ipsam aut rem minima quod tenetur nostrum quisquam facilis voluptatem architecto fuga. ';
                break;
            case 'email-activated':
                $page_title     = 'Your Email has been Activated';
                $page_message   = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sint, minus dignissimos ipsa consequuntur praesentium dolor qui placeat doloremque reprehenderit voluptatum neque fuga facilis accusantium velit laborum eveniet asperiores quod id. ';
                break;
            case 'email-failed':
                $page_title     = 'Email Sending Failed';
                $page_message   = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui, vel, ratione, accusamus, ex similique iste dolores officiis recusandae omnis quas odit debitis quaerat sit magnam numquam consequuntur deserunt? Autem, repudiandae. ';
                break;

            // User + Account
            case 'user-banned':
                $page_title     = 'You have been Banned.';
                $page_message   = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio, similique vitae deleniti iure natus beatae dolorum minus officia maxime libero possimus praesentium quos atque aperiam recusandae unde velit culpa assumenda. ';
                break;
            case 'user-deleted':
                $page_title     = 'Your account has been Deleted.';
                $page_message   = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste, reprehenderit, commodi, mollitia nemo sequi esse consectetur vitae tenetur autem minus alias deleniti saepe et tempore cum sunt at dolorem iure! ';
                break;
            case 'acct-unapproved':
                $page_title     = 'Account not yet Approved';
                $page_message   = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, sit quo laborum perspiciatis magnam placeat fugiat sed eligendi ipsa dolorem. Quo, in minus sint delectus necessitatibus alias nesciunt incidunt natus? ';
                break;
            case 'logout-success':
                $page_title     = 'Logged Out';
                $page_message   = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere commodi amet odit velit obcaecati ullam accusantium quia minima! Voluptatibus mollitia tempora veniam nihil quos quis explicabo quia deserunt asperiores cupiditate. ';
                break;

            case 'access-denied':
                $page_title     = 'Oops! Anda tidak diperbolehkan mengakses halaman ini.';
                $page_message   = 'Maaf, sepertinya administrator tidak memperbolehkan anda mengakses halaman ini. Jika ini merupakan suatu kesalahan, silahkan hubungi administrator terkait.';
                break;
            case 'no-data-accessible':
                $page_title     = 'Oops! Tidak ada data untuk anda.';
                $page_message   = 'Maaf, sepertinya administrator tidak memperbolehkan anda melihat satu data-pun dihalaman ini. Jika ini merupakan suatu kesalahan, silahkan hubungi administrator terkait.';
                break;

            default:
                redirect('dashboard');
                break;
        }

        $this->set_panel_title( $page_title );
        $this->set_panel_body( $page_message );

        $this->load->theme('pages/notice', $this->data);
    }
}

/* End of file error.php */
/* Location: ./application/controllers/error.php */