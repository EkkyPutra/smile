<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once(APPPATH . "controllers/components/Transformer.php");

class Add
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

    public function action(&$responseObj, &$jsonInputObj, &$responsecode)
    {
        if (!isset($jsonInputObj->project_id) || !isset($jsonInputObj->comment) || !isset($jsonInputObj->user))
            throw new Exception("Data tidak lengkap. Silahkan cek kembali data anda!", 422);

        $project = $this->CI->project->getProjectById($jsonInputObj->project_id);
        if (is_null($project))
            throw new Exception("Project tidak ditemukan. Silahkan cek kembali data anda.", 422);

        $checkUser = $this->CI->user->getUserByUsername($jsonInputObj->user);
        if (is_null($checkUser))
            throw new Exception("User yang tidak ditemukan. Silahkan cek kembali data anda.", 422);

        $userInitial = "";
        foreach (explode(" ", $checkUser->name, 2) as $userInit) {
            $userInitial .= substr($userInit, 0, 1);
        }

        $commentId = isset($jsonInputObj->comment_id) ? $jsonInputObj->comment_id : 0;

        $dataAdd = [
            "project_id" => $project->id,
            "user" => $jsonInputObj->user,
            "comment" => $jsonInputObj->comment,
            "comment_id" => $commentId,
            "created" => date("Y-m-d H:i:s")
        ];

        $addId = $this->CI->comment->addRow($dataAdd);
        if ($addId > 0) {
            $dataAdd["id"] = $addId;
            $dataAdd["user_initial"] = $userInitial;
            $dataAdd["user_name"] = $checkUser->name;
            $dataAdd["user_role"] = $checkUser->user_role;
            $dataAdd["user_divisi"] = $checkUser->user_divisi;
            $responsecode = 200;
            $responseObj = [
                "name" => "Add Project Comment Success",
                "item" => $dataAdd
            ];
        }
    }

}