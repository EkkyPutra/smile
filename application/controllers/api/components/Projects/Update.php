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
        $projectExist = $this->CI->project->getProjectById($id);
        if (empty($id) || is_null($projectExist))
            throw new Exception("Project tidak ditemukan. Silahkan cek kembali data anda.", 422);

        $pics = null;
        if (is_array($jsonInputObj->pic_ids)) {
            foreach ($jsonInputObj->pic_ids as $pic) {
                $checkPic = $this->CI->user->getUserById($pic->id);
                if (is_null($checkPic))
                    throw new Exception("Ada user yang tidak ditemukan. Silahkan cek kembali data anda.", 422);
                else if (!is_null($checkPic) && $checkPic->name != $pic->name)
                    throw new Exception("Ada user yang tidak ditemukan. Silahkan cek kembali data anda.", 422);

                $picDivisi = $this->CI->master->getMasterById($checkPic->divisi);
                $picRole = $this->CI->master->getMasterById($checkPic->role);
                $checkPic->divisi = ucwords($picDivisi->value);
                $checkPic->role = ucwords($picRole->value);
                $checkPic->type = ($pic->type == 1) ? "Leader" : "Member";
                $pics[] = $checkPic;
            }
        }

        $projectSlug = $this->CI->myutils->slug_name($jsonInputObj->name);
        $checkProjectSluExist = $this->CI->project->getProjectBySlug($projectSlug);
        if (!is_null($checkProjectSluExist) && $checkProjectSluExist->id != $id)
            $projectSlug .= "-" . $this->CI->myutils->generateRandomString(3);

        $checkType = $this->CI->master->getMasterByIdType($jsonInputObj->type, 2);
        if (is_null($checkType))
            throw new Exception("Tipe Proyek tidak ditemukan. Silahkan cek kembali data anda.", 422);

        $checkDivisi = $this->CI->master->getMasterByIdType($jsonInputObj->divisi, 3);
        if (is_null($checkDivisi))
            throw new Exception("Divisi tidak ditemukan. Silahkan cek kembali data anda.", 422);

        $timeTs = date("Y-m-d H:i:s");
        $dataProject = [
            "id" => $id,
            "name" => $jsonInputObj->name,
            "divisi" => $checkDivisi->id,
            "priority" => (isset($jsonInputObj->priority) && $jsonInputObj->priority == "on") ? 1 : 0,
            "type" => $checkType->id,
            "deadline" => $jsonInputObj->deadline,
            "link" => isset($jsonInputObj->link) ? $jsonInputObj->link : "",
            "description" => $jsonInputObj->description,
            "updated" => $timeTs,
            "slug" => $projectSlug
        ];

        $updateProject = $this->CI->project->updateProject($dataProject);
        if ($updateProject) {
            $dataProject["divisi"] = ucwords($checkDivisi->value);
            $dataProject["type"] = ucwords($checkType->value);
            $dataProject["priority"] = ($dataProject["priority"] == 0) ? "No" : "Yes";

            $this->CI->project->removeProjectPic($id);
            foreach ($jsonInputObj->pic_ids as $pic) {
                $dataPic = [
                    "project_id" => $id,
                    "user_id" => $pic->id,
                    "type" => $pic->type
                ];
                $this->CI->project->addPic($dataPic);
            }
            $dataProject["pic"] = $pics;

            $responsecode = 200;
            $responseObj = [
                "name" => "Project Updated",
                "item" => $dataProject
            ];
        }
    }


}