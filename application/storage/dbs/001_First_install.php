<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_First_install extends Migration
{
    // -------------------------------------------------------------------------
    // Table Names
    // -------------------------------------------------------------------------

    /**
     * Media table name
     *
     * @var  string
     */
    private $media_table             = 'media';

    /**
     * System_opt table name
     *
     * @var  string
     */
    private $system_opt_table        = 'system_opt';

    /**
     * System_env table name
     *
     * @var  string
     */
    private $system_env_table        = 'system_env';

    /**
     * Users table name
     *
     * @var  string
     */
    private $users_table             = 'auth_users';

    /**
     * User_meta table name
     *
     * @var  string
     */
    private $user_meta_table         = 'auth_user_meta';

    /**
     * User_group table name
     *
     * @var  string
     */
    private $user_role_table         = 'auth_user_roles';

    /**
     * User_meta table name
     *
     * @var  string
     */
    private $roles_table             = 'auth_roles';

    /**
     * User_permission table name
     *
     * @var  string
     */
    private $permissions_table       = 'auth_permissions';

    /**
     * User_permission table name
     *
     * @var  string
     */
    private $role_perms_table        = 'auth_role_permissions';

    /**
     * User_permission table name
     *
     * @var  string
     */
    private $overrides_table         = 'auth_overrides';

    /**
     * Users table name
     *
     * @var  string
     */
    private $user_autologin_table    = 'auth_user_autologin';

    /**
     * Users table name
     *
     * @var  string
     */
    private $login_attempts_table    = 'auth_login_attempts';

    // -------------------------------------------------------------------------
    // Field Definitions
    // -------------------------------------------------------------------------

    /**
     * Media fields
     *
     * @var  string
     */
    private $media_fields             = array(
        'id' => array(
            'type'           => 'INT',
            'constraint'     => 11,
            'auto_increment' => true,
            'null'           => false,
            ),
        'uploaded' => array(
            'type' => 'DATETIME',
            'constraint' => 11,
            'default' => '0000-00-00 00:00:00',
            'null' => false,
            ),
        'title' => array(
            'type' => 'VARCHAR',
            'constraint' => 50,
            'null' => false,
            ),
        'filename' => array(
            'type' => 'VARCHAR',
            'constraint' => 50,
            'null' => false,
            ),
        'path' => array(
            'type' => 'VARCHAR',
            'constraint' => 255,
            'null' => false,
            ),
        'mime' => array(
            'type' => 'VARCHAR',
            'constraint' => 15,
            'null' => false,
            ),
        'ext' => array(
            'type' => 'VARCHAR',
            'constraint' => 5,
            'null' => false,
            ),
        'size' => array(
            'type' => 'INT',
            'constraint' => 11,
            'null' => false,
            ),
        'width' => array(
            'type' => 'INT',
            'constraint' => 11,
            'null' => false,
            ),
        'height' => array(
            'type' => 'INT',
            'constraint' => 11,
            'null' => false,
            ),
        );

    /**
     * System_opt fields
     *
     * @var  string
     */
    private $system_opt_fields        = array(
        'id' => array(
            'type'           => 'INT',
            'constraint'     => 11,
            'auto_increment' => true,
            'null'           => false,
            ),
        'opt_key' => array(
            'type' => 'VARCHAR',
            'constraint' => 100,
            'null' => false,
            ),
        'opt_value' => array(
            'type' => 'LONGTEXT',
            ),
        );

    /**
     * System_env fields
     *
     * @var  string
     */
    private $system_env_fields        = array(
        'id' => array(
            'type'           => 'INT',
            'constraint'     => 11,
            'auto_increment' => true,
            'null'           => false,
            ),
        'user_id' => array(
            'type' => 'INT',
            'constraint' => 11,
            'default' => 0,
            'null' => false,
            ),
        'env_key' => array(
            'type' => 'VARCHAR',
            'constraint' => 100,
            'null' => false,
            ),
        'env_value' => array(
            'type' => 'LONGTEXT',
            ),
        );

    /**
     * Users fields
     *
     * @var  string
     */
    private $users_fields             = array(
        'id' => array(
            'type'           => 'INT',
            'constraint'     => 11,
            'auto_increment' => true,
            'null'           => false,
            ),
        'username' => array(
            'type' => 'VARCHAR',
            'constraint' => 100,
            'null' => false,
            ),
        'password' => array(
            'type' => 'VARCHAR',
            'constraint' => 255,
            'null' => false,
            ),
        'email' => array(
            'type' => 'VARCHAR',
            'constraint' => 100,
            'null' => false,
            ),
        'activated' => array(
            'type' => 'TINYINT',
            'constraint' => 1,
            'default' => 0,
            'null' => false,
            ),
        'banned' => array(
            'type' => 'TINYINT',
            'constraint' => 1,
            'default' => 0,
            'null' => false,
            ),
        'deleted' => array(
            'type' => 'TINYINT',
            'constraint' => 1,
            'default' => 0,
            'null' => false,
            ),
        'ban_reason' => array(
            'type' => 'VARCHAR',
            'constraint' => 255,
            'default' => null,
            ),
        'new_password_key' => array(
            'type' => '',
            'constraint' => 11,
            'default' => '',
            'null' => false,
            ),
        'new_password_requested' => array(
            'type' => '',
            'constraint' => 11,
            'default' => '',
            'null' => false,
            ),
        'new_email' => array(
            'type' => '',
            'constraint' => 11,
            'default' => '',
            'null' => false,
            ),
        'new_email_key' => array(
            'type' => '',
            'constraint' => 11,
            'default' => '',
            'null' => false,
            ),
        'last_ip' => array(
            'type' => '',
            'constraint' => 11,
            'default' => '',
            'null' => false,
            ),
        'last_login' => array(
            'type' => '',
            'constraint' => 11,
            'default' => '',
            'null' => false,
            ),
        'created' => array(
            'type' => '',
            'constraint' => 11,
            'default' => '',
            'null' => false,
            ),
        'modified' => array(
            'type' => '',
            'constraint' => 11,
            'default' => '',
            'null' => false,
            ),
        'log' => array(
            'type' => '',
            'constraint' => 11,
            'default' => '',
            'null' => false,
            ),
        );

    /**
     * User_meta fields
     *
     * @var  string
     */
    private $user_meta_fields         = array(
        'id' => array(
            'type'           => 'INT',
            'constraint'     => 11,
            'auto_increment' => true,
            'null'           => false,
            ),
        );

    /**
     * User_group fields
     *
     * @var  string
     */
    private $user_role_fields         = array(
        'id' => array(
            'type'           => 'INT',
            'constraint'     => 11,
            'auto_increment' => true,
            'null'           => false,
            ),
        );

    /**
     * User_meta fields
     *
     * @var  string
     */
    private $roles_fields             = array(
        'id' => array(
            'type'           => 'INT',
            'constraint'     => 11,
            'auto_increment' => true,
            'null'           => false,
            ),
        );

    /**
     * User_permission fields
     *
     * @var  string
     */
    private $permissions_fields       = array(
        'id' => array(
            'type'           => 'INT',
            'constraint'     => 11,
            'auto_increment' => true,
            'null'           => false,
            ),
        );

    /**
     * User_permission fields
     *
     * @var  string
     */
    private $role_perms_fields        = array(
        'id' => array(
            'type'           => 'INT',
            'constraint'     => 11,
            'auto_increment' => true,
            'null'           => false,
            ),
        );

    /**
     * User_permission fields
     *
     * @var  string
     */
    private $overrides_fields         = array(
        'id' => array(
            'type'           => 'INT',
            'constraint'     => 11,
            'auto_increment' => true,
            'null'           => false,
            ),
        );

    /**
     * Users fields
     *
     * @var  string
     */
    private $user_autologin_fields    = array(
        'id' => array(
            'type'           => 'INT',
            'constraint'     => 11,
            'auto_increment' => true,
            'null'           => false,
            ),
        );

    /**
     * Users fields
     *
     * @var  string
     */
    private $login_attempts_fields    = array(
        'id' => array(
            'type'           => 'INT',
            'constraint'     => 11,
            'auto_increment' => true,
            'null'           => false,
            ),
        );

    // -------------------------------------------------------------------------
    // Migration methods
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Install this migration
    // -------------------------------------------------------------------------
    public function up()
    {
        // Email Queue
        if (!$this->db->table_exists($this->email_table))
        {
            $this->dbforge->add_field($this->email_fields);
            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table($this->email_table);
            
            $this->db->insert_batch($this->roles_table, $this->roles_data);
        }
    }

    // -------------------------------------------------------------------------
    // Uninstall this migration
    // -------------------------------------------------------------------------
    public function down()
    {
        $this->dbforge->drop_table($this->email_table);
    }
}