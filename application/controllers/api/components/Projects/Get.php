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
        $totalPage = 10;
        $currPage = 1;
        $limit = 200;
        $totalPage = 1;
        $start = 0;

        if (isset($jsonInputObj->page) && $jsonInputObj->page > 0 && isset($jsonInputObj->limit) && $jsonInputObj->limit > 0) {
            $currPage = $jsonInputObj->page;
            $limit    = $jsonInputObj->limit;
            $start    = ($jsonInputObj->page - 1) * $limit;
        }

        $params = null;
        if (isset($jsonInputObj->type) && !empty($jsonInputObj->type)) {
            $type = $this->CI->master->getMasterByTypeValue(2, $jsonInputObj->type);
            if (!is_null($type))
                $params["type"] = $type->id;
        }

        if (isset($jsonInputObj->divisi) && !empty($jsonInputObj->divisi)) {
            $divisi = $this->CI->master->getMasterByTypeValue(3, $jsonInputObj->divisi);
            if (!is_null($divisi))
                $params["divisi"] = $divisi->id;
        }

        $query = (isset($jsonInputObj->query) && !empty($jsonInputObj->query)) ? $jsonInputObj->query : null;

        if (isset($jsonInputObj->priority) && $jsonInputObj->priority > -1)
            $params["priority"] = $jsonInputObj->priority;

        if (isset($jsonInputObj->progress) && !empty($jsonInputObj->progress) && $jsonInputObj->progress > 0)
            $params["progress"] = $jsonInputObj->progress;

        if (isset($jsonInputObj->username) && !empty($jsonInputObj->username))
            $params["username"] = $jsonInputObj->username;

        if (isset($jsonInputObj->progress) && !empty($jsonInputObj->progress))
            $params["progress"] = $jsonInputObj->progress;

        // if (isset($jsonInputObj->deadline) && !empty($jsonInputObj->deadline)) {
        //     $params["deadline"] = [
        //         date("Y-m-d", strtotime($jsonInputObj->deadline[0])),
        //         date("Y-m-d", strtotime($jsonInputObj->deadline[1]))
        //     ];            
        // }

            
        if (!is_null($query))
            $params["query"] = $query;

        $totalProjects = $this->CI->project->totalProjects($params);
        $rowsPerPage = 0;
        
        $projects = null;
        if ($totalProjects > 0) {
            $totalPage = ceil($totalProjects / $limit);
            $getProjects = $this->CI->project->getProjects($params, $start, $limit);
            $projectsTop = [];
            $projectsBottom = [];
            if (!is_null($getProjects)) {
                $rowsPerPage = count($getProjects);
                foreach ($getProjects as $project) {
                    $projectMembers = $this->CI->project->getProjectMembers($project->id);
                    $lastActivity = $this->CI->project->getLastActivityByProjectId($project->id);

                    $project->priority = ($project->priority == 1) ? "Yes" : "No";
                    $project->project_type = strtoupper($project->project_type);
                    $project->pic = $projectMembers;

                    $project->last_activity = (!is_null($lastActivity) ? $lastActivity->name : "-");

                    if ($project->progress < 100)
                        $projectsTop[] = $project;
                    else
                        $projectsBottom[] = $project;

                }
            }

            $projects = array_merge($projectsTop, $projectsBottom);

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

    private function _detail(&$responseObj, &$jsonInputObj, &$responsecode)
    {
        if (!isset($jsonInputObj->slug) || empty($jsonInputObj->slug))
            throw new Exception("Data tidak lengkap. Silahkan cek kembali data anda!", 422);

        $project = $this->CI->project->getProjectBySlug($jsonInputObj->slug);
        if (is_null($project))
            throw new Exception("Project tidak ditemukan. Silahkan cek kembali data anda.", 422);

        $projectMembers = $this->CI->project->getProjectMembers($project->id);

        $lastProgress = $this->CI->project->getLastProgressActivity($project->id);
        $members = null;
        if (!is_null($projectMembers)) {
            foreach ($projectMembers as $pMember) {
                $pMember->pic_id = intval($pMember->pic_id);
                $pMember->avatar_thumb = !empty($pMember->avatar) ? BASE_URL . "files/thumbs/avatar/" . $pMember->avatar : "";
                $pMember->avatar = !empty($pMember->avatar) ? BASE_URL . "files/images/avatar/" . $pMember->avatar : "";

                if ($pMember->pic_type == "pic_leader")
                    $members["leader"][] = $pMember;
                else 
                    $members["members"][] = $pMember;
            }
        }
        $project->pic = $members;
        $project->last_progress = ($lastProgress != 0) ? $lastProgress : $project->progress;
        $project->deadline = date("d F Y", strtotime($project->deadline));
        $project = $project;
        $responsecode = 200;
        $responseObj = [
            "name" => "Project Detail",
            "item" => $project
        ];
    }

    private function _count(&$responseObj, &$jsonInputObj, &$responsecode)
    {
        $today = date("Y-m-d H:i:s");
        $projectOnTrack = $this->CI->project->getTotalProjectByStatus($today, "ontrack");
        $projectLate = $this->CI->project->getTotalProjectByStatus($today, "late");
        $projectComplete = $this->CI->project->getTotalProjectByStatus($today, "complete");
        $totalProject = $this->CI->project->totalProjects();

        $responsecode = 200;
        $responseObj = [
            "name" => "Count of Project",
            "item" => [
                "complete" => intval($projectComplete),
                "onTrack" => intval($projectOnTrack),
                "late" => intval($projectLate),
                "total" => intval($totalProject)
            ]
        ];
    }

    public function action(&$responseObj, &$jsonInputObj, &$responsecode, &$responseMessage)
    {
        if (empty($this->command) || ($this->command != "lists" && $this->command != "detail" && $this->command != "count"))
        throw new Exception("Data tidak lengkap. Silahkan cek kembali data anda!", 422);

        if ($this->command == "lists") {
            $this->_lists($responseObj, $jsonInputObj, $responsecode);
        } else if ($this->command == "detail") {
            $this->_detail($responseObj, $jsonInputObj, $responsecode);
        } else if ($this->command == "count") {
            $this->_count($responseObj, $jsonInputObj, $responsecode);
        }
    }

}