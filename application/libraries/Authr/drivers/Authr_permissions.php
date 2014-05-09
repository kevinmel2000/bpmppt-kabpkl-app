<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Baka Pack
 *
 * My very own Codeigniter Boilerplate Library that used on all of my projects
 * 
 * NOTICE OF LICENSE
 * 
 * Licensed under the Open Software License version 3.0
 * 
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 *
 * @package     Authr
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0
 * @since       Version 0.1
 */

// -----------------------------------------------------------------------------

/**
 * Authr Permissions Driver
 *
 * @subpackage  Drivers
 * @category    Security
 */
class Authr_permissions extends CI_Driver
{
    /**
     * Driver class constructor
     */
    public function __construct()
    {
        log_message('debug', "#Authr: Permissions Driver Initialized");
    }

    // -------------------------------------------------------------------------
    // Permissions
    // -------------------------------------------------------------------------

    public function fetch()
    {
        // $query = $this->db->select("parent")
        //                   ->select("group_concat(distinct permission_id) perm_id")
        //                   ->select("group_concat(distinct permission) perm_name")
        //                   ->select("group_concat(distinct description) perm_desc");

        return $this->db->select('*')->from( $this->table['permissions'] );;
    }

    // -------------------------------------------------------------------------

    public function fetch_grouped()
    {
        return $this->db->select("parent")
                        ->select("group_concat(distinct permission_id) perm_id")
                        ->select("group_concat(distinct permission) perm_name")
                        ->select("group_concat(distinct description) perm_desc")
                        ->from( $this->table['permissions'] )
                        ->group_by('parent')
                        ->get()->result();
    }

    // -------------------------------------------------------------------------

    public function fetch_parents()
    {
        $ret = array();

        foreach ( $this->fetch_grouped() as $row )
        {
            $ret[$row->parent] = $row->parent;
        }

        return $ret;
    }

    // -------------------------------------------------------------------------

    public function get( $perm_id )
    {
        return $this->db->get_where( $this->table['permissions'], array('permission_id' => $perm_id) )->row();
    }

    // -------------------------------------------------------------------------

    public function add( $perm_data = array() )
    {}

    // -------------------------------------------------------------------------

    public function edit( $perm_id, $perm_data = array() )
    {}

    // -------------------------------------------------------------------------

    public function delete( $perm_id )
    {}

    // -------------------------------------------------------------------------

    /**
     * Check is Permission exists?
     *
     * @param   string  $permission  Permission Name
     *
     * @return  bool
     */
    public function is_exists( $permission )
    {
        $query = $this->db->get_where( $this->table['permissions'],
                 array('permission' => $permission), 1);

        return (bool) $query->num_rows();
    }
}

/* End of file Authr_permissions.php */
/* Location: ./application/libraries/Authr/driver/Authr_permissions.php */