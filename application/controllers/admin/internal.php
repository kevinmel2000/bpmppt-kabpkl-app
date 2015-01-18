<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://creasico.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/creasico/bpmppt/blob/master/LICENSE)
 * @subpackage  Internal
 * @category    Controller
 */

// -----------------------------------------------------------------------------

class Internal extends BI_Controller
{

    private $_settings = array();

    public function __construct()
    {
        parent::__construct();

        if ( !is_user_can('admin_application') && !is_user_can('setting_application') )
        {
            $this->_notice( 'access-denied' );
        }

        $this->_settings = Bootigniter::get_settings();

        $this->verify_login(uri_string());

        $this->bitheme->add_navbar( 'admin_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
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
        $this->set_panel_title('Properti data SKPD');

        /** --------------------------------------------------------------------
         * Data kontak SKPD
         * ------------------------------------------------------------------ */

        $fields['skpd_name'] = array(
            'type'  => 'text',
            'label' => 'Nama SKPD',
            'std'   => $this->_settings['skpd_name'],
            'validation'=>'required'
            );

        $fields['skpd_address'] = array(
            'type'  => 'textarea',
            'label' => 'Alamat',
            'std'   => $this->_settings['skpd_address'],
            'validation'=>'required'
            );

        $fields['skpd_kab'] = array(
            'type'  => 'text',
            'label' => 'Lokasi',
            'std'   => $this->_settings['skpd_kab'],
            'validation'=>'required'
            );

        $fields['skpd_city'] = array(
            'type'  => 'text',
            'label' => 'Kota',
            'std'   => $this->_settings['skpd_city'],
            'validation'=>'required'
            );

        $fields['skpd_prov'] = array(
            'type'  => 'text',
            'label' => 'Propinsi',
            'std'   => $this->_settings['skpd_prov'],
            'validation'=>'required'
            );

        $fields['skpd_no'] = array(
            'type'  => 'subfield',
            'label' => 'No. Telp dan Fax',
            'fields'=> array(
                'telp' => array(
                    'type'  => 'text',
                    'label' => 'No. Telp.',
                    'std'   => $this->_settings['skpd_telp'],
                    'validation'=>'required|min_length[6]|max_length[15]'
                    ),
                'fax' => array(
                    'type'  => 'text',
                    'label' => 'Faksimili',
                    'std'   => $this->_settings['skpd_fax'],
                    'validation'=>'required|min_length[6]|max_length[15]'
                    )
                ),
            );

        $fields['skpd_pos'] = array(
            'type'  => 'text',
            'label' => 'Kode Pos',
            'std'   => $this->_settings['skpd_pos'],
            'validation'=>'numeric|exact_length[5]'
            );

        $fields['skpd_web'] = array(
            'type'  => 'url',
            'label' => 'Alamat Web',
            'std'   => $this->_settings['skpd_web']
            );

        $fields['skpd_email'] = array(
            'type'  => 'email',
            'label' => 'Alamat Email',
            'std'   => $this->_settings['skpd_email'],
            'validation'=>'valid_email'
            );

        /** --------------------------------------------------------------------
         * Data Pimpinan SKPD
         * ------------------------------------------------------------------ */

        $fields['leader_fieldset'] = array(
            'type'  => 'fieldset',
            'label' => 'Data Pimpinan'
            );

        $fields['skpd_lead_name'] = array(
            'type'  => 'text',
            'label' => 'Nama Pimpinan',
            'std'   => $this->_settings['skpd_lead_name'],
            'validation'=>'required'
            );

        $fields['skpd_lead_jabatan'] = array(
            'type'  => 'text',
            'label' => 'Nama Pimpinan',
            'std'   => $this->_settings['skpd_lead_jabatan'],
            'validation'=>'required'
            );

        $fields['skpd_lead_nip'] = array(
            'type'  => 'text',
            'label' => 'NIP Pimpinan',
            'std'   => $this->_settings['skpd_lead_nip'],
            'validation'=>'required'
            );

        $this->_option_form( $fields );
    }

    public function app()
    {
        $this->set_panel_title('Pengaturan Aplikasi');

        /** --------------------------------------------------------------------
         * Pengaturan Data
         * ------------------------------------------------------------------ */

        $fields['app_data_show_limit'] = array(
            'type'  => 'number',
            'label' => 'Jumlah data ditampilkan',
            'std'   => $this->_settings['app_data_show_limit'],
            'desc'  => 'Jumlah data yang ditampilkan ditiap halaman',
            'validation'=>'required|numeric' );

        $php_link = anchor('http://php.net/manual/en/function.date.php', 'pengformatan tanggal pada PHP');

        $fields['app_date_format'] = array(
            'type'  => 'text',
            'label' => 'Format Tanggal',
            'std'   => $this->_settings['app_date_format'],
            'desc'  => 'Format tanggal menggunakan dasar '.$php_link,
            'validation'=>'required' );

        $fields['app_datetime_format'] = array(
            'type'  => 'text',
            'label' => 'Format Waktu &amp; Tanggal',
            'std'   => $this->_settings['app_datetime_format'],
            'desc'  => 'Format tanggal dan waktu menggunakan dasar '.$php_link,
            'validation'=>'required' );

        /** --------------------------------------------------------------------
         * Pengaturan Email
         * ------------------------------------------------------------------ */

        $fields['app_fieldset_email'] = array(
            'type'  => 'fieldset',
            'label' => 'Email'
            );

        $fields['email_protocol'] = array(
            'type'  => 'radio',
            'label' => 'Email Protocol',
            'std'   => $this->_settings['email_protocol'],
            'option'=> array(
                'mail'     => 'Mail',
                'sendmail' => 'Sendmail',
                'smtp'     => 'SMPT'
                ),
            );

        $sendmail_fold = array( 'key' => 'email_protocol', 'value' => 'sendmail' );

        $fields['email_mailpath'] = array(
            'type'  => 'text',
            'label' => 'Email path',
            'fold'  => $sendmail_fold,
            'std'   => $this->_settings['email_mailpath'],
            );

        $fields['email_smtp_host'] = array(
            'type'  => 'text',
            'label' => 'Host SMTP',
            'fold'  => $sendmail_fold,
            'std'   => $this->_settings['email_smtp_host']
            );

        $fields['email_smtp_user'] = array(
            'type'  => 'text',
            'label' => 'Pengguna SMTP',
            'fold'  => $sendmail_fold,
            'std'   => $this->_settings['email_smtp_user'],
            );

        $fields['email_smtp_pass'] = array(
            'type'  => 'password',
            'label' => 'Password SMTP',
            'fold'  => $sendmail_fold,
            'std'   => $this->_settings['email_smtp_pass']
            );

        $fields['email_smtp_port'] = array(
            'type'  => 'number',
            'label' => 'Port SMTP',
            'fold'  => $sendmail_fold,
            'std'   => $this->_settings['email_smtp_port'],
            'validation'=> 'numeric'
            );

        $fields['email_smtp_timeout'] = array(
            'type'  => 'number',
            'label' => 'Batas waktu SMTP',
            'fold'  => $sendmail_fold,
            'std'   => $this->_settings['email_smtp_timeout'],
            'validation'=> 'numeric'
            );

        $fields['email_wordwrap'] = array(
            'type'  => 'switch',
            'label' => 'Wordwrap',
            'desc'  => 'Membatasi jumlah huruf ditiap baris dalam kiriman email sebanyak 80 karakter dan sisanya dilanjutkan pada baris berikutnya.',
            'std'   => $this->_settings['email_wordwrap']
            );

        $fields['email_mailtype'] = array(
            'type'  => 'switch',
            'label' => 'Format kiriman email',
            'option'=> array( 'Teks', 'HTML' ),
            'desc'  => 'Format kiriman email. Disarankan menggunakan format HTML agar tampilan lebih baik.',
            'std'   => $this->_settings['email_mailtype']
            );

        $fields['email_priority'] = array(
            'type'  => 'slider',
            'label' => 'Prioritas',
            'min'   => 1,
            'max'   => 5,
            'std'   => $this->_settings['email_priority'],
            'desc'  => 'Prioritas email diisi dengan angka 1-5, angka 1 untuk paling tinggi dan 5 untuk paling rendah.',
            'validation'=> 'numeric|greater_than[0]|less_than[6]'
            );

        /** --------------------------------------------------------------------
         * Pengaturan Pendaftaran
         * ------------------------------------------------------------------ */

        $fields['auth_fieldset_register'] = array(
            'type'  => 'fieldset',
            'label' => 'Pendaftaran'
            );

        $fields['auth_allow_registration'] = array(
            'type'  => 'switch',
            'label' => 'Ijinkan registrasi Umum',
            'std'   => $this->_settings['auth_allow_registration'],
            'desc'  => 'Ijinkan registrasi umum',
            'validation'=>'numeric'
            );

        $fields['auth_email_activation'] = array(
            'type'  => 'switch',
            'label' => 'Aktivasi via email',
            'fold'  => array( 'key' => 'auth_allow_registration', 'value' => 1 ),
            'std'   => $this->_settings['auth_email_activation']
            );

        $auth_email_act_expire = second_to_day($this->_settings['auth_email_act_expire']);

        $fields['auth_email_act_expire'] = array(
            'type'  => 'slider',
            'label' => 'Batas aktivasi email',
            'fold'  => array( 'key' => 'auth_email_activation', 'value' => 1 ),
            'min'   => 1,
            'max'   => 10,
            'std'   => $auth_email_act_expire,
            'desc'  => 'Batas waktu aktivasi email dalam detik. Nilai '.$auth_email_act_expire.' hari.'
            );

        $fields['auth_use_username'] = array(
            'type'  => 'switch',
            'label' => 'Gunakan username',
            'fold'  => array( 'key' => 'auth_allow_registration', 'value' => 1 ),
            'std'   => $this->_settings['auth_use_username'],
            'desc'  => 'Gunakan username untuk setiap pengguna.'
            );

        /** --------------------------------------------------------------------
         * Pengaturan Halaman depan
         * ------------------------------------------------------------------ */

        $fields['opening_fieldset'] = array(
            'type'  => 'fieldset',
            'label' => 'Opening Text'
            );

        $fields['welcome_title'] = array(
            'type'  => 'text',
            'label' => 'Judul Pembuka',
            'std'   => $this->_settings['welcome_title']
            );

        $fields['welcome_login'] = array(
            'type'  => 'editor',
            'height'=> 200,
            'label' => 'Pembuka Halaman Login',
            'std'   => $this->_settings['welcome_login']
            );

        $fields['welcome_resend'] = array(
            'type'  => 'editor',
            'height'=> 200,
            'label' => 'Pembuka Resend',
            'std'   => $this->_settings['welcome_resend']
            );

        $fields['welcome_register'] = array(
            'type'  => 'editor',
            'height'=> 200,
            'label' => 'Pembuka Register',
            'std'   => $this->_settings['welcome_register']
            );

        $fields['welcome_forgot'] = array(
            'type'  => 'editor',
            'height'=> 200,
            'label' => 'Isi Pembuka',
            'std'   => $this->_settings['welcome_forgot']
            );

        $this->_option_form( $fields );
    }

    public function security()
    {
        $this->set_panel_title('Pengaturan Keamanan');

        /** --------------------------------------------------------------------
         * Pengaturan Kemanan
         * ------------------------------------------------------------------ */

        $fields['app_fieldset_security']   = array(
            'type'  => 'fieldset',
            'label' => 'Keamanan',
            );

        $user_min = 1;
        $user_max = 50;

        $fields['auth_username_length'] = array(
            'type'  => 'rangeslider',
            'label' => 'Jumlah karakter Username',
            'min'   => $user_min,
            'max'   => $user_max,
            'std'   => array( 'min' => $this->_settings['auth_username_length_min'], 'max' => $this->_settings['auth_username_length_max'] ),
            'desc'  => 'Jumlah minimal dan maksimal karakter Username.',
            );

        $fields['auth_password_length'] = array(
            'type'  => 'rangeslider',
            'label' => 'Jumlah karakter Password',
            'min'   => $user_min,
            'max'   => $user_max,
            'std'   => array( 'min' => $this->_settings['auth_password_length_min'], 'max' => $this->_settings['auth_password_length_max'] ),
            'desc'  => 'Jumlah minimal dan maksimal karakter Password.',
            );

        /** --------------------------------------------------------------------
         * Pengaturan Login
         * ------------------------------------------------------------------ */

        $fields['auth_fieldset_login'] = array(
            'type'  => 'fieldset',
            'label' => 'Login',
            );

        $fields['auth_login_by_username'] = array(
            'type'  => 'switch',
            'label' => 'Gunakan username saat login',
            'std'   => $this->_settings['auth_login_by_username'],
            );

        $fields['auth_login_by_email'] = array(
            'type'  => 'switch',
            'label' => 'Gunakan email saat login',
            'std'   => $this->_settings['auth_login_by_email'],
            );

        $fields['auth_login_record_ip'] = array(
            'type'  => 'switch',
            'label' => 'Rekam IP',
            'std'   => $this->_settings['auth_login_record_ip'],
            );

        $fields['auth_login_count_attempts'] = array(
            'type'  => 'switch',
            'label' => 'Hitung kegagalan login',
            'std'   => $this->_settings['auth_login_count_attempts'],
            );

        $fields['auth_login_max_attempts'] = array(
            'type'  => 'slider',
            'label' => 'Maksimum login',
            'min'   => 1,
            'max'   => 10,
            'std'   => $this->_settings['auth_login_max_attempts'],
            'fold'  => array( 'key' => 'auth_login_count_attempts', 'value' => 1 ),
            'desc'  => 'Batas maksimum login untuk tiap pengguna.'
            );

        $auth_login_attempt_expire = second_to_day( $this->_settings['auth_login_attempt_expire'] );

        $fields['auth_login_attempt_expire'] = array(
            'type'  => 'slider',
            'label' => 'Masa kadaluarsa login',
            'min'   => 1,
            'max'   => 10,
            'std'   => $auth_login_attempt_expire,
            'desc'  => 'Batas waktu pengguna dapat login kembali dalam detik. Nilai '.$auth_login_attempt_expire.' hari.',
            );

        /** --------------------------------------------------------------------
         * Pengaturan Captcha
         * ------------------------------------------------------------------ */

        $fields['auth_fieldset_captcha'] = array(
            'type'  => 'fieldset',
            'label' => 'Validasi Tambahan',
            );

        $fields['auth_captcha_registration'] = array(
            'type'  => 'switch',
            'label' => 'Gunakan captcha',
            'std'   => $this->_settings['auth_captcha_registration'],
            );

        $fields['auth_use_recaptcha'] = array(
            'type'  => 'switch',
            'label' => 'Gunakan reCaptcha',
            'fold'  => array( 'key' => 'auth_captcha_registration', 'value' => 1 ),
            'std'   => $this->_settings['auth_use_recaptcha'],
            'desc'  => 'Gunakan '.anchor('https://www.google.com/recaptcha', 'google reCaptcha', 'target="_blank"').' untuk validasi.',
            );

        $fields['auth_recaptcha_public_key'] = array(
            'type'  => 'text',
            'label' => 'reCaptcha public key',
            'fold'  => array( 'key' => 'auth_use_recaptcha', 'value' => 1 ),
            'std'   => $this->_settings['auth_recaptcha_public_key'],
            );

        $fields['auth_recaptcha_private_key'] = array(
            'type'  => 'text',
            'label' => 'reCaptcha private key',
            'fold'  => array( 'key' => 'auth_use_recaptcha', 'value' => 1 ),
            'std'   => $this->_settings['auth_recaptcha_private_key'],
            );

        /** --------------------------------------------------------------------
         * Pengaturan Username
         * ------------------------------------------------------------------ */

        $fields['auth_fieldset_blacklist'] = array(
            'type'  => 'fieldset',
            'label' => 'Daftar hitam',
            );

        $fields['auth_username_blacklist'] = array(
            'type'  => 'text',
            'label' => 'Nama pengguna',
            'std'   => $this->_settings['auth_username_blacklist'],
            'desc'  => 'Daftar username yang tidak diijinkan, dipisahkan dengan tanda koma (,)',
            );

        $fields['auth_username_blacklist_prepend'] = array(
            'type'  => 'text',
            'label' => 'Awalan Nama Pengguna',
            'std'   => $this->_settings['auth_username_blacklist_prepend'],
            'desc'  => 'Daftar kata awalan username yang tidak diijinkan, dipisahkan dengan tanda koma (,)',
            );

        $fields['auth_username_exceptions'] = array(
            'type'  => 'text',
            'label' => 'Username Pengecualian',
            'std'   => $this->_settings['auth_username_exceptions'],
            'desc'  => 'Daftar pengecualian username yang diijinkan, dipisahkan dengan tanda koma (,)',
            );

        $this->_option_form( $fields );
    }

    private function _option_form( $fields )
    {
        $this->load->library('biform');
        $form = $this->biform->initialize( array(
            'name'   => 'app-settings',
            'action' => current_url(),
            'fields' => $fields,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            if ( $this->bootigniter->edit_setting( $form_data ) )
            {
                $this->session->set_flashdata('success', array('Konfigurasi berhasil disimpan.'));
            }
            else
            {
                $this->session->set_flashdata('error', array('Terjadi masalah penyimpanan konfigurasi.'));
            }

            redirect( current_url() );
        }

        $this->data['panel_body'] = $form->generate();

        $this->load->theme('dataform', $this->data);
    }
}

/* End of file internal.php */
/* Location: ./application/controllers/internal.php */
