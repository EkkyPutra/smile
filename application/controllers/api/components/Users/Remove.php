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
        $username = isset($jsonInputObj->username) ? $jsonInputObj->username : "";

        $userExist = $this->CI->user->getUserByUsername($username);
        if (empty($username) || is_null($userExist))
            throw new Exception("User tidak ditemukan. Silahkan cek kembali data anda.", 422);

        if ($this->CI->user->removeUser($username)) {
            $responsecode = 200;
            $responseObj = [
                "name" => "User Removed",
                "item" => [
                    "username" => $userExist->username,
                    "name" => $userExist->name
                ]
            ];
        }


    }

}