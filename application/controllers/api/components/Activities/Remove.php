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

        $activityExist = $this->CI->project->getProjectActivityById($id);
        if (empty($id) || is_null($activityExist))
            throw new Exception("Activity tidak ditemukan. Silahkan cek kembali data anda.", 422);

        if ($this->CI->project->removeProjectActivity($id)) {
            $lastProgress = $this->CI->project->getLastProgressActivity($activityExist->project_id);
            $this->CI->project->updateProject([
                "id" => $activityExist->project_id,
                "progress" => $lastProgress
            ]);
            $responsecode = 200;
            $responseObj = [
                "name" => "Activity Removed",
                "item" => [
                    "name" => $activityExist->name,
                    "progress" => $activityExist->progress . "%",
                    "last_progress" => $lastProgress,
                    "evidence" => $activityExist->evidence
                ]
            ];
        }
    }
}
