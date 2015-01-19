<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     @PACKAGE
 * @author      @AUTHOR
 * @copyright   Copyright (c) @COPYRIGHT
 * @license     @LICENSE
 * @subpackage  Biupdate
 * @category    Libraries
 */

// -----------------------------------------------------------------------------

class Biupdate_model extends CI_Model
{
    private $table = 'changelogs';

    /**
     * Class Constructor
     */
    public function __construct()
    {
        // parent::__construct();
        // log_message('debug', "#BootIgniter: Biasset Class Initialized");
    }

    public function get_all()
    {
        if ($db = $this->db->limit(5)->order_by('timestamp', 'desc')->get($this->table))
        {
            return $db->result();
        }

        return FALSE;
    }

    public function get_latest()
    {
        if ($db = $this->db->limit(1)->order_by('timestamp', 'desc')->get($this->table))
        {
            return $db->last_row();
        }

        return FALSE;
    }
}
