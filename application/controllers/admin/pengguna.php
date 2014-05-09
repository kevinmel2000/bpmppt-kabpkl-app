<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
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
 * @license     http://opensource.org/licenses/OSL-3.0
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

/**
 * Pengguna Class
 *
 * @subpackage  Controller
 */
class Pengguna extends BAKA_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->verify_login();

        $this->themee->add_navbar( 'admin_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
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
                $this->_user_form( $user_id );
                break;

            case 'cekal':
                $this->_user_ban( $user_id );
                break;

            case 'hapus':
                $this->_user_del( $user_id );
                break;

            case 'data':
            default:
                $this->_user_table();
                break;
        }
    }

    private function _user_table()
    {
        if ( !$this->authr->is_permited('users_manage') )
            $this->_notice( 'access-denied' );

        $this->data['tool_buttons']['form'] = 'Baru|primary';

        $this->load->library('baka_pack/gridr');

        $grid = $this->gridr->identifier('id')
                            ->set_baseurl($this->data['page_link'])
                            ->set_column('Pengguna', 'username, email', '45%', FALSE, '<strong>%s</strong><br><small class="text-muted">%s</small>')
                            ->set_column('Kelompok', 'callback_make_tag:role_fullname', '40%', FALSE, '%s')
                            ->set_buttons('form/', 'eye-open', 'primary', 'Lihat pengguna')
                            ->set_buttons('cekal/', 'eye-open', 'primary', 'Cekal pengguna')
                            ->set_buttons('hapus/', 'trash', 'danger', 'Hapus pengguna');

        $this->data['panel_title'] = $this->themee->set_title('Semua data pengguna');
        $this->data['panel_body'] = $grid->make_table( $this->authr->users->fetch() );

        $this->load->theme('pages/panel_data', $this->data);
    }

    public function profile()
    {
        $this->_user_form( $this->authr->get_user_id() );
    }

    private function _user_form( $user_id = '' )
    {
        if ( $user_id == $this->current_user['user_id'] AND strpos( current_url(), 'profile' ) === FALSE )
            redirect('profile');

        $user   = ( $user_id != '' ? $this->authr->users->get( $user_id ) : FALSE );
        $judul  = ( $user_id == $this->current_user['user_id'] ? 'Profile anda: ' : 'Data pengguna: ');

        $this->data['panel_title'] = $this->themee->set_title( ( $user ? $judul.$user->username : 'Buat pengguna baru' ));
        
        $this->data['tool_buttons']['data'] = 'Kembali|default';

        if ( $user )
        {
            if ( $user_id != $this->current_user['user_id'] and $this->authr->is_permited('users_manage') )
            {
                $this->data['tool_buttons']['aksi|danger']  = array(
                    'cekal/'.$user_id => 'Cekal',
                    'hapus/'.$user_id => 'Hapus' );
            }
        }

        if ( (bool) Setting::get('auth_use_username') )
        {
            $username_min_length = Setting::get('auth_username_min_length');
            $username_max_length = Setting::get('auth_username_max_length');

            $fields[]   = array(
                'name'  => 'user-username',
                'type'  => 'text',
                'label' => 'Username',
                'std'   => ( $user ? $user->username : '' ),
                'desc'  => ( !$user ? 'Username harus diisi dengan minimal '.$username_min_length.' dan maksimal '.$username_max_length.' karakter.' : '' ),
                'validation'=> ( !$user ? 'required|is_username_available' : '' ).'valid_username_length|is_username_blacklist' );
        }

        $fields[]   = array(
            'name'  => 'user-email',
            'type'  => 'email',
            'label' => 'Email',
            'std'   => ( $user ? $user->email : '' ),
            'desc'  => ( !$user ? 'Dengan alasan keamanan mohon gunakan email aktif anda.' : '' ),
            'validation'=> ( !$user ? 'required|is_email_available' : '' ).'valid_email' );

        if ( $user )
        {
            $fields[]   = array(
                'name'  => 'app-fieldset-password',
                'type'  => 'fieldset',
                'label' => 'Ganti password' );

            $fields[]   = array(
                'name'  => 'user-old-password',
                'type'  => 'password',
                'label' => 'Password lama' );
        }

        $password_min_length = Setting::get('auth_password_min_length');
        $password_max_length = Setting::get('auth_password_max_length');

        $fields[]   = array(
            'name'  => 'user-new-password',
            'type'  => 'password',
            'label' => ( !$user ? 'Password' : 'Password baru' ),
            'desc'  => ( !$user ? 'Password harus diisi dengan minimal '.$password_min_length.' dan maksimal '.$password_max_length.' karakter.' : '' ),
            'validation'=> ( !$user ? 'required|' : '' ).'valid_password_length');

        $fields[]   = array(
            'name'  => 'user-confirm-password',
            'type'  => 'password',
            'label' => 'Konfirmasi Password',
            'desc'  => ( !$user ? 'Ulangi penulisan password diatas.' : '' ),
            'validation'=> ( !$user ? 'required|' : '' ).'matches[user-new-password]');

        if ( $user_id != $this->current_user['user_id'] and $this->authr->is_permited('roles_manage') )
        {
            $fields[]   = array(
                'name'  => 'app-fieldset-roles',
                'type'  => 'fieldset',
                'label' => 'Hak Akses' );

            $fields[]   = array(
                'name'  => 'user-roles',
                'type'  => 'checkbox',
                'label' => 'Kelompok pengguna',
                'option'=> $this->authr->roles->fetch_assoc(),
                'std'   => ( $user ? $this->authr->user_roles->get( $user->id ) : '' ),
                'validation'=> ( !$user ? 'required' : '' ) );
        }

        if ( $user )
        {
            $fields[]   = array(
                'name'  => 'app-fieldset-status',
                'type'  => 'fieldset',
                'label' => 'Status' );

            $fields[]   = array(
                'name'  => 'user-activated',
                'type'  => 'static',
                'label' => 'Aktif',
                'std'   => (bool) $user->activated ? twb_label('Ya', 'success') : twb_label('Tidak', 'danger') );

            $fields[]   = array(
                'name'  => 'user-last-login',
                'type'  => 'static',
                'label' => 'Dibuat pada',
                'std'   => format_datetime($user->created) );

            $fields[]   = array(
                'name'  => 'user-banned',
                'type'  => 'static',
                'label' => 'Dicekal',
                'std'   => (bool) $user->banned ? twb_label('Ya', 'danger') : twb_label('Tidak', 'success') );

            if ( (bool) $user->banned )
            {
                $fields[]   = array(
                    'name'  => 'user-ban-reason',
                    'type'  => 'static',
                    'label' => 'Alasan pencekalan',
                    'std'   => $user->ban_reason );
            }

            $fields[]   = array(
                'name'  => 'user-last-login',
                'type'  => 'static',
                'label' => 'Login terakhir',
                'std'   => format_datetime($user->last_login) );
        }

        $this->load->library('baka_pack/former');

        $form = $this->former->init( array(
            'name'   => 'user-form',
            'action' => current_url(),
            'fields' => $fields,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            $username   = $form_data['user-username'];
            $email      = $form_data['user-email'];
            $password   = $form_data['user-new-password'];

            $roles = array();
            if ( isset( $form_data['user-roles'] ) )
            {
                $roles = $form_data['user-roles'];
            }

            if ( !$user )
            {
                $result = $this->authr->create_user( $username, $email, $password, $roles );
            }
            else
            {
                $old_pass = $form_data['user-old-password'];

                $result = $this->authr->update_user( $user_id, $username, $email, $old_pass, $password, $roles );
            }

            foreach ( Messg::get() as $level => $message )
            {
                $this->session->set_flashdata( $level, $message );
            }

            // redirect( $result ? $this->data['page_link'] : current_url() );
        }

        $this->data['panel_body'] = $form->generate();

        $this->load->theme('pages/panel_form', $this->data);
    }

    private function _user_del( $user_id )
    {
        if ( $this->authr->remove_user( $user_id ) )
        {
            $this->session->set_flashdata('success', Messg::get('success'));
            redirect( $this->data['page_link'] );
        }
        else
        {
            $this->session->set_flashdata('error', Messg::get('error'));
            redirect( current_url() );
        }
    }

    private function _user_ban( $user_id )
    {
        $username = $this->authr->users->get( $user_id )->username;

        $this->data['panel_title']  = $this->themee->set_title('Cekal pengguna: '.$username);

        $fields[]   = array(
            'name'  => 'ban-user',
            'type'  => 'text',
            'label' => 'Nama Pengguna',
            'attr'  => 'disabled',
            'std'   => $username );

        $fields[]   = array(
            'name'  => 'ban-reason',
            'type'  => 'textarea',
            'label' => 'Alasan pencekalan',
            'desc'  => 'Mohon tuliskan secara lengkap alasan pencekalan pengguna "'.$username.'".',
            'validation'=> 'required' );

        $this->load->library('baka_pack/former');

        $form = $this->former->init( array(
            'name' => 'user-ban',
            'action' => current_url(),
            'fields' => $fields,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            $result     = $this->authr->ban_user( $user_id, $form_data['ban-reason'] );

            if ( $result )
            {
                $this->session->set_flashdata('success', $this->authr->messages('success'));
                redirect( $this->data['page_link'] );
            }
            else
            {
                $this->session->set_flashdata('error', $this->authr->messages('error'));
                redirect( current_url() );
            }
        }

        $this->data['panel_body'] = $form->generate();

        $this->load->theme('pages/panel_form', $this->data);
    }

    public function groups( $page = '', $group_id = NULL )
    {
        $this->data['page_link']    .= 'groups/';

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
        $group  = ( !is_null( $group_id ) ? $this->authr->roles->get( $group_id ) : FALSE );

        $this->data['panel_title'] = $this->themee->set_title( $group ? 'Ubah data Kelompok pengguna '.$group->full : 'Buat kelompok pengguna baru' );
        
        $this->data['tool_buttons']['data'] = 'Kembali|default';

        $fields[]   = array(
            'name'  => 'group-full',
            'type'  => 'text',
            'label' => 'Nama lengkap',
            'std'   => ( $group ? $group->full : '' ),
            'validation'=> 'required',
            'desc'  => 'Nama lengkap untuk kelompok pengguna, diperbolehkan menggunakan spasi.' );

        $fields[]   = array(
            'name'  => 'group-role',
            'type'  => 'text',
            'label' => 'Nama singkat',
            'std'   => ( $group ? $group->name : '' ),
            'validation'=> 'required',
            'desc'  => 'Nama singkat untuk kelompok pengguna, tidak diperbolehkan menggunakan spasi.' );

        $fields[]   = array(
            'name'  => 'group-default',
            'type'  => 'radio',
            'label' => 'Jadikan default',
            'option'=> array(
                1 => 'Ya',
                0 => 'Tidak' ),
            'std'   => ( $group ? $group->default : 0 ),
            'validation'=> 'required',
            'desc'  => 'Pilih <em>Ya</em> untuk menjadikna group ini sebagai group bawaan setiap mendambahkan pengguna baru, atau pilih <em>Tidak</em> untuk sebaliknya.' );

        $fields[]   = array(
            'name'  => 'group-fieldset-perms',
            'type'  => 'fieldset',
            'label' => 'Wewenang Kelompok' );

        $permissions = $this->authr->permissions->fetch_grouped();

        foreach ( $permissions as $perms )
        {
            $child_id   = strpos($perms->perm_id, ',') !== FALSE    ? explode(',', $perms->perm_id)     : array($perms->perm_id) ;
            $child_name = strpos($perms->perm_name, ',') !== FALSE  ? explode(',', $perms->perm_name)   : array($perms->perm_name) ;
            $child_desc = strpos($perms->perm_desc, ',') !== FALSE  ? explode(',', $perms->perm_desc)   : array($perms->perm_desc) ;

            $permission = array();

            foreach ($child_id as $i => $id)
            {
                $permission[$id] = (isset( $child_desc[$i] ) AND $child_desc[$i] != '-') ? $child_desc[$i] : $child_name[$i];
            }

            $fields[]   = array(
                'name'  => 'group-perms-'.str_replace(' ', '-', strtolower($perms->parent)),
                'type'  => 'checkbox',
                'label' => $perms->parent,
                'option'=> $permission,
                'std'   => ( $group ? explode(',', $group->perm_id) : 0 ),
                'desc'  => '' );
        }

        $this->load->library('baka_pack/former');

        $form = $this->former->init( array(
            'name' => 'user-roles',
            'action' => current_url(),
            'fields' => $fields,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            $role_data['role']      = $form_data['group-role'];
            $role_data['full']      = $form_data['group-full'];
            $role_data['default']   = $form_data['group-default'];
            $perm_data              = array();

            foreach ( $permissions as $permission )
            {
                $perm_parent = 'group-perms-'.str_replace(' ', '-', strtolower($permission->parent));

                if ( $form_data[$perm_parent] )
                {
                    foreach ( $form_data[$perm_parent] as $parent )
                    {
                        $perm_data[] = $parent;
                    }
                }
            }

            $result = $this->authr->roles->update( $role_data, $group_id, $perm_data );

            foreach ( $this->authr->messages() as $level => $message )
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

        // $this->data['panel_body'] = $form->generate();

        $this->load->theme('pages/panel_form', $this->data);
    }

    private function _group_table()
    {
        $this->data['panel_title'] = $this->themee->set_title('Semua data kelompok pengguna');
        $this->data['tool_buttons']['form'] = 'Baru|primary';

        $this->load->library('baka_pack/gridr');

        $grid = $this->gridr->identifier('id')
                            ->set_baseurl($this->data['page_link'])
                            ->set_column('Kelompok', 'full, perm_count, callback_make_tag:perm_desc', '65%', FALSE, '<strong>%s</strong> <small class="text-muted">Dengan %s wewenang, antara lain:</small><br>%s')
                            ->set_column('Default', 'callback_bool_to_str:default', '20%', FALSE, '<span class="badge">%s</span>')
                            ->set_buttons('form/', 'eye-open', 'primary', 'Lihat data')
                            ->set_buttons('delete/', 'trash', 'danger', 'Hapus data');

        $this->data['panel_body'] = $grid->make_table( $this->authr->roles->fetch() );

        $this->load->theme('pages/panel_data', $this->data);
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
        $perm = ( $perm_id != '' ? $this->authr->permissions->get( $perm_id ) : FALSE );

        $this->data['panel_title'] = $this->themee->set_title( $perm ? 'Ubah data Hak akses pengguna '.$perm->permission : 'Buat Hak akses pengguna baru' );
        
        $this->data['tool_buttons']['permission'] = 'Kembali|default';

        $fields[]   = array(
            'name'  => 'perm-sort',
            'type'  => 'text',
            'label' => 'Nama singkat',
            'std'   => ( $perm ? $perm->permission : '' ),
            'desc'  => 'Nama singkan untuk Hak akses pengguna, tidak diperbolehkan menggunakan spasi.',
            'validation'=> ( !$perm ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => 'perm-desc',
            'type'  => 'text',
            'label' => 'Nama lengkap',
            'std'   => ( $perm ? $perm->description : '' ),
            'desc'  => 'Nama lengkap untuk Hak akses pengguna, diperbolehkan menggunakan spasi.',
            'validation'=> ( !$perm ? 'required' : '' ) );

        $fields[]   = array(
            'name'  => 'perm-parent',
            'type'  => 'dropdown',
            'label' => 'Difisi',
            'option'=> $this->authr->permissions->fetch_parents(),
            'std'   => ( $perm ? $perm->parent : 0 ),
            'desc'  => 'Pilih <em>Ya</em> untuk menjadikna perm ini sebagai perm bawaan setiap mendambahkan pengguna baru, atau pilih <em>Tidak</em> untuk sebaliknya.',
            'validation'=> ( !$perm ? 'required' : '' ) );

        $this->load->library('baka_pack/former');

        $form = $this->former->init( array(
            'name' => 'user-perm',
            'action' => current_url(),
            'fields' => $fields,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            if ( $perm_id == '' )
            {
                $form_data  =  $form->submited_data();

                $user_data['role']      = $form_data['perm-role'];
                $user_data['full']      = $form_data['perm-full'];
                $user_data['default']   = $form_data['perm-default'];

                $result = $this->authr->create_user( $user_data, $use_username );
            }
            else
            {
                $result = $this->authr->update_user( $perm_id, $form->submited_data(), $use_username );
            }

            foreach ( $this->authr->messages() as $level => $message )
            {
                $this->session->set_flashdata( $level, $message );
            }

            redirect( $result ? $this->data['page_link'] : current_url() );
        }

        $this->data['panel_body'] = $form->generate();

        $this->load->theme('pages/panel_form', $this->data);
    }

    private function _perm_table()
    {
        $this->data['page_link']    = 'admin/pengguna/permission/';
        $this->data['panel_title']  = $this->themee->set_title('Semua data hak akses pengguna');
        $this->data['tool_buttons']['form'] = 'Baru|primary';

        $this->load->library('baka_pack/gridr');

        $grid = $this->gridr->identifier('permission_id')
                            ->set_baseurl($this->data['page_link'])
                            ->set_column('Hak akses', 'description, permission', '45%', TRUE, '<strong>%s</strong><br><small>%s</small>')
                            ->set_column('Difisi', 'parent', '40%')
                            ->set_buttons('form/', 'eye-open', 'primary', 'Lihat data')
                            ->set_buttons('delete/', 'trash', 'danger', 'Hapus data');

        $this->data['panel_body'] = $grid->make_table( $this->authr->permissions->fetch() );

        $this->load->theme('pages/panel_data', $this->data);
    }
}

/* End of file pengguna.php */
/* Location: ./application/controllers/pengguna.php */