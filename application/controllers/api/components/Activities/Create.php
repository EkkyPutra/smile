<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once(APPPATH . "controllers/components/Transformer.php");

class Create
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
        if (!isset($jsonInputObj->project_id) || !isset($jsonInputObj->name) || !isset($jsonInputObj->progress) || !isset($jsonInputObj->evidence) || !isset($jsonInputObj->user))
            throw new Exception("Data tidak lengkap. Silahkan cek kembali data anda!", 422);

        if (!is_numeric($jsonInputObj->progress))
            throw new Exception("Format input salah. Silahkan cek kembali", 422);

        $project = $this->CI->project->getProjectById($jsonInputObj->project_id);
        if (is_null($project))
            throw new Exception("Project tidak ditemukan. Silahkan cek kembali data anda.", 422);

        $lastProgress = $this->CI->project->getLastProgressActivity($project->id);

        if ($jsonInputObj->progress < $lastProgress)
            throw new Exception("Progress Activity tidak boleh lebih kecil dari progress terakhir.", 422);

        $dataActivities = [
            "project_id" => $project->id,
            "name" => $jsonInputObj->name,
            "progress" => $jsonInputObj->progress,
            "evidence" => $jsonInputObj->evidence,
            "created" => date("Y-m-d H:i:s"),
            "user" => $jsonInputObj->user
        ];
        $activiesId = $this->CI->project->saveActivity($dataActivities);
        if ($activiesId > 0) {
            $this->CI->project->updateProject([
                "id" => $project->id,
                "progress" => $jsonInputObj->progress,
                "updated" => date("Y-m-d H:i:s")
            ]);

            $this->CI->project->addProgress([
                "project_id" => $project->id,
                "progress" => $jsonInputObj->progress,
                "created" => date("Y-m-d H:i:s")
            ]);
            $dataActivities["project_name"] = $project->name;
            unset($dataActivities["user"]);

            $responsecode = 200;
            $responseObj = [
                "name" => "Add New Project Activity Success",
                "item" => $dataActivities
            ];
        }
    }


}