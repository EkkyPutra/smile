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
        $users = null;
        $start = 0;

        if (isset($jsonInputObj->page) && $jsonInputObj->page > 0 && isset($jsonInputObj->limit) && $jsonInputObj->limit > 0) {
            $currPage = $jsonInputObj->page;
            $limit    = $jsonInputObj->limit;
            $start    = ($jsonInputObj->page - 1) * $limit;
        }

        $params["project_id"] = isset($jsonInputObj->project_id) ? $jsonInputObj->project_id : 0;
        $totalProjects = $this->CI->project->totalProjectActivities($params);
        $rowsPerPage = 0;
        
        $activities = null;
        if ($totalProjects > 0) {
            $totalPage = ceil($totalProjects / $limit);
            $activities = $this->CI->project->getProjectActivities($params, false, $start, $limit);
            if (!is_null($activities)) {
                $rowsPerPage = count($activities);
            }

            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Project Activities Lists",
            "items" => $activities,
            "totalRows" => intval($totalProjects),
            "rowsPerPage" => $rowsPerPage,
            "currPage" => $currPage,
            "totalPage" => $totalPage,
            "limit" => $limit
        ];
    }

    private function _detail(&$responseObj, &$jsonInputObj, &$responsecode)
    {
        if (!isset($jsonInputObj->id) || $jsonInputObj->id <= 0)
            throw new Exception("Data tidak lengkap. Silahkan cek kembali data anda!", 422);

        $activity = $this->CI->project->getProjectActivityById($jsonInputObj->id);
        if (is_null($activity))
            throw new Exception("Acitivity tidak ditemukan. Silahkan cek kembali data anda.", 422);

        $responsecode = 200;
        $responseObj = [
            "name" => "Activity Detail",
            "item" => $activity
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