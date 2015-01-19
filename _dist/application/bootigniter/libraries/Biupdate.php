<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://creasico.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/creasico/bpmppt/blob/master/LICENSE)
 * @subpackage  Biupdate
 * @category    Libraries
 */

// -----------------------------------------------------------------------------

class Biupdate
{
    /**
     * Codeigniter superobject
     * @var  resource
     */
    protected $_ci;
    protected $session;
    protected $emojis;

    /**
     * Class Constructor
     */
    public function __construct()
    {
        // Get instanciation of CI Super Object
        $this->_ci =& get_instance();

        log_message('debug', "#BootIgniter: Biupdate Class Initialized");

        if (!function_exists('curl_init'))
        {
            log_message('error', 'cURL Class - PHP was not built with cURL enabled. Rebuild PHP with --with-curl to use cURL.');
        }

        if (!$this->_ci->load->is_loaded('file_helper'))
        {
            $this->_ci->load->helper('file_helper');
        }

        $emojis = read_file(FCPATH.'asset/github-emojis.json');
        $this->emojis = json_decode($emojis);

        $this->_ci->load->model('biupdate_model');
        $this->repo_url = Bootigniter::app('repo_url');
    }

    // -------------------------------------------------------------------------

    public function __call($method, $args)
    {
        if (!method_exists($this->_ci->biupdate_model, $method))
        {
            show_error('Undefined method Biupdate::'.$method.'() called', 500, 'An Error Eas Encountered');
        }

        return call_user_func_array(array($this->_ci->biupdate_model, $method), $args);
    }

    public function is_new_available()
    {
        $latest = $this->get_latest();
        $checknew = $this->fetch($latest->timestamp);

        if (count($checknew) > 1)
        {
            $checknew = array_shift($checknew);
            $checknew['message'] = $this->_parse_emoji($checknew['message']);

            return $checknew;
        }

        return false;
    }

    public function fetch($since = null)
    {
        $url = str_replace('github.com/', 'api.github.com/repos/', $this->repo_url).'/commits';
        if ($since !== null)
        {
            $url .= '?since='.$since;
        }

        if ($responses = $this->_send_request($url))
        {
            $response = array();
            foreach (json_decode($responses) as $res)
            {
                $response[$res->sha] = array(
                    'sha'       => $res->sha,
                    'timestamp' => $res->commit->committer->date,
                    'author'    => $res->commit->committer->name,
                    'message'   => $this->_parse_emoji($res->commit->message),
                    'archive'   => $this->repo_url.'/zipball/'.substr($res->sha, 0, 7),
                    );
            }

            return $response;
        }

        return FALSE;
    }

    public function download($url, $target = '')
    {
        $target or $target = 'storage/tmp/update.zip';
        if (file_exists(APPPATH.$target))
        {
            unlink(APPPATH.$target);
        }

        if (($responses = $this->_send_request($url)) && write_file(APPPATH.$target, $responses))
        {
            $this->_ci->load->driver('arsip');

            if (!$file_path = $this->_ci->arsip->init(APPPATH.$target)->extract(APPPATH.'storage/tmp/'))
            {
                set_message('error', 'Extract gagal');
                return FALSE;
            }

            $extract_dir = str_replace(array('https://github.com/', '/', '-zipball-'), array('', '-', '-'), $url);
            if (!is_dir($extract_dir))
            {
                set_message('error', 'Direktory '.$extract_dir.' extract tidak valid');
                return FALSE;
            }

            return TRUE;
        }
        else
        {
            set_message('error', 'Download gagal');
            return false;
        }
    }

    protected function _parse_emoji($message)
    {
        if (preg_match('/(\:[\w\s]+\:)/i', $message, $matches))
        {
            if (!$this->_ci->load->is_loaded('html_helper'))
            {
                $this->_ci->load->helper('html_helper');
            }

            $emoji_url = trim($matches[0], ':');
            $ejomi_img = img(array('src' => $this->emojis->$emoji_url, 'alt' => $emoji_url, 'width' => '16px'));
            $message = str_replace($matches[0], $ejomi_img, $message);
        }

        return $message;
    }

    public function _do_update($path, $dest = FCPATH)
    {
        $dir = dir($path);

        while (false !== ($file = $dir->read()))
        {
            if (is_dir($file) and in_array($file, array('application', 'system', 'asset')))
            {
                $this->_do_update($path.DIRECTORY_SEPARATOR.$file, $dest.DIRECTORY_SEPARATOR.$file);
            }
            elseif (!is_dir($file) and in_array($file, array('README.md', 'LICENSE')))
            {
                copy($path.DIRECTORY_SEPARATOR.$file, $dest.DIRECTORY_SEPARATOR.$file);
            }
        }

        $dir->close();
    }

    protected function _send_request($url, $options = array())
    {
        set_time_limit(0);
        $sess = curl_init($url);
        $opts = array(
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_FAILONERROR    => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT      => Bootigniter::app('slug'),
            );

        if (!empty($options))
        {
            $opts = array_merge($opts, $options);
        }

        // Setup option
        curl_setopt_array($sess, $opts);
        $responses = curl_exec($sess) ?: false;

        if (!$responses)
        {
            log_message('error', 'Biupdate error: '.curl_errno($sess).' '.curl_error($sess));
        }

        curl_close($sess);

        return $responses;
    }
}
