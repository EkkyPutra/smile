<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once(APPPATH . "controllers/components/Transformer.php");

class Get
{
    protected $CI;
    protected $appSrc;

    public function __construct($command)
    {
        $this->CI = &get_instance();
        $this->CI->load->helper(array());
        $this->CI->load->model(array());
        $this->CI->load->library(array());

        $this->command = $command;
    }

    private function _lists($jsonInputObj)
    {
        $currPage = 1;
        $limit = 200;
        $totalPage = 1;
        $users = null;
        $start = 0;

        if (isset($jsonInputObj->page) && $jsonInputObj->page > 0 && isset($jsonInputObj->limit) && $jsonInputObj->limit > 0) {
            $currPage = $jsonInputObj->page;
            $limit    = $jsonInputObj->limit;
            $start    = ($jsonInputObj->page - 1) * $limit;
        }

        $role = (isset($jsonInputObj->role) && $jsonInputObj->role != "all") ? $jsonInputObj->role : "";
        $getRole = $this->CI->master->getMasterByTypeValue(1, $role);
        if (!empty($role) && is_null($getRole))
            throw new Exception("Role User tidak ditemukan!", 401);

        $sort = (isset($jsonInputObj->sort) && !empty($jsonInputObj->sort)) ? $jsonInputObj->sort : "";
        $order = (isset($jsonInputObj->order) && !empty($jsonInputObj->order)) ? $jsonInputObj->order : "";
        $role = !is_null($getRole) ? $getRole->id : 0;
        $totalUsers = $this->CI->user->totalUsers($role);
        $rowsPerPage = 0;

        if ($totalUsers > 0) {
            $totalPage = ceil($totalUsers / $limit);
            $getUsers = $this->CI->user->getUsers($role, $start, $limit, $sort, $order);
            if (!is_null($getUsers)) {
                $rowsPerPage = count($getUsers);
                foreach ($getUsers as $user) {
                    $user->avatar_thumb = !empty($user->avatar) ? BASE_URL . "files/thumbs/avatar/" . $user->avatar : "";
                    $user->avatar = !empty($user->avatar) ? BASE_URL . "files/images/avatar/" . $user->avatar : "";
                    $users[] = $user;
                }
            }
        }

        return [
            "name"  => "Users Lists of " . (($role == 0 && is_null($getRole)) ? "All" : $getRole->value),
            "items"  => $users,
            "totalRows" => $totalUsers,
            "rowsPerPage" => $rowsPerPage,
            "currPage" => $currPage,
            "totalPage" => $totalPage,
            "limit" => $limit
        ];
    }

    private function _detail($jsonInputObj)
    {
        if (!isset($jsonInputObj->username) || empty($jsonInputObj->username))
            throw new Exception("Data tidak lengkap. Silahkan cek kembali data anda!", 422);

        $userExist = $this->CI->user->getUserByUsername($jsonInputObj->username);

        if (is_null($userExist))
            throw new Exception("User tidak ditemukan. Silahkan cek kembali data anda!", 422);

        $user = (object) [];
        unset($userExist->id);
        $user = $userExist;
        $user->avatar_thumb = !empty($user->avatar) ? BASE_URL . "files/thumbs/avatar/" . $user->avatar : "";
        $user->avatar = !empty($user->avatar) ? BASE_URL . "files/images/avatar/" . $user->avatar : "";

        return [
            "name" => "User Detail",
            "item" => $user
        ];
    }

    public function action(&$responseObj, &$jsonInputObj, &$responsecode, &$responseMessage)
    {
        if (empty($this->command) || ($this->command != "lists" && $this->command != "detail"))
            throw new Exception("Data tidak lengkap. Silahkan cek kembali data anda!", 422);

        if ($this->command == "lists") {
            $resObj = $this->_lists($jsonInputObj);
        } else if ($this->command == "detail") {
            $resObj = $this->_detail($jsonInputObj);
        }

        $responsecode = 200;
        $responseObj = $resObj;
    }


}