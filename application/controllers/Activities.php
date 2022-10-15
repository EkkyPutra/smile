<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/base/web_base.php';
date_default_timezone_set("Asia/Jakarta");

class Activities extends web_base
{

    /**
     * Contructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array(
            'text',
            'url'
        ));

        $this->load->library(array(
            'myutils',
            'somplakapi',
            'user_agent'
        ));
    }

    public function index()
    {
        redirect(base_url("../activities/management"));
    }

    public function lists($slug = "")
    {
        $url = parent::build_api_url('projects/get/detail');
        $responseProject = $this->somplakapi->run_curl_api($url, ["slug" => $slug]);
        $resApiProject = json_decode($responseProject);

        $projectDetail = null;
        if ($resApiProject->result == 200) {
            $projectDetail = $resApiProject->data->item;
        }

        if (!is_null($projectDetail) && isset($projectDetail->pic->leader) && !empty($projectDetail->pic->leader)) {
            $picLeader = $projectDetail->pic->leader[0];
            $picLeaderInitial = "";
            foreach (explode(" ", $picLeader->pic_name) as $leaderInit) {
                $picLeaderInitial .= substr($leaderInit, 0, 1);
            }

            $picLeader->pic_init = $picLeaderInitial;
            $data["projectPicLeader"] = $picLeader;
        }

        $urlActivities = parent::build_api_url('activities/get/lists');
        $responseActivities = $this->somplakapi->run_curl_api($urlActivities, ["page" => 1, "limit" => 10]);
        $resApiActivities = json_decode($responseActivities);

        $totalPage = 0;
        if ($resApiActivities->result == 200) {
            $totalPage = $resApiActivities->data->totalPage;
        }

        $urlComments = parent::build_api_url('comments/get');
        $responseComments = $this->somplakapi->run_curl_api($urlComments, ["project_id" => $projectDetail->id]);
        $resApiComments = json_decode($responseComments);

        $comments = null;
        if ($resApiComments->result == 200) {
            $comments = $resApiComments->data->item;
        }

        $data["projectDetail"] = $projectDetail;
        $data["totalPage"] = $totalPage;
        $data["comments"] = $comments;
        $data["isMobile"] = $this->agent->is_mobile();

        $this->load->view("public/project_activity", $data);
    }

    public function getData()
    {
        header('Content-Type: application/json');
        $url = parent::build_api_url('activities/get/lists');
        $start = !is_null($this->input->post("start")) ? $this->input->post("start", true) : 1;
        $limit = !is_null($this->input->post("limit")) ? $this->input->post("limit", true) : 10;
        $project_id = !is_null($this->input->post("project_id")) ? $this->input->post("project_id", true) : 10;

        $data = [
            "project_id" => $project_id,
            "page" => $start,
            "limit" => $limit
        ];

        $response = $this->somplakapi->run_curl_api($url, $data);
        $resApi = json_decode($response);

        $totalPage = 0;
        $rowsPerPage = 0;
        $totalRows = 0;
        $res = [];
        $resMobile = [];

        if ($resApi->result == 200) {
            $resData = $resApi->data->items;
            $totalPage = $resApi->data->totalPage;
            $totalRows = $resApi->data->totalRows;
            if (!is_null($resData)) {
                $rowsPerPage = count($resData);
                foreach ($resData as $key => $data) {
                    if ($data->progress > 0 && $data->progress <= 25) {
                        $bgProgressBar = "bg-info";
                    } else if ($data->progress > 25 && $data->progress <= 50) {
                        $bgProgressBar = "bg-warning";
                    } else if ($data->progress > 50 && $data->progress <= 75) {
                        $bgProgressBar = "bg-primary";
                    } else {
                        $bgProgressBar = "bg-danger";
                    }

                    $dataId = $data->id;
                    $data->id = ($key + 1);
                    $data->updated = date("d/m/Y", strtotime($data->updated));
                    $data->progress = '<div class="progress">
                                        <div class="progress-bar ' . $bgProgressBar . ' progress-bar-striped" role="progressbar" style="width: ' . $data->progress . '%;" aria-valuenow="' . $data->progress . '" aria-valuemin="0" aria-valuemax="100">' . $data->progress . '%</div>
                                       </div>';
                    $data->evidence = "<a class='btn btn-outline-primary mr-1' href='" . $data->evidence . "' target='_blank'><i class='fas fa-link'></i></a>";
                    $data->action = "<button type='button' class='btn btn-outline-warning mr-1' data-toggle='modal' data-target='#modal-activity' onclick='editActivity(\"" . $dataId . "\");'><i class='far fa-edit'></i></button>
                                     <button type='button' class='btn btn-outline-danger' onclick='removeActivity(\"" . $dataId . "\");'><i class='far fa-trash-alt'></i></button>";
                    $res[] = $data;

                    $dataMobile["data"] = ''.
                        '<div class="datatable-activity-mobile">'.
                        '   <label class="title">' . $data->name . '</label>'.
                        '   <label class="subs">Last Update : ' . $data->updated . '</label>'.
                            $data->progress.
                        '   <div class="datatable-activity-mobile-action">' .
                        '       <a class="btn btn-outline-primary mr-1" href="' . $data->evidence . '" target="_blank"><i class="fas fa-link"></i></a>'.
                                $data->action.
                        '   </div>'.
                        '</div>'.
                        '';

                    $resMobile[] = $dataMobile;
                }
            }
        }

        $resData = ($this->agent->is_mobile() ? $resMobile : $res);
        $result = [
            "draw" => 1,
            "recordsTotal" => $totalPage,
            "recordsFiltered" => $rowsPerPage,
            "totalRows" => $totalRows,
            "data" => !is_null($resData) && !empty($resData) ? $resData : [],
            "isMobile" =>  $this->agent->is_mobile()
        ];

        echo json_encode($result);
    }

    public function doCreate()
    {
        header('Content-Type: application/json');
        $url = parent::build_api_url('activities/create');
        $user = $this->smile_session["username"];
        $data["user"] = $user;
        $data["project_id"] = !is_null($this->input->post("activities_project_id")) ? $this->input->post("activities_project_id") : "";
        $data["name"] = !is_null($this->input->post("activities_name")) ? $this->input->post("activities_name") : "";
        $data["progress"] = !is_null($this->input->post("activities_progress")) ? $this->input->post("activities_progress") : "";
        $data["evidence"] = !is_null($this->input->post("activities_evidence")) ? $this->input->post("activities_evidence") : "";

        $response = $this->somplakapi->run_curl_api($url, $data);
        $response = json_decode($response);

        echo json_encode($response);
    }

    public function getDetail()
    {
        header('Content-Type: application/json');
        $url = parent::build_api_url('activities/get/detail');
        $response = $this->somplakapi->run_curl_api($url, ["id" => $this->input->post('id')]);
        $resApi = json_decode($response);

        echo json_encode($resApi);
    }

    public function doUpdate()
    {
        header('Content-Type: application/json');
        $url = parent::build_api_url('activities/update');
        $user = $this->smile_session["username"];
        $data["user"] = $user;
        $data["id"] = !is_null($this->input->post("activities_id")) ? $this->input->post("activities_id") : "";
        $data["name"] = !is_null($this->input->post("activities_name")) ? $this->input->post("activities_name") : "";
        $data["progress"] = !is_null($this->input->post("activities_progress")) ? $this->input->post("activities_progress") : "";
        $data["evidence"] = !is_null($this->input->post("activities_evidence")) ? $this->input->post("activities_evidence") : "";

        $response = $this->somplakapi->run_curl_api($url, $data);
        $response = json_decode($response);

        echo json_encode($response);
    }

    public function doRemove()
    {
        header('Content-Type: application/json');
        $url = parent::build_api_url('activities/remove');
        $data["id"] = !is_null($this->input->post("id")) ? $this->input->post("id") : "";

        $response = $this->somplakapi->run_curl_api($url, $data);
        $response = json_decode($response);

        echo json_encode($response);
    }

    public function addCommentReply()
    {
        header('Content-Type: application/json');
        $url = parent::build_api_url('comments/add');
        $user = $this->smile_session["username"];
        $data["user"] = $user;
        $data["project_id"] = !is_null($this->input->post("project_id")) ? $this->input->post("project_id") : "";
        $data["comment"] = !is_null($this->input->post("comment")) ? $this->input->post("comment") : "";
        $data["comment_id"] = !is_null($this->input->post("comment_id")) ? $this->input->post("comment_id") : 0;

        $response = $this->somplakapi->run_curl_api($url, $data);
        $response = json_decode($response);

        echo json_encode($response);
    }

}