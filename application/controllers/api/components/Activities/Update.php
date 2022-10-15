<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once(APPPATH . "controllers/components/Transformer.php");

class Update
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

        $activity = $this->CI->project->getProjectActivityById($id);
        if (empty($id) || is_null($activity))
            throw new Exception("Activity tidak ditemukan. Silahkan cek kembali data anda.", 422);

        $progress = isset($jsonInputObj->progress) ? $jsonInputObj->progress : $activity->progress;

        if ($progress < $activity->progress)
            throw new Exception("Progress baru tidak boleh lebih kecil dari progress sebelumnya.", 422);

        $dataUpdate = [
            "id" => $id,
            "name" => isset($jsonInputObj->name) ? $jsonInputObj->name : $activity->name,
            "progress" => isset($jsonInputObj->progress) ? $jsonInputObj->progress : $activity->progress,
            "evidence" => isset($jsonInputObj->evidence) ? $jsonInputObj->evidence : $activity->evidencehone,
            "updated" => date("Y-m-d H:i:s")
        ];

        $updateActivity = $this->CI->project->updateProjectActivity($dataUpdate);
        if ($updateActivity) {
            $responsecode = 200;
            $responseObj  = [
                "name"  => "Activity Updated",
                "item"  => [
                    "project_id" => $activity->project_id,
                    "name" => $dataUpdate["name"],
                    "progress" => $dataUpdate["progress"],
                    "evidence" => $dataUpdate["evidence"],
                    "created" => date("Y-m-d H:i:s"),
                    "user" => $activity->user
                ]
            ];
        }

    }
    

}