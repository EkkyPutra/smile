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

        $params = null;
        $totalProjects = $this->CI->project->totalProjects($params);
        $rowsPerPage = 0;
        
        $projects = null;
        if ($totalProjects > 0) {
            $totalPage = ceil($totalProjects / $limit);
            $getProjects = $this->CI->project->getProjects($params, $start, $limit);
            if (!is_null($getProjects)) {
                $rowsPerPage = count($getProjects);
                foreach ($getProjects as $project) {
                    $projectMembers = $this->CI->project->getProjectMembers($project->id);
                    $project->priority = ($project->priority == 1) ? "Yes" : "No";
                    $project->project_type = strtoupper($project->project_type);
                    $project->pic = $projectMembers;
                    $projects[] = $project;
                }
            }

            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Projects Lists",
            "items" => $projects,
            "totalRows" => intval($totalProjects),
            "rowsPerPage" => $rowsPerPage,
            "currPage" => $currPage,
            "totalPage" => $totalPage,
            "limit" => $limit
        ];
    }

    public function action(&$responseObj, &$jsonInputObj, &$responsecode, &$responseMessage)
    {
        if (empty($this->command) || ($this->command != "lists" && $this->command != "detail"))
        throw new Exception("Data tidak lengkap. Silahkan cek kembali data anda!", 422);

        if ($this->command == "lists") {
            $this->_lists($responseObj, $jsonInputObj, $responsecode);
        } else if ($this->command == "detail") {
            // $this->_detail($jsonInputObj);
        }
    }

}