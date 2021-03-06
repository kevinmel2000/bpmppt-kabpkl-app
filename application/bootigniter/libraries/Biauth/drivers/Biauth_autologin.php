<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://creasico.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/creasico/bpmppt/blob/master/LICENSE)
 * @subpackage  Biauth_autologin
 * @category    Drivers
 */

// -----------------------------------------------------------------------------

class Biauth_autologin extends CI_Driver
{
    /**
     * Driver class constructor
     */
    public function __construct()
    {
        log_message('debug', "#Biauth: Autologin Driver Initialized");
    }

    // -------------------------------------------------------------------------
    // Autologin
    // -------------------------------------------------------------------------

    /**
     * Get user data for auto-logged in user.
     * Return FALSE if given key or user ID is invalid.
     *
     * @param   string    $key  Autologin Key
     *
     * @return  obj|bool
     */
    public function get($user_id, $key)
    {
        $query = $this->_ci->db->select('a.id, a.username, a.display, a.activated, a.banned, a.deleted')
                               ->from($this->table['users'].' a')
                               ->join($this->table['autologin'].' b', 'b.user_id = a.id')
                               ->where('b.user_id', $user_id)
                               ->where('b.key_id', $key)
                               ->get();

        if ($query && $query->num_rows() == 1)
        {
            return $query->row();
        }

        return FALSE;
    }

    // -------------------------------------------------------------------------

    /**
     * Save data for user's autologin
     *
     * @param   int
     * @param   string
     * @return  bool
     */
    public function set($user_id, $key)
    {
        return $this->_ci->db->insert($this->table['autologin'], array(
            'user_id'    => $user_id,
            'key_id'     => $key,
            'user_agent' => substr($this->_ci->input->user_agent(), 0, 149),
            'last_ip'    => $this->_ci->input->ip_address()
            ));
    }

    // -------------------------------------------------------------------------

    /**
     * Purge autologin data for given user and login conditions
     *
     * @param   int
     * @return  void
     */
    public function purge($user_id)
    {
        $this->_ci->db->delete($this->table['autologin'], array(
            'user_id'   => $user_id,
            'user_agent'=> substr($this->_ci->input->user_agent(), 0, 149),
            'last_ip'   => $this->_ci->input->ip_address()
            ));
    }

    // -------------------------------------------------------------------------

    /**
     * Clear user's autologin data
     *
     * @return  void
     */
    public function delete()
    {
        if ($cookie = get_cookie(config_item('biauth_autologin_cookie_name'), TRUE))
        {
            $data = unserialize($cookie);

            $this->_ci->db->delete(
                $this->table['autologin'],
                array(
                    'user_id' => $data['user_id'],
                    'key_id'  => md5($data['key'])
                    )
                );

            delete_cookie(config_item('biauth_autologin_cookie_name'));
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Delete all autologin data for given user
     *
     * @param   int
     * @return  void
     */
    public function clear($user_id)
    {
        $this->_ci->db->delete($this->table['autologin'], array('user_id' => $user_id));
    }
}

/* End of file Biauth_autologin.php */
/* Location: ./bootigniter/libraries/Biauth/driver/Biauth_autologin.php */
