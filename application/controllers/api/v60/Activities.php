<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
include_once(APPPATH . "controllers/base/constant.php");
include_once(APPPATH . "controllers/api/components/API_Controller.php");
include_once(APPPATH . "controllers/api/components/Activities/Create.php");
include_once(APPPATH . "controllers/api/components/Activities/Get.php");
include_once(APPPATH . "controllers/api/components/Activities/Remove.php");
include_once(APPPATH . "controllers/api/components/Activities/Update.php");

class Activities extends API_Controller
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
            'user',
            'project'
        ));

        $this->load->library(array(
            'myutils'
        ));
    }

    public function create()
    {
        $this->writeLogInput();

        try {
            $create = new Create();
            $create->action($this->responseObj, $this->jsonInputObj, $this->res_code, $this->res_message);

            $this->sendResponse($this->res_code, $this->res_message);
        } catch (Exception $e) {
            $this->sendResponseError($e);
        }
        $this->writeLogOutput();
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

    public function remove($command = "")
    {
        $this->writeLogInput();

        try {
            $remove = new Remove($command);
            $remove->action($this->responseObj, $this->jsonInputObj, $this->res_code, $this->res_message);

            $this->sendResponse($this->res_code, $this->res_message);
        } catch (Exception $e) {
            $this->sendResponseError($e);
        }
        $this->writeLogOutput();
    }

    public function update($command = "")
    {
        $this->writeLogInput();

        try {
            $update = new Update($command);
            $update->action($this->responseObj, $this->jsonInputObj, $this->res_code, $this->res_message);

            $this->sendResponse($this->res_code, $this->res_message);
        } catch (Exception $e) {
            $this->sendResponseError($e);
        }
        $this->writeLogOutput();
    }
}