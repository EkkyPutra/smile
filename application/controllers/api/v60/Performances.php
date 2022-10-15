<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
include_once(APPPATH . "controllers/base/constant.php");
include_once(APPPATH . "controllers/api/components/API_Controller.php");
include_once(APPPATH . "controllers/api/components/Performances/Get.php");

class Performances extends API_Controller
{
    private $res_code = 201;
    private $res_message = "";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array(
            'url',
            'url_helper',
            'file'
        ));

        $this->load->model(array(
            'master',
            'project',
            'user'
        ));

        $this->load->library(array(
            'myutils'
        ));
    }

    public function get($command = "")
    {
        $this->writeLogInput();

        try {
            $get = new Get($command);
            $get->action($this->responseObj, $this->jsonInputObj, $this->res_code, $this->res_message);

            $this->sendResponse($this->res_code, $this->res_message);
        } catch (Exception $e) {
            $this->sendResponseError($e);
        }
        $this->writeLogOutput();
    }

}