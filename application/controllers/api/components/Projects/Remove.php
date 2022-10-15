<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once(APPPATH . "controllers/components/Transformer.php");

class Remove
{
    protected $CI;
    protected $appSrc;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->helper(array());
        $this->CI->load->model(array());
        $this->CI->load->library(array(
            'form_validation',
            'filefunction'
        ));
    }

    public function action(&$responseObj, &$jsonInputObj, &$responsecode, &$responseMessage)
    {
        $id = isset($jsonInputObj->id) ? $jsonInputObj->id : "";

        $projectExist = $this->CI->project->getProjectById($id);
        if (empty($id) || is_null($projectExist))
            throw new Exception("Project tidak ditemukan. Silahkan cek kembali data anda.", 422);

        if ($this->CI->project->removeProject($id)) {
            $responsecode = 200;
            $responseObj = [
                "name" => "Project Removed",
                "item" => [
                    "name" => $projectExist->name,
                    "progress" => $projectExist->progress . "%",
                    "description" => $projectExist->description
                ]
            ];
        }
    }
}
