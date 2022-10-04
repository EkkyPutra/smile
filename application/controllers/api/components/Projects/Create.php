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
        if (!isset($jsonInputObj->name) || !isset($jsonInputObj->divisi) || !isset($jsonInputObj->type) || !isset($jsonInputObj->deadline) || !isset($jsonInputObj->description) || !isset($jsonInputObj->pic_ids))
            throw new Exception("Data tidak lengkap. Silahkan cek kembali data anda!", 422);

        $pics = null;
        if (is_array($jsonInputObj->pic_ids)) {
            foreach ($jsonInputObj->pic_ids as $pic) {
                $checkPic = $this->CI->user->getUserById($pic->id);
                if (is_null($checkPic))
                    throw new Exception("Ada user yang tidak ditemukan. Silahkan cek kembali data anda.", 422);

                $picDivisi = $this->CI->master->getMasterById($checkPic->divisi);
                $picRole = $this->CI->master->getMasterById($checkPic->role);
                $checkPic->divisi = ucwords($picDivisi->value);
                $checkPic->role = ucwords($picRole->value);
                $checkPic->type = ($pic->type == 1) ? "Leader" : "Member";
                $pics[] = $checkPic;
            }
        }

        $checkType = $this->CI->master->getMasterByIdType($jsonInputObj->type, 2);
        if (is_null($checkType))
            throw new Exception("Tipe Proyek tidak ditemukan. Silahkan cek kembali data anda.", 422);

        $checkDivisi = $this->CI->master->getMasterByIdType($jsonInputObj->divisi, 3);
        if (is_null($checkDivisi))
            throw new Exception("Divisi tidak ditemukan. Silahkan cek kembali data anda.", 422);

        $timeTs = date("Y-m-d H:i:s");
        $dataProject = [
            "name" => $jsonInputObj->name,
            "divisi" => $checkDivisi->id,
            "priority" => (isset($jsonInputObj->priority) && $jsonInputObj->priority) ? 1 : 0,
            "type" => $checkType->id,
            "deadline" => $jsonInputObj->deadline,
            "progress" => isset($jsonInputObj->progress) ? $jsonInputObj->progress : 0,
            "link" => isset($jsonInputObj->link) ? $jsonInputObj->link : "",
            "description" => $jsonInputObj->description,
            "created" => $timeTs,
            "updated" => $timeTs
        ];

        $projectId = $this->CI->project->addRow($dataProject);
        if ($projectId > 0) {
            $dataProject["divisi"] = ucwords($checkDivisi->value);
            $dataProject["type"] = ucwords($checkType->value);
            $dataProject["priority"] = ($dataProject["priority"] == 0) ? "No" : "Yes";

            foreach ($jsonInputObj->pic_ids as $pic) {
                $dataPic = [
                    "project_id" => $projectId,
                    "user_id" => $pic->id,
                    "type" => $pic->type
                ];
                $this->CI->project->addPic($dataPic);
            }
            $dataProject["pic"] = $pics;

            $responsecode = 200;
            $responseObj = [
                "name" => "Add New Project",
                "item" => $dataProject
            ];
        }
    }

}