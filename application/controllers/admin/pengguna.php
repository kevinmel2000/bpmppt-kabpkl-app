<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

        $this->verify_login(uri_string());

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
                $this->_user_form($user_id);
                break;
            case 'ban':
                $this->_user_ban($user_id);
                break;
            case 'delete':
                $this->_user_del($user_id);
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
        if ( !$this->authr->is_permited('users_manage') )
        {
            $this->_notice( 'access-denied' );
        }

        $this->data['tool_buttons']['form'] = 'Baru|primary';
        $this->data['tool_buttons'][]  = array(
            'activated/' => 'Aktif',
            'banned/' => 'Dicekal',
            'deleted/' => 'Terhapus' );

        $this->load->library('gridr', array(
            'base_url' => $this->data['page_link'],
            ));

        $grid = $this->gridr->set_column('Pengguna', 'id, display, username, email', '55%', '<a href="data/form/%s" class="bold">%s</a> <i class="text-muted">%s</i><br><small class="text-muted">%s</small>')
                            ->set_column('Kelompok', 'callback_make_tag:role_fullname', '20%')
                            ->set_column('Status', _x($status), '10%', '<span class="label label-default">%s</span>');

        if ($status == 'activated')
        {
            // $status = 'Aktif';
            $grid->set_button('form', 'Lihat pengguna')
                 ->set_button('cekal', 'Cekal pengguna')
                 ->set_button('hapus', 'Hapus pengguna');
        }
        elseif ($status == 'banned')
        {
            // $status = 'Dicekal';
            $grid->set_button('form', 'Lihat pengguna')
                 ->set_button('unban', 'Batalkan pencekalan')
                 ->set_button('hapus', 'Hapus pengguna');
        }
        elseif ($status == 'deleted')
        {
            // $status = 'Terhapus';
            $grid->set_button('cekal', 'Cekal pengguna')
                 ->set_button('undelete', 'Batalkan penghapusan');
        }

        $this->set_panel_title('Semua data penggunas: '._x($status));
        $this->data['panel_body'] = $grid->generate( $this->authr->users->fetch($status) );

        $this->load->theme('pages/panel_data', $this->data);
    }

    public function profile()
    {
        $this->_user_form( $this->authr->get_user_id() );
    }

    private function _user_form( $user_id = '' )
    {
        if ( $user_id == $this->current_user['user_id'] AND strpos( current_url(), 'profile' ) === FALSE )
        {
            redirect('profile');
        }

        $user   = ( $user_id != '' ? $this->authr->users->get( $user_id ) : FALSE );
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
        }
        else
        {
            $this->data['tool_buttons']['data'] = 'Kembali|default';
        }

        if ( $user and $user_id != $this->current_user['user_id'] and $this->authr->is_permited('users_manage') )
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

        $fields[]   = array(
            'name'  => 'user-display',
            'type'  => 'text',
            'label' => 'Nama Lengkap',
            'std'   => ( $user ? $user->display : '' ),
            'desc'  => 'Mohon untuk menggunakan nama asli.',
            'validation'=> 'required' );

        if ( (bool) $this->bakaigniter->get_setting('auth_use_username') )
        {
            $username_min_length = $this->bakaigniter->get_setting('auth_username_length_min');
            $username_max_length = $this->bakaigniter->get_setting('auth_username_length_max');

            $fields[]   = array(
                'name'  => 'user-username',
                'type'  => 'text',
                'label' => 'Username',
                'std'   => ( $user ? $user->username : '' ),
                'desc'  => 'Username tidak boleh menggunakan spasi dan harus diisi dengan minimal '.$username_min_length.' dan maksimal '.$username_max_length.' karakter.',
                'validation'=> 'required|is_username_available|valid_username_length|is_username_blacklist' );
        }

        $fields[]   = array(
            'name'  => 'user-email',
            'type'  => 'email',
            'label' => 'Email',
            'std'   => ( $user ? $user->email : '' ),
            'desc'  => 'Dengan alasan keamanan mohon gunakan email aktif anda.',
            'validation'=> 'required|is_email_available|valid_email' );

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

        $password_min_length = $this->bakaigniter->get_setting('auth_password_length_min');
        $password_max_length = $this->bakaigniter->get_setting('auth_password_length_max');

        $fields[]   = array(
            'name'  => 'user-new-password',
            'type'  => 'password',
            'label' => ( !$user ? 'Password' : 'Password baru' ),
            'desc'  => 'Password harus diisi dengan minimal '.$password_min_length.' dan maksimal '.$password_max_length.' karakter.',
            'validation'=> ( !$user ? 'required|' : '' ).'valid_password_length');

        $fields[]   = array(
            'name'  => 'user-confirm-password',
            'type'  => 'password',
            'label' => 'Konfirmasi Password',
            'desc'  => 'Ulangi penulisan '.( !$user ? 'Password' : 'Password baru' ).' diatas.',
            'validation'=> ( !$user ? 'required|' : '' ).'matches[user-new-password]');

        if ( $user_id != $this->current_user['user_id'] and $this->authr->is_permited('roles_manage') )
        {
            $fields[]   = array(
                'name'  => 'app-fieldset-roles',
                'type'  => 'fieldset',
                'label' => 'Kelompok' );

            $fields[]   = array(
                'name'  => 'user-roles',
                'type'  => 'checkbox',
                'label' => 'Kelompok pengguna',
                'option'=> $this->authr->roles->fetch_assoc(),
                'std'   => ( $user ? $this->authr->user_roles->get( $user->id ) : '' ),
                'validation'=> ( !$user ? 'required' : '' ) );
        }

        if ( $user and !$user->deleted )
        {
            $fields[]   = array(
                'name'  => 'app-fieldset-status',
                'type'  => 'fieldset',
                'label' => 'Status' );

            $this->load->library('table');

            $this->table->set_template(array(
                'table_open' => '<table class="table table-striped table-bordered table-hover table-condensed">'
                ));

            $this->table->set_heading(array(
                array(
                    'data' => 'Nama',
                    'width' => '26%',
                    ),
                array(
                    'data' => 'Nilai',
                    'width' => '74%',
                    )
                ));

            $is_banned = (bool) $user->banned;
            $user_info = array(
                'Aktif' => (bool) $user->activated ? twb_label('Ya', 'success') : twb_label('Tidak', 'danger'),
                'Dibuat pada' => format_datetime($user->created),
                'Login terakhir' => format_datetime($user->last_login),
                'Dicekal' => $is_banned ? twb_label('Ya', 'danger') : twb_label('Tidak', 'success'),
                );

            if ( $is_banned )
            {
                $user_info['Alasan pencekalan'] = $user->ban_reason;
            }

            foreach ($user_info as $key => $val)
            {
                $this->table->add_row($key, $val);
            }

            $fields[]   = array(
                'name'  => 'user-status',
                'type'  => 'custom',
                'label' => 'Status Pengguna',
                'value' => $this->table->generate() );

            $this->table->clear();
        }

        $this->load->library('former');

        $form = $this->former->init( array(
            'name'   => 'user-form',
            'action' => current_url(),
            'fields' => $fields,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            if ( !$user )
            {
                $result = $this->authr->create_user(
                    $form_data['user-display'],
                    $form_data['user-username'],
                    $form_data['user-email'],
                    $form_data['user-new-password'],
                    $form_data['user-roles']
                    );
            }
            else
            {
                $result   = $this->authr->update_user(
                    $user_id,
                    $form_data['user-display'],
                    $form_data['user-username'],
                    $form_data['user-email'],
                    $form_data['user-old-password'],
                    $form_data['user-new-password'],
                    $form_data['user-roles']
                    );
            }

            foreach ( get_message() as $level => $message )
            {
                $this->session->set_flashdata( $level, $message );
            }

            redirect( $result ? $this->data['page_link'] : current_url() );
        }

        $this->data['panel_body'] = $form->generate();

        $this->load->theme('pages/panel_form', $this->data);
    }

    private function _user_del( $user_id )
    {
        if ( $this->authr->remove_user( $user_id ) )
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

    private function _user_ban( $user_id )
    {
        $username = $this->authr->users->get( $user_id )->username;

        $this->set_panel_title('Cekal pengguna: '.$username);

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

        $this->load->library('former');

        $form = $this->former->init( array(
            'name' => 'user-ban',
            'action' => current_url(),
            'fields' => $fields,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            if ( $this->authr->users->ban( $user_id, $form_data['ban-reason'] ) )
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
            $child_id   = strpos($perms->perm_id, ',') !== FALSE   ? explode(',', $perms->perm_id)   : array($perms->perm_id) ;
            $child_name = strpos($perms->perm_name, ',') !== FALSE ? explode(',', $perms->perm_name) : array($perms->perm_name) ;
            $child_desc = strpos($perms->perm_desc, ',') !== FALSE ? explode(',', $perms->perm_desc) : array($perms->perm_desc) ;

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

        $this->load->library('former');

        $form = $this->former->init( array(
            'name'   => 'user-roles',
            'action' => current_url(),
            'fields' => $fields,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            $role_data['role']    = $form_data['group-role'];
            $role_data['full']    = $form_data['group-full'];
            $role_data['default'] = $form_data['group-default'];
            $perm_data            = array();

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

        // $this->data['panel_body'] = $form->generate();

        $this->load->theme('pages/panel_form', $this->data);
    }

    private function _group_table()
    {
        $this->data['panel_title'] = $this->themee->set_title('Semua data kelompok pengguna');
        $this->data['tool_buttons']['form'] = 'Baru|primary';

        $this->load->library('gridr', array(
            'base_url'   => $this->data['page_link'],
            ));

        $grid = $this->gridr->set_column('Kelompok', 'full, perm_count, callback_make_tag:perm_desc', '65%', '<strong>%s</strong> <small class="text-muted">Dengan %s wewenang, antara lain:</small><br>%s')
                            ->set_column('Default', 'callback_bool_to_str:default', '20%', '<span class="badge">%s</span>')
                            ->set_button('form', 'Lihat data')
                            ->set_button('delete', 'Hapus data');

        $this->data['panel_body'] = $grid->generate( $this->authr->roles->fetch() );

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

        $this->load->library('former');

        $form = $this->former->init( array(
            'name' => 'user-perm',
            'action' => current_url(),
            'fields' => $fields,
            ));

        if ( $form_data = $form->validate_submition() )
        {
            if ( $perm_id == '' )
            {
                $form_data =  $form->submited_data();

                $user_data['role']    = $form_data['perm-role'];
                $user_data['full']    = $form_data['perm-full'];
                $user_data['default'] = $form_data['perm-default'];

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
        $this->set_panel_title('Semua data hak akses pengguna');
        $this->data['tool_buttons']['form'] = 'Baru|primary';

        $this->load->library('gridr', array(
            'identifier' => 'permission_id',
            'base_url'   => $this->data['page_link'],
            ));

        $grid = $this->gridr->set_column('Hak akses', 'description, permission', '45%', '<strong>%s</strong><br><small>%s</small>')
                            ->set_column('Difisi', 'parent', '40%')
                            ->set_button('form', 'Lihat data')
                            ->set_button('delete', 'Hapus data');

        $this->data['panel_body'] = $grid->generate( $this->authr->permissions->fetch() );

        $this->load->theme('pages/panel_data', $this->data);
    }
}

/* End of file pengguna.php */
/* Location: ./application/controllers/pengguna.php */
