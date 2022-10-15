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

    private function _lists(&$responseObj, &$jsonInputObj, &$responsecode)
    {
        $currPage = 1;
        $limit = 200;
        $totalPage = 1;
        $rowsPerPage = 0;
        $users = null;
        $start = 0;

        if (isset($jsonInputObj->page) && $jsonInputObj->page > 0 && isset($jsonInputObj->limit) && $jsonInputObj->limit > 0) {
            $currPage = $jsonInputObj->page;
            $limit    = $jsonInputObj->limit;
            $start    = ($jsonInputObj->page - 1) * $limit;
        }

        $divisi = (isset($jsonInputObj->divisi) && $jsonInputObj->divisi != "all") ? $jsonInputObj->divisi : "";
        $getDivisi = $this->CI->master->getMasterByTypeValue(3, $divisi);
        if (!empty($divisi) && is_null($getDivisi))
            throw new Exception("Divisi User tidak ditemukan!", 401);

        $query = (isset($jsonInputObj->query) && !empty($jsonInputObj->query)) ? $jsonInputObj->query : null;
        $divisi = !is_null($getDivisi) ? $getDivisi->id : 0;
        $totalUsers = $this->CI->user->totalUsers(-1, $divisi);

        $today = date("Y-m-d");
        if ($totalUsers > 0) {
            $totalPage = ceil($totalUsers / $limit);
            $getUsers = $this->CI->user->getUsers(-1, $start, $limit, "", $query, $divisi);

            if (!is_null($getUsers)) {
                $rowsPerPage = count($getUsers);
                foreach ($getUsers as $user) {
                    $projectOnTrack = $this->CI->project->getCountProject($user->id, $today, "track");
                    $projectComplete = $this->CI->project->getCountProject($user->id, $today, "complete");
                    $projectLate = $this->CI->project->getCountProject($user->id, $today, "late");


                    $user->avatar_thumb = !empty($user->avatar) ? "./files/thumbs/avatar/" . $user->avatar : "";
                    $user->avatar = !empty($user->avatar) ? "./files/images/avatar/" . $user->avatar : "";
                    $user->project = (object) [
                        "ontrack" => intval($projectOnTrack),
                        "complete" => intval($projectComplete),
                        "late" => intval($projectLate)
                    ];
                    $users[] = $user;
                }
            }
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Performance Member Lists",
            "items" => $users,
            "totalRows" => intval($totalUsers),
            "rowsPerPage" => $rowsPerPage,
            "currPage" => $currPage,
            "totalPage" => $totalPage,
            "limit" => $limit
        ];
    }

    private function _detail(&$responseObj, &$jsonInputObj, &$responsecode)
    {
        if (!isset($jsonInputObj->username) || empty($jsonInputObj->username))
            throw new Exception("Data tidak lengkap. Silahkan cek kembali data anda!", 422);

        $user = $this->CI->user->getUserByUsername($jsonInputObj->username);

        if (is_null($user))
            throw new Exception("User tidak ditemukan. Silahkan cek kembali data anda!", 422);

        $today = date("Y-m-d");
        $totalProject = $this->CI->project->getCountProject($user->id, $today, "all");
        $totalProjectBau = $this->CI->project->getCountProject($user->id, $today, "all", true);
        $projectOnTrack = $this->CI->project->getCountProject($user->id, $today, "track");
        $projectComplete = $this->CI->project->getCountProject($user->id, $today, "complete");
        $projectLate = $this->CI->project->getCountProject($user->id, $today, "late");

        unset($user->id);
        $user->avatar_thumb = !empty($user->avatar) ? "./files/thumbs/avatar/" . $user->avatar : "";
        $user->avatar = !empty($user->avatar) ? "./files/images/avatar/" . $user->avatar : "";
        $user->totalProject = intval($totalProject);
        $user->totalProjectBau = intval($totalProjectBau);
        $user->projectOnTrack = intval($projectOnTrack);
        $user->projectComplete = intval($projectComplete);
        $user->projectLate = intval($projectLate);

        $responsecode = 200;
        $responseObj = [
            "name" => "Member Performance Detail",
            "item" => $user
        ];
    }

    public function action(&$responseObj, &$jsonInputObj, &$responsecode, &$responseMessage)
    {
        if (empty($this->command) || ($this->command != "lists" && $this->command != "detail"))
            throw new Exception("Data tidak lengkap. Silahkan cek kembali data anda!", 422);

        if ($this->command == "lists") {
            $this->_lists($responseObj, $jsonInputObj, $responsecode);
        } else if ($this->command == "detail") {
            $this->_detail($responseObj, $jsonInputObj, $responsecode);
        }
    }
}