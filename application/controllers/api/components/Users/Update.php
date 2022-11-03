<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once(APPPATH . "controllers/components/Transformer.php");

class Update
{
    protected $CI;
    protected $appSrc;

    public function __construct($command)
    {
        $this->CI = &get_instance();
        $this->CI->load->helper(array());
        $this->CI->load->model(array());
        $this->CI->load->library(array(
            'form_validation',
            'filefunction'
        ));
        $this->command = $command;
    }

    private function _detail(&$responseObj, &$jsonInputObj, &$responsecode)
    {
        $old_username = isset($jsonInputObj->old_username) ? $jsonInputObj->old_username : "";

        $userExist = $this->CI->user->getUserByUsername($old_username);
        if (empty($old_username) || is_null($userExist))
            throw new Exception("User tidak ditemukan. Silahkan cek kembali data anda.", 422);

        $userRole = isset($jsonInputObj->role) ? $jsonInputObj->role : $userExist->role;
        $checkUserRole = $this->CI->master->getMasterById($userRole);
        if (is_null($checkUserRole))
            throw new Exception("User Role tidak ditemukan. Cek Master Data anda", 422);

        $userDivisi = isset($jsonInputObj->divisi) ? $jsonInputObj->divisi : $userExist->divisi;
        $checkUserDivisi = $this->CI->master->getMasterById($userDivisi);
        if (is_null($checkUserDivisi))
            throw new Exception("User Divisi tidak ditemukan. Cek Master Data anda", 422);

        $timeTs = date("Y-m-d H:i:s");
        if (isset($jsonInputObj->name))
            $dataUpdate["name"] = $jsonInputObj->name;

        if (isset($jsonInputObj->username))
            $dataUpdate["username"] = $jsonInputObj->username;

        if (isset($jsonInputObj->role))
            $dataUpdate["role"] = $jsonInputObj->role;

        if (isset($jsonInputObj->divisi))
            $dataUpdate["divisi"] = $jsonInputObj->divisi;

        if (isset($jsonInputObj->handphone))
            $dataUpdate["handphone"] = $jsonInputObj->handphone;

        if (isset($jsonInputObj->name))
            $dataUpdate["name"] = $jsonInputObj->name;

        $dataUpdate["avatar"] = $userExist->avatar;
        if (isset($jsonInputObj->avatar) && !empty($jsonInputObj->avatar)) {
            $avatar = $this->CI->filefunction->saveImages($jsonInputObj->avatar, "avatar");
            $dataUpdate["avatar"] = $avatar;
        }

        $userUpdate = $this->CI->user->updateUser($old_username, $dataUpdate);
        if ($userUpdate) {
            $dataUserAccess = [
                "type" => $userRole,
                "updated" => $timeTs
            ];
            if (isset($jsonInputObj->username)) $dataUserAccess["username"] = $jsonInputObj->username;
            $this->CI->user->updateUserAccess($dataUserAccess, $old_username);

            $userInfo = $this->CI->user->getUserByUsername($jsonInputObj->username);
            unset($userInfo->id);
            unset($userInfo->updated);
            $userInfo->role = ucwords($this->CI->master->getMasterById($userInfo->role)->value);
            $userInfo->divisi = ucwords($this->CI->master->getMasterById($userInfo->divisi)->value);
            $userInfo->last_login = $timeTs;
            $userInfo->access_level = json_decode($userInfo->access_level);
            $userInfo->avatar = "./files/thumbs/avatar/" . $userInfo->avatar;

            $responsecode = 200;
            $responseObj  = [
                "name"  => "User Updated",
                "item"  => $userInfo
            ];
        }
    }

    private function _password(&$responseObj, &$jsonInputObj, &$responsecode)
    {
        $userExist = $this->CI->user->getUserByUsername($jsonInputObj->username, true);
        if (empty($jsonInputObj->username) || is_null($userExist))
            throw new Exception("User tidak ditemukan. Silahkan cek kembali data anda.", 422);

        $userInfo = $this->CI->user->getUserAccessByUsername($jsonInputObj->username);
        if (password_verify(md5($jsonInputObj->old_password), $userInfo->password)) {
            if (password_verify(md5($jsonInputObj->new_password), $userInfo->password)) {
                throw new Exception("Password baru sama dengan password lama", 422);
            } else {
                $passwordHash = $this->CI->myutils->generatePassword($jsonInputObj->new_password);
                $this->CI->user->updateUserAccess([
                    "username" => $userExist->username,
                    "password" => $passwordHash,
                    "updated" => date("Y-m-s H:i:s")
                ]);

                unset($userInfo->id);
                unset($userInfo->updated);
                $userInfo->role = ucwords($this->CI->master->getMasterById($userInfo->role)->value);
                $userInfo->divisi = ucwords($this->CI->master->getMasterById($userInfo->divisi)->value);
                $userInfo->last_login = date("Y-m-s H:i:s");
                $userInfo->avatar = "./files/thumbs/avatar/" . $userInfo->avatar;

                $responsecode = 200;
                $responseObj  = [
                    "name"  => "Password Changed",
                    "item"  => $userInfo
                ];

            }
        } else {
            throw new Exception("Password lama anda tidak cocok!", 422);
        }
    }

    public function action(&$responseObj, &$jsonInputObj, &$responsecode, &$responseMessage)
    {
        if ($this->command == "detail") {
            $this->_detail($responseObj, $jsonInputObj, $responsecode);
        } else if ($this->command == "password") {
            $this->_password($responseObj, $jsonInputObj, $responsecode);
        }
    }

}