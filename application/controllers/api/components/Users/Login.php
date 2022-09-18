<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once(APPPATH . "controllers/components/Transformer.php");

class Login
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
        $timeTs = date("Y-m-d H:i:s");
        if ((!isset($jsonInputObj->email) || empty($jsonInputObj->email)) || (!isset($jsonInputObj->password) || empty($jsonInputObj->password)))
            throw new Exception("Data tidak lengkap. Silahkan cek kembali data anda!", 422);

        $userAccessInfo = $this->CI->user->getUserAccessByEmail($jsonInputObj->email);
        if (is_null($userAccessInfo))
            throw new Exception("Email tidak ditemukan. Silahkan coba kembali!", 401);

        if (!password_verify($jsonInputObj->password, $userAccessInfo->password))
            throw new Exception("Password tidak sama. Silahkan coba kembali!", 401);

        $dataUserAccess = [
            "email" => $jsonInputObj->email,
            "last_login" => $timeTs
        ];
        $this->CI->user->updateUserAccess($dataUserAccess);

        $userInfo = $this->CI->user->getUserByEmail($userAccessInfo->email);
        unset($userInfo->id);
        unset($userInfo->updated);
        $userInfo->role = ucwords($this->CI->master->getMasterById($userInfo->role)->value);
        $userInfo->last_login = $timeTs;
        $userInfo->avatar = BASE_URL("files/thumbs/avatar/" . $userInfo->avatar);

        $responsecode = 200;
        $responseObj  = [
            "name"  => "User Login",
            "item"  => $userInfo
        ];
    }
}