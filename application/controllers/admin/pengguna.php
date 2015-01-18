<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://creasico.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/creasico/bpmppt/blob/master/LICENSE)
 * @subpackage  Pengguna
 * @category    Controller
 */

// -----------------------------------------------------------------------------

class Pengguna extends BI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->verify_login(uri_string());

        $this->bitheme->add_navbar( 'admin_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
        $this->admin_navbar( 'admin_sidebar', 'side' );

        $this->data['load_toolbar'] = TRUE;
        $this->data['page_link']    = 'admin/pengguna/';
    }

    public function index()
    {
        $this->data();
    }

    public function data( $page = '', $user_id = '' )
    {
        $this->data['page_link'] .= 'data/';

        switch ( $page ) {
            case 'form':
                $this->_user_form($user_id);
                break;
            case 'ban':
                $this->_user_ban($user_id);
                break;
            case 'unban':
                if ( $this->biauth->remove_user( $user_id, $purge ) )
                {
                    $this->session->set_flashdata('success', get_message('success'));
                    redirect( $this->data['page_link'] );
                }
                else
                {
                    $this->session->set_flashdata('error', get_message('error'));
                    redirect( current_url() );
                }
                break;
            case 'delete':
                if ( $this->biauth->remove_user( $user_id ) )
                {
                    $this->session->set_flashdata('success', get_message('success'));
                    redirect( $this->data['page_link'] );
                }
                else
                {
                    $this->session->set_flashdata('error', get_message('error'));
                    redirect( current_url() );
                }
                break;
            case 'undelete':
                if ( $this->biauth->remove_user( $user_id, $purge ) )
                {
                    $this->session->set_flashdata('success', get_message('success'));
                    redirect( $this->data['page_link'] );
                }
                else
                {
                    $this->session->set_flashdata('error', get_message('error'));
                    redirect( current_url() );
                }
                break;
            case 'remove':
                if ( $this->biauth->remove_user( $user_id, $purge ) )
                {
                    $this->session->set_flashdata('success', get_message('success'));
                    redirect( $this->data['page_link'] );
                }
                else
                {
                    $this->session->set_flashdata('error', get_message('error'));
                    redirect( current_url() );
                }
                break;
            default:
                if ($page == '' or $page == 'data')
                {
                    $page = 'activated';
                }

                $this->_user_table($page);
                break;
        }
    }

    private function _user_table($status)
    {
        if ( !is_user_can('manage_users') )
        {
            $this->_notice( 'access-denied' );
        }

        $this->data['tool_buttons']['form'] = 'Baru|primary';
        $this->data['tool_buttons'][]  = array(
            'activated/' => 'Aktif',
            'banned/'    => 'Dicekal',
            'deleted/'   => 'Terhapus'
            );

        $this->data['data_page'] = TRUE;
        $this->load->library('bitable', array(
            'base_url' => $this->data['page_link'],
            ));

        $grid = $this->bitable->set_column('Pengguna', 'id, display, username, email', '45%', '<a href="data/form/%s" class="bold">%s</a> <i class="text-muted">%s</i><br><small class="text-muted">%s</small>')
                              ->set_column('Kelompok', 'callback_make_tag:group_desc', '30%')
                              ->set_column('Status', _x($status), '10%', '<span class="label label-default">%s</span>');

        if ($status == 'activated')
        {
            // $status = 'Aktif';
            $grid->set_button('form', 'Lihat pengguna')
                 ->set_button('ban', 'Cekal pengguna')
                 ->set_button('delete', 'Hapus pengguna');
        }
        elseif ($status == 'banned')
        {
            // $status = 'Dicekal';
            $grid->set_button('form', 'Lihat pengguna')
                 ->set_button('unban', 'Batalkan pencekalan')
                 ->set_button('delete', 'Hapus pengguna');
        }
        elseif ($status == 'deleted')
        {
            // $status = 'Terhapus';
            $grid->set_button('ban', 'Cekal pengguna')
                 ->set_button('undelete', 'Batalkan penghapusan');
        }

        $this->set_panel_title('Semua data penggunas: '._x($status));
        $this->data['panel_body'] = $grid->generate( $this->biauth->users->fetch($status) );

        $this->load->theme('dataform', $this->data);
    }

    public function profile()
    {
        $this->_user_form( $this->biauth->get_user_id() );
    }

    private function _user_form( $user_id = '' )
    {
        if ( $user_id == $this->current_user['user_id'] AND strpos( current_url(), 'profile' ) === FALSE )
        {
            redirect('profile');
        }

        $user   = ( $user_id != '' ? $this->biauth->get_user( $user_id ) : FALSE );
        $judul  = ( $user_id == $this->current_user['user_id'] ? 'Profile anda: ' : 'Data pengguna: ');

        $this->set_panel_title(( $user ? $judul.$user->username : 'Buat pengguna baru' ));

        if ( $user )
        {
            if ((bool) $user->activated)
            {
                $status = 'activated';
            }
            elseif ((bool) $user->banned)
            {
                $status = 'banned';
            }
            elseif ((bool) $user->deleted)
            {
                $status = 'deleted';
            }

            $this->data['tool_buttons'][$status] = 'Kembali|default';

            if ( $user_id != $this->current_user['user_id'] )
            {
                if ($status == 'activated')
                {
                    $this->data['tool_buttons'][]  = array(
                        'ban/'.$user_id => 'Cekal|danger',
                        'delete/'.$user_id => 'Hapus|danger' );
                }
                elseif ($status == 'banned')
                {
                    $this->data['tool_buttons'][]  = array(
                        'unban/'.$user_id => 'Batal cekal|danger',
                        'delete/'.$user_id => 'Hapus|danger' );
                }
                elseif ($status == 'deleted')
                {
                    $this->data['tool_buttons'][]  = array(
                        'ban/'.$user_id => 'Cekal|danger',
                        'undelete/'.$user_id => 'Batal hapus|danger',
                        'remove/'.$user_id => 'Hapus selamanya|danger' );
                }
            }
        }
        else
        {
            $this->data['tool_buttons']['data'] = 'Kembali|default';
        }

        if (!is_user_can('manage_users'))
        {
            $this->data['tool_buttons'] = array();
        }

        $fields['user-display'] = array(
            'type'  => 'text',
            'label' => 'Nama Lengkap',
            'std'   => ( $user ? $user->display : '' ),
            'desc'  => 'Mohon untuk menggunakan nama asli.',
            'validation'=> 'required'
            );

        if ( (bool) Bootigniter::get_setting('auth_use_username') )
        {
            $username_min_length = Bootigniter::get_setting('auth_username_length_min');
            $username_max_length = Bootigniter::get_setting('auth_username_length_max');
            $fields['user-username'] = array(
                'type'  => 'text',
                'label' => 'Username',
                'std'   => ( $user ? $user->username : '' ),
                'desc'  => 'Username tidak boleh menggunakan spasi dan harus diisi dengan minimal '.$username_min_length.' dan maksimal '.$username_max_length.' karakter.',
                'validation'=> ( !$user ? 'is_username_available|' : '' ).'required|valid_username_length|is_username_blacklist'
                );
        }

        $fields['user-email']   = array(
            'type'  => 'email',
            'label' => 'Email',
            'std'   => ( $user ? $user->email : '' ),
            'desc'  => 'Dengan alasan keamanan mohon gunakan email aktif anda.',
            'validation'=> ( !$user ? 'is_email_available|' : '' ).'required|valid_email'
            );

        if ( $user )
        {
            $fields['app-fieldset-password'] = array(
                'type'  => 'fieldset',
                'label' => 'Ganti password'
                );

            $fields['user-old-password'] = array(
                'type'  => 'password',
                'label' => 'Password lama'
                );
        }

        $password_min_length = Bootigniter::get_setting('auth_password_length_min');
        $password_max_length = Bootigniter::get_setting('auth_password_length_max');

        $fields['user-new-password'] = array(
            'type'  => 'password',
            'label' => ( !$user ? 'Password' : 'Password baru' ),
            'desc'  => 'Password harus diisi dengan minimal '.$password_min_length.' dan maksimal '.$password_max_length.' karakter.',
            'validation'=> ( !$user ? 'required|' : '' ).'valid_password_length'
            );

        $fields['user-confirm-password'] = array(
            'type'  => 'password',
            'label' => 'Konfirmasi Password',
            'desc'  => 'Ulangi penulisan '.( !$user ? 'Password' : 'Password baru' ).' diatas.',
            'validation'=> ( !$user ? 'required|' : '' ).'matches[user-new-password]'
            );

        if ( $user_id != $this->current_user['user_id'] and is_user_can('manage_groups') )
        {
            $fields['app-fieldset-groups'] = array(
                'type'  => 'fieldset',
                'label' => 'Kelompok'
                );

            $fields['user-groups'] = array(
                'type'  => 'checkbox',
                'label' => 'Kelompok pengguna',
                'option'=> $this->biauth->groups->fetch_assoc(),
                'std'   => ( $user ? $user->groups : '' ),
                'validation'=> ( !$user ? 'required' : '' )
                );
        }

        if ( $user and !$user->deleted )
        {
            $fields['app-fieldset-status']   = array(
                'type'  => 'fieldset',
                'label' => 'Status'
                );

            $this->load->library('table');
            $this->table->set_template(array(
                'table_open' => '<table class="table table-striped table-bordered table-hover table-condensed">'
                ));

            $this->table->set_heading(array(
                array( 'data' => 'Nama',  'style' => 'width:26%', ),
                array( 'data' => 'Nilai', 'style' => 'width:74%', )
                ));

            $is_banned = (bool) $user->banned;
            $user_info = array(
                'Dibuat pada' => format_datetime($user->created),
                'Login terakhir' => format_datetime($user->last_login),
                'Aktif' => (bool) $user->activated ? twbs_label('Ya', 'success') : twbs_label('Tidak', 'danger'),
                'Dicekal' => $is_banned ? twbs_label('Ya', 'danger') : twbs_label('Tidak', 'success'),
                );

            if ( $is_banned )
            {
                $user_info['Alasan pencekalan'] = $user->ban_reason;
            }

            foreach ($user_info as $key => $val)
            {
                $this->table->add_row($key, $val);
            }

            $fields['user-status']   = array(
                'type'  => 'custom',
                'label' => 'Status Pengguna',
                'std'   => $this->table->generate()
                );

            $this->table->clear();
        }

        $this->load->library('biform');
        $form = $this->biform->initialize( array(
            'name'   => 'user-form',
            'action' => current_url(),
            'fields' => $fields,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            $user_data = array(
                'display'  => $form_data['user-display'],
                'username' => $form_data['user-username'],
                'email'    => $form_data['user-email'],
                );

            if (isset($form_data['user-groups']))
            {
                $user_data['groups'] = $form_data['user-groups'];
            }

            if ( !$user )
            {
                $user_data['password'] = $form_data['user-new-password'];

                $this->biauth->create_user($user_data);
            }
            else
            {
                $user_data['old_pass'] = $form_data['user-old-password'];
                $user_data['new_pass'] = $form_data['user-new-password'];

                $this->biauth->edit_user($user_id, $user_data);
            }

            foreach ( get_message() as $level => $message )
            {
                // var_dump($level
                $this->session->set_flashdata( $level, $message );
            }

            redirect( current_url() );
        }

        $this->data['panel_body'] = $form->generate();

        $this->load->theme('dataform', $this->data);
    }

    private function _user_ban( $user_id )
    {
        $username = $this->biauth->users->get( $user_id )->username;

        $this->set_panel_title('Cekal pengguna: '.$username);

        $fields['ban-user'] = array(
            'type'  => 'text',
            'label' => 'Nama Pengguna',
            'attr'  => 'disabled',
            'std'   => $username
            );

        $fields['ban-reason'] = array(
            'type'  => 'textarea',
            'label' => 'Alasan pencekalan',
            'desc'  => 'Mohon tuliskan secara lengkap alasan pencekalan pengguna "'.$username.'".',
            'validation'=> 'required'
            );

        $this->load->library('biform');
        $form = $this->biform->initialize( array(
            'name' => 'user-ban',
            'action' => current_url(),
            'fields' => $fields,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            if ( $this->biauth->users->ban( $user_id, $form_data['ban-reason'] ) )
            {
                $this->session->set_flashdata('success', get_message('success'));
                redirect( $this->data['page_link'] );
            }
            else
            {
                $this->session->set_flashdata('error', get_message('error'));
                redirect( current_url() );
            }
        }

        $this->data['panel_body'] = $form->generate();

        $this->load->theme('dataform', $this->data);
    }

    public function groups( $page = '', $group_id = NULL )
    {
        $this->data['page_link'] .= 'groups/';

        switch ( $page ) {
            case 'form':
                $this->_group_form( $group_id );
                break;

            case 'hapus':
                $this->_group_del( $group_id );
                break;

            case 'data':
            default:
                $this->_group_table();
                break;
        }
    }

    private function _group_del( $group_id )
    {
        //
    }

    private function _group_form( $group_id = NULL )
    {
        $group  = ( !is_null( $group_id ) ? $this->biauth->groups->get( $group_id ) : FALSE );

        $this->data['panel_title'] = $this->bitheme->set_title( $group ? 'Ubah data Kelompok pengguna '.$group->name : 'Buat kelompok pengguna baru' );
        $this->data['tool_buttons']['data'] = 'Kembali|default';

        $fields['group-name'] = array(
            'type'  => 'text',
            'label' => 'Nama lengkap',
            'std'   => ( $group ? $group->name : '' ),
            'validation'=> 'required',
            'desc'  => 'Nama lengkap untuk kelompok pengguna, diperbolehkan menggunakan spasi.'
            );

        $fields['group-key'] = array(
            'type'  => 'text',
            'label' => 'Nama singkat',
            'std'   => ( $group ? $group->key : '' ),
            'validation'=> 'required',
            'desc'  => 'Nama singkat untuk kelompok pengguna, tidak diperbolehkan menggunakan spasi.'
            );

        $fields['group-desc'] = array(
            'type'  => 'textarea',
            'label' => 'Keterangan',
            'std'   => ( $group ? $group->description : '' ),
            'desc'  => 'Keterangan singkat mengenai kelompok pengguna.'
            );

        $fields['group-default'] = array(
            'type'  => 'switch',
            'label' => 'Jadikan default',
            'option'=> array(
                1 => 'Ya',
                0 => 'Tidak'
                ),
            'std'   => ( $group ? $group->default : 0 ),
            'desc'  => 'Pilih <em>Ya</em> untuk menjadikna group ini sebagai group bawaan setiap mendambahkan pengguna baru, atau pilih <em>Tidak</em> untuk sebaliknya.'
            );

        $fields['group-perms'] = array(
            'type'  => 'checkbox',
            'label' => 'Wewenang Kelompok',
            'option'=> $this->biauth->permissions->fetch( TRUE ),
            'std'   => ( $group ? explode(',', $group->perm_id) : 0 ),
            'desc'  => ''
            );

        $this->load->library('biform');
        $form = $this->biform->initialize( array(
            'name'   => 'user-roles',
            'action' => current_url(),
            'fields' => $fields,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            $group_data = array(
                'key'         => $form_data['group-key'],
                'name'        => $form_data['group-name'],
                'default'     => $form_data['group-default'],
                'description' => ($form_data['group-desc'] ?: '-'),
                'perms'       => $form_data['group-perms'],
                );

            $result = $this->biauth->edit_group( $group_id, $group_data );

            foreach ( get_message() as $level => $message )
            {
                $this->session->set_flashdata( $level, $message );
            }

            $this->data['page_link'] .= ( $group ? 'form/'.$group_id : '' );

            redirect( $result ? $this->data['page_link'] : current_url() );
        }
        else
        {
            $this->data['panel_body'] = $form->generate();
        }

        $this->load->theme('dataform', $this->data);
    }

    private function _group_table()
    {
        $this->data['panel_title'] = $this->bitheme->set_title('Semua data kelompok pengguna');
        $this->data['tool_buttons']['form'] = 'Baru|primary';
        $this->data['data_page'] = TRUE;

        $this->load->library('bitable', array(
            'base_url' => $this->data['page_link'],
            ));

        $grid = $this->bitable->set_column('Kelompok', 'name, perm_count, callback_make_tag:perm_desc', '65%', '<strong>%s</strong> <small class="text-muted">Dengan %s wewenang, antara lain:</small><br>%s')
                              ->set_column('Default', 'callback_bool_to_str:default', '20%', '<span class="badge">%s</span>')
                              ->set_button('form', 'Lihat data');

        $this->data['panel_body'] = $grid->generate( $this->biauth->groups->fetch() );

        $this->load->theme('dataform', $this->data);
    }

    public function permission( $page = '', $perm_id = '' )
    {
        switch ( $page ) {
            case 'form':
                $this->_perm_form( $perm_id );
                break;

            case 'hapus':
                $this->_perm_del( $perm_id );
                break;

            case 'data':
            case 'page':
            default:
                $this->_perm_table();
                break;
        }
    }

    private function _perm_del( $perm_id )
    {
        //
    }

    private function _perm_form( $perm_id = '' )
    {
        $perm = ( $perm_id != '' ? $this->biauth->permissions->get( $perm_id ) : FALSE );

        $this->data['panel_title'] = $this->bitheme->set_title( $perm ? 'Ubah data Hak akses pengguna '.$perm->permission : 'Buat Hak akses pengguna baru' );

        $this->data['tool_buttons']['permission'] = 'Kembali|default';

        $fields['perm-sort'] = array(
            'type'  => 'text',
            'label' => 'Nama singkat',
            'std'   => ( $perm ? $perm->permission : '' ),
            'desc'  => 'Nama singkan untuk Hak akses pengguna, tidak diperbolehkan menggunakan spasi.',
            'validation'=> ( !$perm ? 'required' : '' )
            );

        $fields['perm-desc'] = array(
            'type'  => 'text',
            'label' => 'Nama lengkap',
            'std'   => ( $perm ? $perm->description : '' ),
            'desc'  => 'Nama lengkap untuk Hak akses pengguna, diperbolehkan menggunakan spasi.',
            'validation'=> ( !$perm ? 'required' : '' )
            );

        $fields['perm-parent'] = array(
            'type'  => 'dropdown',
            'label' => 'Difisi',
            'option'=> $this->biauth->permissions->fetch_parents(),
            'std'   => ( $perm ? $perm->parent : 0 ),
            'desc'  => 'Pilih <em>Ya</em> untuk menjadikna perm ini sebagai perm bawaan setiap mendambahkan pengguna baru, atau pilih <em>Tidak</em> untuk sebaliknya.',
            'validation'=> ( !$perm ? 'required' : '' )
            );

        $this->load->library('biform');

        $form = $this->biform->initialize( array(
            'name' => 'user-perm',
            'action' => current_url(),
            'fields' => $fields,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            if ( $perm_id == '' )
            {
                $user_data['role']    = $form_data['perm-role'];
                $user_data['full']    = $form_data['perm-full'];
                $user_data['default'] = $form_data['perm-default'];

                $result = $this->biauth->create_user( $user_data, $use_username );
            }
            else
            {
                $result = $this->biauth->update_user( $perm_id, $form->submited_data(), $use_username );
            }

            foreach ( $this->biauth->messages() as $level => $message )
            {
                $this->session->set_flashdata( $level, $message );
            }

            redirect( $result ? $this->data['page_link'] : current_url() );
        }

        $this->data['panel_body'] = $form->generate();

        $this->load->theme('dataform', $this->data);
    }

    private function _perm_table()
    {
        $this->data['page_link'] = 'admin/pengguna/permission/';
        $this->data['tool_buttons']['form'] = 'Baru|primary';
        $this->data['data_page'] = TRUE;

        $this->set_panel_title('Semua data hak akses pengguna');
        $this->load->library('bitable', array(
            'identifier' => 'permission_id',
            'base_url'   => $this->data['page_link'],
            ));

        $grid = $this->bitable->set_column('Hak akses', 'description, permission', '45%', '<strong>%s</strong><br><small>%s</small>')
                            ->set_column('Difisi', 'parent', '40%')
                            ->set_button('form', 'Lihat data')
                            ->set_button('delete', 'Hapus data');

        $this->data['panel_body'] = $grid->generate( $this->biauth->permissions->fetch() );

        $this->load->theme('dataform', $this->data);
    }
}

/* End of file pengguna.php */
/* Location: ./application/controllers/pengguna.php */
