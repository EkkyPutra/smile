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
        $urlProjectCount = parent::build_api_url("projects/get/count");
        $responseProejctCount = $this->somplakapi->run_curl_api($urlProjectCount, []);
        $resApiProejctCount = json_decode($responseProejctCount);

        $projectCount = null;
        if ($resApiProejctCount->result == 200)
            $projectCount = $resApiProejctCount->data->item;

        $data["isMobile"] = $this->agent->is_mobile();
        $data["projectCount"] = $projectCount;

        $this->load->view("public/main", $data);
    }

    public function exports($type, $slug = "")
    {
        header('Content-Type: application/json');
        $url = parent::build_api_url('exports/' . $type . '/' . $slug);
        $response = $this->somplakapi->run_curl_api($url, []);
        $resApi = json_decode($response);

        echo json_encode($resApi);
    }
}
