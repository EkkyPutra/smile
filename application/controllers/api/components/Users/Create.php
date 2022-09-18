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
        if (!isset($jsonInputObj->username) || !isset($jsonInputObj->name) || !isset($jsonInputObj->email) || !isset($jsonInputObj->role) || !isset($jsonInputObj->handphone))
            throw new Exception("Data tidak lengkap. Silahkan cek kembali data anda!", 422);

        $password = "!Tsel123";
        $generatePassword = $this->CI->myutils->generatePassword($password);
        if (!$generatePassword) {
            throw new Exception("Password harus terdiri dari mininal 8 karakter, terdiri dari gabungan huruf kapital, huruf kecil, angka,dan simbol!", 422);
        }

        $this->CI->form_validation->set_data((array) $jsonInputObj);
        $this->CI->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
        if ($this->CI->form_validation->run() == FALSE) {
            throw new Exception("Format email anda salah.", 422);
        }

        $checkEmailExist = $this->CI->user->getUserByEmailUsername($jsonInputObj->email, $jsonInputObj->username);
        if (!is_null($checkEmailExist))
            throw new Exception("Email telah terdaftar", 422);

        $checkUserRole = $this->CI->master->getMasterById($jsonInputObj->role);
        if (is_null($checkUserRole)) 
            throw new Exception("User Role tidak ditemukan. Cek Master Data anda", 422);

        $timeTs = date("Y-m-d H:i:s");
        $dataUser = [
            "name" => $jsonInputObj->name,
            "username" => $jsonInputObj->username,
            "role" => $jsonInputObj->role,
            "email" => $jsonInputObj->email,
            "handphone" => $jsonInputObj->handphone,
            "created" => $timeTs,
            "updated" => $timeTs,
        ];

        if (isset($jsonInputObj->avatar) && !empty($jsonInputObj->avatar)) {
            $avatar = $this->CI->filefunction->saveImages($jsonInputObj->avatar, "avatar");
            $dataUser["avatar"] = $avatar;
        }

        $user = $this->CI->user->addUser($dataUser);
        if (!is_null($user) && $user->result > 0) {
            $dateUserAccess = [
                "email" => $jsonInputObj->email,
                "password" => $generatePassword,
                "type" => $jsonInputObj->role,
                "created" => $timeTs
            ];
            $this->CI->user->addUserAccess($dateUserAccess);
            
            $dataUser["role"] = ucwords($checkUserRole->value);
            $dataUser["avatar"] = BASE_URL("files/thumbs/avatar/" . $dataUser["avatar"]);
            $responsecode = 200;
            $responseObj  = [
                "name"  => "User Created",
                "item"  => $dataUser
            ];
        }
    }

}