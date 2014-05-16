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
 * Assets Class
 *
 * @subpackage  Controller
 */
class Assets extends BAKA_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function css()
    {
        echo 'this css assets';
    }

    public function js($pos = 'foot')
    {
        if ($scripts = Asssets::get_script($pos))
        {
            $output = '';

            foreach ($scripts as $id => $path)
            {
                $handler = fopen($path, "rb");
                $script = file_get_contents($handler);
                fclose($handler);

                // $context = stream_context_create(array(
                //     'http' => array(
                //         'method'  => "GET",
                //         'header'  => "Content-Type: text/javascript\n",
                //         'content' => $script,
                //         )
                //     ));

                $output .= "// $id\n";
                $output .= $script."\n";
            }

            echo $output;
        }
        else
        {
            echo 'null';
        }
    }
}

/* End of file assets.php */
/* Location: ./application/controllers/assets.php */