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

    public function action(&$responseObj, &$jsonInputObj, &$responsecode, &$responseMessage)
    {
        if (!isset($jsonInputObj->project_id))
            throw new Exception("Data tidak lengkap. Silahkan cek kembali data anda!", 422);

        $project = $this->CI->project->getProjectById($jsonInputObj->project_id);
        if (is_null($project))
            throw new Exception("Project tidak ditemukan. Silahkan cek kembali data anda.", 422);

        $getComments = $this->CI->comment->getComments($project->id);
        $totalComments = $this->CI->comment->totalComments($project->id);

        $comments = null;
        if (!is_null($getComments)) {
            foreach ($getComments as $comment) {
                $replys = $this->CI->comment->getComments($project->id, $comment->id);

                $comment->reply = $replys;
                $comments[] = $comment;
            }
        }

        $responsecode = 200;
        $responseObj = [
            "name" => "Comments Lists",
            "item" => [
                "items" => $comments,
                "total" => $totalComments
            ]
        ];
    }
}
