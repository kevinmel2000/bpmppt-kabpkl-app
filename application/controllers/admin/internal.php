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
 * Internal Class
 *
 * @subpackage  Controller
 */
class Internal extends BAKA_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->verify_login(uri_string());

        $this->themee->add_navbar( 'admin_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
        $this->admin_navbar( 'admin_sidebar', 'side' );

        $this->data['page_link'] = 'admin/internal/skpd';
    }

    public function index()
    {
        if ($this->data['page_link'] != current_url())
        {
            redirect($this->data['page_link']);
        }
    }

    public function skpd()
    {
        if ( !$this->authr->is_permited('internal_skpd_manage') )
        {
            $this->_notice( 'access-denied' );
        }

        $this->data['panel_title'] = $this->themee->set_title('Properti data SKPD');

        $fields[]   = array(
            'name'  => 'skpd_name',
            'type'  => 'text',
            'label' => 'Nama SKPD',
            'std'   => Setting::get('skpd_name'),
            'validation'=>'required' );

        $fields[]   = array(
            'name'  => 'skpd_lead_name',
            'type'  => 'text',
            'label' => 'Nama Pimpinan',
            'std'   => Setting::get('skpd_lead_name'),
            'validation'=>'required' );

        $fields[]   = array(
            'name'  => 'skpd_lead_nip',
            'type'  => 'text',
            'label' => 'NIP Pimpinan',
            'std'   => Setting::get('skpd_lead_nip'),
            'validation'=>'required' );

        $fields[]   = array(
            'name'  => 'skpd_addrresses',
            'type'  => 'fieldset',
            'label' => 'Alamat dan Kontak SKPD' );

        $fields[]   = array(
            'name'  => 'skpd_address',
            'type'  => 'textarea',
            'label' => 'Alamat',
            'std'   => Setting::get('skpd_address'),
            'validation'=>'required' );

        $fields[]   = array(
            'name'  => 'skpd_kab',
            'type'  => 'text',
            'label' => 'Lokasi',
            'std'   => Setting::get('skpd_kab'),
            'validation'=>'required' );

        $fields[]   = array(
            'name'  => 'skpd_city',
            'type'  => 'text',
            'label' => 'Kota',
            'std'   => Setting::get('skpd_city'),
            'validation'=>'required' );

        $fields[]   = array(
            'name'  => 'skpd_prov',
            'type'  => 'text',
            'label' => 'Propinsi',
            'std'   => Setting::get('skpd_prov'),
            'validation'=>'required' );

        $fields[]   = array(
            'name'  => 'skpd_no',
            'type'  => 'subfield',
            'label' => 'No. Telp dan Fax',
            'fields'=> array(
                array(
                    'name'  => 'telp',
                    'type'  => 'tel',
                    'label' => 'No. Telp.',
                    'std'   => Setting::get('skpd_telp'),
                    'validation'=>'required|min_length[6]|max_length[15]' ),
                array(
                    'name'  => 'max',
                    'type'  => 'tel',
                    'label' => 'Maksimal',
                    'std'   => Setting::get('skpd_fax'),
                    'validation'=>'required|min_length[6]|max_length[15]' )
                ),
            );

        $fields[]   = array(
            'name'  => 'skpd_pos',
            'type'  => 'text',
            'label' => 'Kode Pos',
            'std'   => Setting::get('skpd_pos'),
            'validation'=>'numeric|exact_length[5]' );

        $fields[]   = array(
            'name'  => 'skpd_web',
            'type'  => 'url',
            'label' => 'Alamat Web',
            'std'   => Setting::get('skpd_web')  );

        $fields[]   = array(
            'name'  => 'skpd_email',
            'type'  => 'email',
            'label' => 'Alamat Email',
            'std'   => Setting::get('skpd_email'),
            'validation'=>'valid_email' );

        $this->_option_form( $fields );

        $this->load->theme('pages/panel_form', $this->data);
    }

    public function app()
    {
        if ( !$this->authr->is_permited('internal_application_manage') )
        {
            $this->_notice( 'access-denied' );
        }

        $this->data['panel_title'] = $this->themee->set_title('Pengaturan Aplikasi');

        $fields[]   = array(
            'name'  => 'app_data_show_limit',
            'type'  => 'number',
            'label' => 'Jumlah data ditampilkan',
            'std'   => Setting::get('app_data_show_limit'),
            'desc'  => 'Jumlah data yang ditampilkan ditiap halaman',
            'validation'=>'required|numeric' );

        $php_link = anchor('http://php.net/manual/en/function.date.php', 'pengformatan tanggal pada PHP');

        $fields[]   = array(
            'name'  => 'app_date_format',
            'type'  => 'text',
            'label' => 'Format Tanggal',
            'std'   => Setting::get('app_date_format'),
            'desc'  => 'Format tanggal menggunakan dasar '.$php_link,
            'validation'=>'required' );

        $fields[]   = array(
            'name'  => 'app_datetime_format',
            'type'  => 'text',
            'label' => 'Format Waktu &amp; Tanggal',
            'std'   => Setting::get('app_datetime_format'),
            'desc'  => 'Format tanggal dan waktu menggunakan dasar '.$php_link,
            'validation'=>'required' );

        $fields[]   = array(
            'name'  => 'app_fieldset_email',
            'type'  => 'fieldset',
            'label' => 'Email' );

        $email_protocol = Setting::get('email_protocol');

        $fields[]   = array(
            'name'  => 'email_protocol',
            'type'  => 'radio',
            'label' => 'Email Protocol',
            'option'=> array(
                'mail'      => 'Mail',
                'sendmail'  => 'Sendmail',
                'smtp'      => 'SMPT'),
            'std'   => $email_protocol );

        $fields[]   = array(
            'name'  => 'email_mailpath',
            'type'  => 'text',
            'label' => 'Email path',
            'fold'  => array(
                'key'   => 'email_protocol',
                'value' => 'sendmail' ),
            'std'   => Setting::get('email_mailpath') );

        $fields[]   = array(
            'name'  => 'email_smtp_host',
            'type'  => 'text',
            'label' => 'Host SMTP',
            'fold'  => array(
                'key'   => 'email_protocol',
                'value' => 'smtp' ),
            'std'   => Setting::get('email_smtp_host') );

        $fields[]   = array(
            'name'  => 'email_smtp_user',
            'type'  => 'text',
            'label' => 'Pengguna SMTP',
            'fold'  => array(
                'key'   => 'email_protocol',
                'value' => 'smtp' ),
            'std'   => Setting::get('email_smtp_user'),
            // 'validation'=> 'valid_email'
            );

        $fields[]   = array(
            'name'  => 'email_smtp_pass',
            'type'  => 'password',
            'label' => 'Password SMTP',
            'fold'  => array(
                'key'   => 'email_protocol',
                'value' => 'smtp' ),
            'std'   => Setting::get('email_smtp_pass') );

        $fields[]   = array(
            'name'  => 'email_smtp_port',
            'type'  => 'number',
            'label' => 'Port SMTP',
            'fold'  => array(
                'key'   => 'email_protocol',
                'value' => 'smtp' ),
            'std'   => Setting::get('email_smtp_port'),
            'validation'=> 'numeric' );

        $fields[]   = array(
            'name'  => 'email_smtp_timeout',
            'type'  => 'number',
            'label' => 'Batas waktu SMTP',
            'fold'  => array(
                'key'   => 'email_protocol',
                'value' => 'smtp' ),
            'std'   => Setting::get('email_smtp_timeout'),
            'validation'=> 'numeric' );

        $fields[]   = array(
            'name'  => 'email_wordwrap',
            'type'  => 'switch',
            'label' => 'Wordwrap',
            'desc'  => 'Membatasi jumlah huruf ditiap baris dalam kiriman email sebanyak 80 karakter dan sisanya dilanjutkan pada baris berikutnya.',
            'std'   => Setting::get('email_wordwrap') );

        $fields[]   = array(
            'name'  => 'email_mailtype',
            'type'  => 'switch',
            'label' => 'Format kiriman email',
            'option'=> array(
                0  => 'Teks',
                1  => 'HTML' ),
            'desc'  => 'Format kiriman email. Disarankan menggunakan format HTML agar tampilan lebih baik.',
            'std'   => Setting::get('email_mailtype') );

        $fields[]   = array(
            'name'  => 'email_priority',
            'type'  => 'slider',
            'label' => 'Prioritas',
            'min'   => 1,
            'max'   => 5,
            'step'  => 1,
            'std'   => Setting::get('email_priority'),
            'desc'  => 'Prioritas email diisi dengan angka 1-5, angka 1 untuk paling tinggi dan 5 untuk paling rendah.',
            'validation'=> 'numeric|greater_than[0]|less_than[6]' );

        $fields[]   = array(
            'name'  => 'app_fieldset_security',
            'type'  => 'fieldset',
            'label' => 'Keamanan' );

        $user_min = 1;
        $user_max = 50;

        $fields[]   = array(
            'name'  => 'auth_username_length',
            'type'  => 'subfield',
            'label' => 'Jumlah karakter Username',
            'fields'=> array(
                array(
                    'name'  => 'min',
                    'type'  => 'number',
                    'min'   => $user_min,
                    'max'   => $user_max,
                    'label' => 'Minimal',
                    'std'   => Setting::get('auth_username_min_length'),
                    'validation'=>'required|numeric' ),
                array(
                    'name'  => 'max',
                    'type'  => 'number',
                    'min'   => $user_min,
                    'max'   => $user_max,
                    'label' => 'Maksimal',
                    'std'   => Setting::get('auth_username_max_length'),
                    'validation'=>'required|numeric' )
                ),
            'desc'  => 'Jumlah minimal dan maksimal karakter Username' );

        $fields[]   = array(
            'name'  => 'auth_password_length',
            'type'  => 'subfield',
            'label' => 'Jumlah karakter Password',
            'fields'=> array(
                array(
                    'name'  => 'min',
                    'type'  => 'number',
                    'min'   => $user_min,
                    'max'   => $user_max,
                    'label' => 'Minimal',
                    'std'   => Setting::get('auth_password_min_length'),
                    'validation'=>'required|numeric' ),
                array(
                    'name'  => 'max',
                    'type'  => 'number',
                    'min'   => $user_min,
                    'max'   => $user_max,
                    'label' => 'Maksimal',
                    'std'   => Setting::get('auth_password_max_length'),
                    'validation'=>'required|numeric' )
                ),
            'desc'  => 'Jumlah minimal dan maksimal karakter Password' );

        $fields[]   = array(
            'name'  => 'auth_fieldset_register',
            'type'  => 'fieldset',
            'label' => 'Pendaftaran' );

        $fields[]   = array(
            'name'  => 'auth_allow_registration',
            'type'  => 'switch',
            'label' => 'Ijinkan registrasi Umum',
            'std'   => Setting::get('auth_allow_registration'),
            'desc'  => 'Ijinkan registrasi umum',
            'validation'=>'numeric' );

        $fields[]   = array(
            'name'  => 'auth_email_activation',
            'type'  => 'switch',
            'label' => 'Aktivasi via email',
            'std'   => Setting::get('auth_email_activation'));

        $email_expired = Setting::get('auth_email_act_expire');

        $fields[]   = array(
            'name'  => 'auth_email_act_expire',
            'type'  => 'number',
            'label' => 'Batas aktivasi email',
            'std'   => $email_expired,
            'desc'  => 'Batas waktu aktivasi email dalam detik. Nilai '.$email_expired.' detik = '.second_to_day( $email_expired ).' hari.',
            'validation'=>'numeric' );

        $fields[]   = array(
            'name'  => 'auth_use_username',
            'type'  => 'switch',
            'label' => 'Gunakan username',
            'std'   => Setting::get('auth_use_username'),
            'desc'  => 'Gunakan username untuk setiap pengguna.');

        $fields[]   = array(
            'name'  => 'auth_fieldset_login',
            'type'  => 'fieldset',
            'label' => 'Login' );

        $fields[]   = array(
            'name'  => 'auth_login_by_username',
            'type'  => 'switch',
            'label' => 'Gunakan username saat login',
            'std'   => Setting::get('auth_login_by_username'));

        $fields[]   = array(
            'name'  => 'auth_login_by_email',
            'type'  => 'switch',
            'label' => 'Gunakan email saat login',
            'std'   => Setting::get('auth_login_by_email'));

        $fields[]   = array(
            'name'  => 'auth_login_record_ip',
            'type'  => 'switch',
            'label' => 'Rekam IP',
            'std'   => Setting::get('auth_login_record_ip'));

        $fields[]   = array(
            'name'  => 'auth_login_count_attempts',
            'type'  => 'switch',
            'label' => 'Hitung kegagalan login',
            'std'   => Setting::get('auth_login_count_attempts'));

        $fields[]   = array(
            'name'  => 'auth_login_max_attempts',
            'type'  => 'number',
            'label' => 'Maksimum login',
            'std'   => Setting::get('auth_login_max_attempts'),
            'desc'  => 'batas maksimum login untuk tiap pengguna');

        $login_expired = Setting::get('auth_login_attempt_expire');

        $fields[]   = array(
            'name'  => 'auth_login_attempt_expire',
            'type'  => 'number',
            'label' => 'Masa kadaluarsa login',
            'std'   => $login_expired,
            'desc'  => 'Batas waktu pengguna dapat login kembali dalam detik. Nilai '.$login_expired.' detik = '.second_to_day( $login_expired ).' hari.');

        $fields[]   = array(
            'name'  => 'auth_fieldset_captcha',
            'type'  => 'fieldset',
            'label' => 'Validasi Tambahan' );

        $fields[]   = array(
            'name'  => 'auth_captcha_registration',
            'type'  => 'switch',
            'label' => 'Gunakan captcha',
            'std'   => Setting::get('auth_captcha_registration') );

        $fields[]   = array(
            'name'  => 'auth_use_recaptcha',
            'type'  => 'switch',
            'label' => 'Gunakan reCaptcha',
            'fold'  => array(
                'key' => 'auth_captcha_registration',
                'value' => 1
                ),
            'std'   => Setting::get('auth_use_recaptcha'),
            'desc'  => 'Gunakan '.anchor('https://www.google.com/recaptcha', 'google reCaptcha', 'target="_blank"').' untuk validasi.' );

        $fields[]   = array(
            'name'  => 'auth_recaptcha_public_key',
            'type'  => 'text',
            'label' => 'reCaptcha public key',
            'fold'  => array(
                'key'   => 'auth_use_recaptcha',
                'value' => 1
                ),
            'std'   => Setting::get('auth_recaptcha_public_key') );

        $fields[]   = array(
            'name'  => 'auth_recaptcha_private_key',
            'type'  => 'text',
            'label' => 'reCaptcha private key',
            'fold'  => array(
                'key'   => 'auth_use_recaptcha',
                'value' => 1
                ),
            'std'   => Setting::get('auth_recaptcha_private_key') );

        $fields[]   = array(
            'name'  => 'auth_fieldset_blacklist',
            'type'  => 'fieldset',
            'label' => 'Daftar hitam' );

        $fields[]   = array(
            'name'  => 'auth_username_blacklist',
            'type'  => 'text',
            'label' => 'Nama pengguna',
            'std'   => Setting::get('auth_username_blacklist'),
            'desc'  => 'Daftar username yang tidak diijinkan, dipisahkan dengan tanda koma (,)' );

        $fields[]   = array(
            'name'  => 'auth_username_blacklist_prepend',
            'type'  => 'text',
            'label' => 'Awalan Nama Pengguna',
            'std'   => Setting::get('auth_username_blacklist_prepend'),
            'desc'  => 'Daftar kata awalan username yang tidak diijinkan, dipisahkan dengan tanda koma (,)' );

        $fields[]   = array(
            'name'  => 'auth_username_exceptions',
            'type'  => 'text',
            'label' => 'Username Pengecualian',
            'std'   => Setting::get('auth_username_exceptions'),
            'desc'  => 'Daftar pengecualian username yang diijinkan, dipisahkan dengan tanda koma (,)' );

        $this->_option_form( $fields );

        $this->load->theme('pages/panel_form', $this->data);
    }

    private function _option_form( $fields )
    {
        $this->load->library('baka_pack/former');

        $form = $this->former->init( array(
            'name'   => 'app-settings',
            'action' => current_url(),
            'fields' => $fields,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            $return = FALSE;

            $this->db->trans_start();

            foreach ( $form_data as $opt_key => $opt_val )
            {
                $return = Setting::edit( $opt_key, $opt_val );
            }

            $this->db->trans_complete();

            if ( $return === FALSE )
            {
                $this->session->set_flashdata('error', array('Terjadi masalah penyimpanan konfigurasi.'));
            }
            else
            {
                $this->session->set_flashdata('success', array('Konfigurasi berhasil disimpan.'));
            }

            redirect( current_url() );
        }

        // var_dump(validation_errors());
        // var_dump($form_data);

        // var_dump( $fields );

        $this->data['panel_body'] = $form->generate();
    }

    public function prop( $page = '', $prop_id = NULL )
    {
        $this->data['page_link'] = 'admin/internal/prop/';

        $this->data['load_toolbar'] = TRUE;

        switch ( $page ) {
            case 'form':
                $this->_prop_form( $prop_id );
                break;

            case 'hapus':
                $this->_prop_del( $prop_id );
                break;

            case 'data':
            default:
                $this->_prop_data();
                break;
        }
    }

    private function _prop_data()
    {
        $this->data['panel_title']  = $this->themee->set_title('Pengaturan Properti Data');

        $this->data['tool_buttons']['form'] = 'Baru|primary';

        $this->load->library('baka_pack/gridr', array(
            'base_url'   => $this->data['page_link'],
            ));

        $query = $this->db->select()
                          ->from( get_conf('system_env_table') )
                          ->where('user_id', $this->authr->get_user_id())
                          ->or_where('user_id', 0);

        $grid = $this->gridr->set_column('Key', 'env_key', '45%', '<strong>%s</strong>')
                            ->set_column('Value', 'env_value', '40%', '%s')
                            ->set_button('form', 'Lihat data')
                            ->set_button('hapus', 'Hapus data');
                          
        $this->data['panel_body'] = $grid->generate( $query );

        $this->load->theme('pages/panel_data', $this->data);
    }

    private function _prop_form( $prop_id = NULL )
    {
        $this->data['panel_title'] = $this->themee->set_title('Pengaturan Properti Data');

        $this->data['tool_buttons']['data'] = 'Kembali|default';

        $prop = (! is_null($prop_id) ? $this->db->get_where(get_conf('system_env_table'), array('id' => $prop_id) ) : FALSE );

        $fields[]   = array(
            'name'  => 'app_env_key',
            'type'  => 'text',
            'label' => 'Nama Properti',
            'std'   => ( $prop ? $prop->env_key : '' ),
            'validation'=> ( !$prop ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => 'app_env_value',
            'type'  => 'text',
            'label' => 'Nilai Properti',
            'std'   => ( $prop ? $prop->env_value : '' ),
            'validation'=> ( !$prop ? 'required' : '' ) );

        $this->load->library('baka_pack/former');

        $form = $this->former->init( array(
            'name'   => 'internal-prop',
            'action' => current_url(),
            'fields' => $fields,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            $return     = FALSE;
            $form_data  = $form->submited_data();

            if ( $prop )
            {
                $return = $this->db->update(
                    get_conf('system_env_table'),
                    array('env_key' => $form_data['app_env_value'], 'env_value' => $form_data['app_env_value'] ),
                    array('id'      => $prop_id )
                    );
            }
            else
            {
                $return = $this->db->insert(
                    get_conf('system_env_table'),
                    array(
                        'user_id'   => $this->authr->get_user_id(),
                        'env_key'   => $form_data['app_env_value'],
                        'env_value' => $form_data['app_env_value']
                        )
                    );
            }

            if ( $return === FALSE )
            {
                $this->session->set_flashdata('error', array('Terjadi masalah penyimpanan konfigurasi.'));
                redirect( current_url() );
            }
            else
            {
                $this->session->set_flashdata('success', array('Properti berhasil disimpan.'));
                redirect( $this->data['page_link'].'data/' );
            }
        }

        $this->data['panel_body'] = $form->generate();

        $this->load->theme('pages/panel_form', $this->data);
    }

    private function _prop_del( $prop_id )
    {
        if ( $this->db->delete( get_conf('system_env_table'), array('id' => $prop_id) ) )
        {
            $this->session->set_flashdata('success', array('Properti berhasil dihapus.'));
        }
        else
        {
            $this->session->set_flashdata('error', array('Terjadi masalah penghapusan konfigurasi.'));
        }
        
        redirect( current_url() );
    }
}

/* End of file internal.php */
/* Location: ./application/controllers/internal.php */