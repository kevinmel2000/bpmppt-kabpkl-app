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
 * @package     CodeIgniter Baka Authr
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
 * @since       Version 0.1
 */

// -----------------------------------------------------------------------------

/**
 * Authr User Permissions Driver
 *
 * @subpackage  Drivers
 * @category    Security
 */
class Authr_user_perms extends CI_Driver
{
    /**
     * Driver class constructor
     */
    public function __construct()
    {
        log_message('debug', "#Authr: User Permissions Driver Initialized");
    }

    // -------------------------------------------------------------------------
    // User Permissions Relation
    // -------------------------------------------------------------------------

    public function fetch( $user_id )
    {
        $query = $this->db->select("d.permission_id id, d.permission perm, d.description")
                          ->from($this->table['user_role'].' a')
                          ->join($this->table['roles'].' b', 'b.role_id = a.role_id')
                          ->join($this->table['role_perms'].' c', 'c.role_id = b.role_id')
                          ->join($this->table['permissions'].' d', 'd.permission_id = c.permission_id')
                          ->where('a.user_id', $user_id)
                          ->get();

        if ( $query->num_rows() > 0 )
        {
            $ret = array();

            foreach ( $query->result() as $row )
            {
                $ret[$row->id] = $row->perm;
            }

            return $ret;
        }

        return FALSE;
    }
}

/* End of file Authr_user_perms.php */
/* Location: ./application/libraries/Authr/driver/Authr_user_perms.php */