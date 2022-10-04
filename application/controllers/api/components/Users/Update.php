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
        $old_username = isset($jsonInputObj->old_username) ? $jsonInputObj->old_username : "";

        $userExist = $this->CI->user->getUserByUsername($old_username);
        if (empty($old_username) || is_null($userExist))
            throw new Exception("User tidak ditemukan. Silahkan cek kembali data anda.", 422);

        $userRole = isset($jsonInputObj->role) ? $jsonInputObj->role : $userExist->role;
        $checkUserRole = $this->CI->master->getMasterById($userRole);
        if (is_null($checkUserRole))
            throw new Exception("User Role tidak ditemukan. Cek Master Data anda", 422);

        $checkUserDivisi = $this->CI->master->getMasterById($jsonInputObj->divisi);
        if (is_null($checkUserDivisi))
            throw new Exception("User Divisi tidak ditemukan. Cek Master Data anda", 422);

        $timeTs = date("Y-m-d H:i:s");
        $dataUpdate = [
            "name" => isset($jsonInputObj->name) ? $jsonInputObj->name : $userExist->name,
            "username" => isset($jsonInputObj->username) ? $jsonInputObj->username : $userExist->username,
            "role" => isset($jsonInputObj->role) ? $jsonInputObj->role : $userExist->role,
            "divisi" => isset($jsonInputObj->divisi) ? $jsonInputObj->divisi : $userExist->divisi,
            "handphone" => isset($jsonInputObj->handphone) ? $jsonInputObj->handphone : $userExist->handphone,
            "updated" => $timeTs
        ];

        if (isset($jsonInputObj->avatar) && !empty($jsonInputObj->avatar)) {
            $avatar = $this->CI->filefunction->saveImages($jsonInputObj->avatar, "avatar");
            $dataUpdate["avatar"] = $avatar;
        }

        $userUpdate = $this->CI->user->updateUser($old_username, $dataUpdate);
        if ($userUpdate) {
            $dataUserAccess = [
                "type" => $jsonInputObj->role,
                "updated" => $timeTs
            ];
            if (isset($jsonInputObj->username)) $dataUserAccess["username"] = $jsonInputObj->username;
            $this->CI->user->updataUserAccess($dataUserAccess, $old_username);

            $dataUpdate["user_role"] = ucwords($checkUserRole->value);
            $dataUpdate["user_divisi"] = ucwords($checkUserDivisi->value);
            $dataUpdate["avatar"] = BASE_URL("files/thumbs/avatar/" . $dataUpdate["avatar"]);
            $responsecode = 200;
            $responseObj  = [
                "name"  => "User Updated",
                "item"  => $dataUpdate
            ];
        }

    }

}