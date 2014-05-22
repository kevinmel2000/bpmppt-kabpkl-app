<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
 *
 */

// -----------------------------------------------------------------------------

/**
 * BAKA pack Languages
 *
 * @subpackage  Translation
 * @category    lLanguage
 */

// -----------------------------------------------------------------------------
// Buttons
// -----------------------------------------------------------------------------
$lang['submit_btn']     = 'Simpan';
$lang['reset_btn']      = 'Batal';
$lang['print_btn']      = 'Cetak';
$lang['backup_btn']     = 'Backup sekarang';
$lang['restore_btn']    = 'Restore sekarang';

// -----------------------------------------------------------------------------
// Statuses
// -----------------------------------------------------------------------------
$lang['status_pending']     = 'Tertunda';
$lang['status_approved']    = 'Disetujui';
$lang['status_printed']     = 'Dicetak';
$lang['status_done']        = 'Selesai';
$lang['status_deleted']     = 'Dihapus';

// -----------------------------------------------------------------------------
// Another Statuse
// -----------------------------------------------------------------------------
$lang['pending']    = 'Tertunda';
$lang['approved']   = 'Disetujui';
$lang['printed']    = 'Dicetak';
$lang['done']       = 'Selesai';
$lang['deleted']    = 'Dihapus';

// -----------------------------------------------------------------------------
// Themee
// -----------------------------------------------------------------------------
$lang['error_browser_jadul']    = 'Web browser anda jadul!';

// -----------------------------------------------------------------------------
// File
// -----------------------------------------------------------------------------
$lang['file_not_found']     = 'Berkas %s tidak ada.';

// -----------------------------------------------------------------------------
// Authen
// -----------------------------------------------------------------------------
$lang['auth_incorrect_captcha']     = 'Kode validasi anda salah!.';
$lang['auth_username_blacklisted']  = 'Anda tidak dapat menggunakan username tersebut!.';
$lang['auth_incorrect_login']       = 'Login yang anda masukan salah.';
$lang['auth_incorrect_username']    = 'Username yang anda masukan salah.';
$lang['auth_incorrect_password']    = 'Password yang anda masukan salah.';
$lang['auth_banned_account']        = 'Akun anda sedang dicekal dengan alasan %s.';
$lang['auth_deleted_account']       = 'Akun tersebut sudah dihapus beberapa waktu yang lalu.';
$lang['auth_inactivated_account']   = 'Akun anda belum aktif.';
$lang['auth_login_success']         = 'Login berhasil.';
$lang['auth_username_in_use']       = 'Username tersebut sudah digunakan.';
$lang['auth_username_not_exists']   = 'Username tersebut tidak terdaftar.';
$lang['auth_email_in_use']          = 'Email tersebut sudah digunakan.';
$lang['auth_email_not_exists']      = 'Email tersebut tidak terdaftar.';
$lang['auth_current_email']         = 'Saat ini Anda tengah menggunakan email tersebut.';
$lang['auth_current_password']      = 'Saat ini Anda tengah menggunakan password tersebut.';
$lang['auth_inapproved_account']    = 'Akun anda belum disetujui.';
$lang['auth_registration_success']  = 'Proses registrasi pengguna berhasil, mendaftarkan akun baru.';
$lang['auth_registration_failed']   = 'Proses registrasi pengguna gagal.';
$lang['auth_username_min_length']   = 'Username harus lebih dari %s karakter';
$lang['auth_username_max_length']   = 'Username tidak boleh lebih dari %s karakter';
$lang['auth_password_min_length']   = 'Password harus lebih dari %s karakter';
$lang['auth_password_max_length']   = 'Password tidak boleh lebih dari %s karakter';
$lang['auth_login_by_login']        = 'Username atau Email';
$lang['auth_login_by_username']     = 'Username';
$lang['auth_login_by_email']        = 'Email';

// -----------------------------------------------------------------------------
// Database Utility
// -----------------------------------------------------------------------------
$lang['utily_backup_folder_not_exists']    = 'Direktori %s belum ada pada server anda.';
$lang['utily_backup_folder_not_writable']  = 'Anda tidak memiliki ijin untuk menulis pada direktori %s.';
$lang['utily_backup_process_failed']       = 'Proses backup database gagal.';
$lang['utily_backup_process_success']      = 'Proses backup database berhasil.';
$lang['utily_restore_success']             = 'Proses restorasi database berhasil.';
$lang['utily_upload_failed']               = 'Proses upload gagal.';

// -----------------------------------------------------------------------------
// Email Subjects
// -----------------------------------------------------------------------------
$lang['email_subject_forgot_password']      = 'Email Konfirmasi: Lupa password.';
$lang['email_subject_welcome']              = 'Email Konfirmasi: Selamat bergabung!';
$lang['email_subject_activate']             = 'Email Aktifasi: Selamat bergabung!';
$lang['email_subject_reset_password']       = 'Email Konfirmasi: Password baru anda telah siap';
$lang['email_subject_change_email']         = 'Email Aktifasi: Email baru anda telah siap diaktifkan';

// -----------------------------------------------------------------------------
// Median Library
// -----------------------------------------------------------------------------
$lang['median_upload_policy']                     = '. Batas jumlah upload adalah: <i class="bold">%s</i> berkas dan hanya berkas dengan extensi: %s yang diijinkan.';
$lang['median_drop_area_selector_text']           = 'Drop files here to upload';
$lang['median_drop_processing_selector_text']     = 'Processing dropped files...';
$lang['median_upload_button_selector_text']       = 'Upload files';
$lang['median_file_type_not_allowed_text']        = 'Tipe berkas tidak diijinkan';
$lang['median_file_size_too_large_text']          = 'Ukuran berkas terlalu besar';
$lang['median_directory_not_writable_text']       = 'Uploads directory isn\'t writable';
$lang['median_text_auto_retry_note']              = 'Mencoba kembali {retryNum}/{maxAuto} ...';
$lang['median_text_fail_upload']                  = 'Upload gagal';
$lang['median_text_format_progress']              = '{percent}% dari {total_size}';
$lang['median_text_paused']                       = 'Tertunda';
$lang['median_text_waiting_response']             = 'Dalam proses...';
$lang['median_error_empty']                       = '{file} is empty, please select files again without it.';
$lang['median_error_max_height_image']            = 'Image is too tall.';
$lang['median_error_max_width_image']             = 'Image is too wide.';
$lang['median_error_min_height_image']            = 'Image is not tall enough.';
$lang['median_error_min_width_image']             = 'Image is not wide enough.';
$lang['median_error_min_size']                    = '{file} is too small, minimum file size is {minSizeLimit}.';
$lang['median_error_no_files']                    = 'No files to upload.';
$lang['median_error_on_leave']                    = 'The files are being uploaded, if you leave now the upload will be canceled.';
$lang['median_error_retry_fail_too_many_items']   = 'Retry failed - you have reached your file limit.';
$lang['median_error_size']                        = '{file} terlalu besar, ukuran maksimum adalah {sizeLimit}.';
$lang['median_error_too_many_items']              = 'Too many items ({netItems}) would be uploaded. Item limit is {itemLimit}.';
$lang['median_error_type']                        = '{file} has an invalid extension. Valid extension(s): {extensions}.';
$lang['median_client_name']                       = 'Original File Name:';
$lang['median_file_name']                         = 'Uploaded File Name:';
$lang['median_file_size']                         = 'File Size:';
$lang['median_file_type']                         = 'File Type:';
$lang['median_file_path']                         = 'Upload Destination:';


/* End of file baka_pack_lang.php */
/* Location: ./application/language/indonesian/baka_pack_lang.php */