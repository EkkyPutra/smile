<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/base/web_base.php';
date_default_timezone_set("Asia/Jakarta");

class Login extends web_base
{

    /**
     * Contructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array(
            'text',
            'url'
        ));

        $this->load->library(array(
            'myutils',
            'somplakapi',
            'user_agent'
        ));
    }

    public function index()
    {
        $session_smile = $this->session->userdata("smile.pm");
        if (!is_null($session_smile) && $session_smile["status"] == "VALID") {
            redirect(base_url('main'));
        } else {
            $this->load->view("public/login");
        }
    }
}