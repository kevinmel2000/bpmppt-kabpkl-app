<?php
/**
 * @package     BPMPPT App v0.1.6 (http://feryardiant.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2014 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/feryardiant/bpmppt/blob/master/LICENSE)
 * @subpackage  BIDatabaseTest
 * @category    Unit test
 */

// -----------------------------------------------------------------------------

abstract class BIDatabaseTest extends PHPUnit_Extensions_Database_TestCase
{
    /**
     * Reference to CodeIgniter
     *
     * @var resource
     */
    protected $CI;

    /**
     * Only instantiate pdo once for test clean-up/fixture load
     *
     * @internal
     * @var resource
     */
    static private $pdo = null;

    /**
     * Only instantiate PHPUnit_Extensions_Database_DB_IDatabaseConnection once per test
     *
     * @internal
     * @var resource
     */
    private $conn = null;

    /**
     * Call parent constructor and initialize reference to CodeIgniter
     *
     * @internal
     */

    public function setUp()
    {
        $this->CI =& get_instance();
    }

    /**
     * Initialize database connection (same one used by CodeIgniter)
     *
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    final public function getConnection()
    {
        if ($this->conn === null)
        {
            if (self::$pdo == null)
            {
                $dsn = $this->CI->db->dbdriver.':dbname='.$this->CI->db->database.';host='.$this->CI->db->hostname;
                self::$pdo = new PDO($dsn,$this->CI->db->username, $this->CI->db->password);
            }

            $this->conn = $this->createDefaultDBConnection(self::$pdo, $this->CI->db->database);
        }

        return $this->conn;
    }

    /**
     * @internal
     */
    public function __get($name)
    {
        if ($name == 'db')
        {
            return $this->getConnection();
        }
    }

    /**
     * Returns the DataSet
     *
     * Important: the returned DataSet is the current database state, meaning
     * this function does NOT behave as a fixture: the intended usage of this
     * current state connection is to do integration testing.
     * If you want to use fixtures, check PHPUnit's database manual.
     *
     * @link        https://github.com/fmalk/codeigniter-phpunit     *
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
         return $this->getConnection()->createDataSet();
    }
}
