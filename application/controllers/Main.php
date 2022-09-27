<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/base/web_base.php';
date_default_timezone_set("Asia/Jakarta");

class Main extends web_base
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
        $this->load->view("public/main");
    }
}
