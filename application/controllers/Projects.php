<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/base/web_base.php';
date_default_timezone_set("Asia/Jakarta");

class Projects extends web_base
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
        redirect(base_url("../projects/management"));
    }

    public function management()
    {
        $url = parent::build_api_url('projects/get/lists');
        $response = $this->somplakapi->run_curl_api($url, ["page" => 1, "limit" => 10]);
        $resApi = json_decode($response);

        $urlProjectType = parent::build_api_url("masters/get/project");
        $responseProejctType = $this->somplakapi->run_curl_api($urlProjectType, []);
        $resApiProejctType = json_decode($responseProejctType);

        $urlDivisi = parent::build_api_url("masters/get/division");
        // if ($this->access_level->project->is_super == 1) {
            $paramsDivisi["all_divisi"] = true;
        // } else {
            // $paramsDivisi["all_disivi"] = false;
            // // $paramsDivisi["user_divisi"] = $this->smile_session["divisi"];
        // }
        $responseDivisi = $this->somplakapi->run_curl_api($urlDivisi, $paramsDivisi);
        $resApiDivisi = json_decode($responseDivisi);

        $urlProjectType = parent::build_api_url("masters/get/project");
        $responseProjectType = $this->somplakapi->run_curl_api($urlProjectType, []);
        $resApiProjectType = json_decode($responseProjectType);

        $urlProjectCount = parent::build_api_url("projects/get/count");
        $responseProejctCount = $this->somplakapi->run_curl_api($urlProjectCount, []);
        $resApiProejctCount = json_decode($responseProejctCount);

        $projectType = null;
        if ($resApiProejctType->result == 200)
            $projectType = $resApiProejctType->data->item;

        $usersDivisi = null;
        if ($resApiDivisi->result == 200)
            $usersDivisi = $resApiDivisi->data->item;

        $projectType = null;
        if ($resApiProjectType->result == 200)
            $projectType = $resApiProjectType->data->item;

        $totalPage = 0;
        if ($resApi->result == 200) {
            $totalPage = $resApi->data->totalPage;
        }

        $projectCount = null;
        if ($resApiProejctCount->result == 200)
            $projectCount = $resApiProejctCount->data->item;

        $data["is_performa"] = false;
        $data["projectType"] = $projectType;
        $data["usersDivisi"] = $usersDivisi;
        $data["totalPage"] = $totalPage;
        $data["isMobile"] = $this->agent->is_mobile();
        $data["user_access"] = $this->smile_session;
        $data["projectCount"] = $projectCount;

        $this->load->view("public/project_management", $data);
    }

    public function getData()
    {
        header('Content-Type: application/json');
        $url = parent::build_api_url('projects/get/lists');
        $user_access = $this->smile_session;
        $access_level = $user_access["access_level"];
        $start = !is_null($this->input->post("start")) ? $this->input->post("start", true) : 1;
        $limit = !is_null($this->input->post("limit")) ? $this->input->post("limit", true) : 10;

        $data = [
            "page" => $start,
            "limit" => $limit
        ];

        $params = $this->input->post("params");
        $data["type"] = !is_null($params) && isset($params["type"]) ? $params["type"] : "";
        $data["priority"] = (!is_null($params) && isset($params["priority"]) && !empty($params["priority"])) ? ($params["priority"] == "top" ? 1 : 0) : -1;
        $data["divisi"] = !is_null($params) && isset($params["divisi"]) ? $params["divisi"] : "";
        $data["query"] = !is_null($params) && isset($params["query"]) ? $params["query"] : "";
        $data["progress"] = (!is_null($params) && !empty($params["progress"])) ? $params["progress"] : "";
        $data["username"] = (!is_null($this->input->post("username")) && !empty($this->input->post("username"))) ? $this->input->post("username") : "";
        $deadline = (!is_null($params) && !empty($params["deadline"])) ? $params["deadline"] : "";
        // if (!empty($progress))
        //     $data["progress"] = explode("-", $progress);

        if (!empty($deadline))
            $data["deadline"] = explode("-", trim($deadline));

        $response = $this->somplakapi->run_curl_api($url, $data);
        $resApi = json_decode($response);

        $xRow = ($start - 1) * $limit;
        $totalPage = 0;
        $rowsPerPage = 0;
        $totalRows = 0;
        $res = [];
        $resMobile = [];
        $today = date("Y-m-d");
        if ($resApi->result == 200 && isset($resApi->data->items)) {
            $resData = $resApi->data->items;
            $totalPage = $resApi->data->totalPage;
            $totalRows = $resApi->data->totalRows;
            if (!is_null($resData)) {
                $rowsPerPage = count($resData);
                foreach ($resData as $key => $data) {
                    if ($data->progress > 0 && $data->progress <= 10) {
                        $bgProgressBar = "bg-red";
                    } else if ($data->progress > 11 && $data->progress <= 50) {
                        $bgProgressBar = "bg-yellow";
                    } else if ($data->progress > 51 && $data->progress <= 99) {
                        $bgProgressBar = "bg-blue";
                    } else {
                        $bgProgressBar = "bg-green";
                    }

                    $asAssign = false;
                    if (isset($access_level->activity->as_assign)) {
                        foreach ($data->pic as $pic) {
                            if ($user_access["name"] == $pic->pic_name) {
                                $asAssign = true;
                                break;
                            }
                        }
                    }

                    $strips = "";
                    if (strtotime($data->deadline) < strtotime($today)) {
                        $strips = "strips-late";
                    } else {
                        $strips = "strips-ontrack";
                    }

                    $userHandphone = !is_null($data->pic) ? $data->pic[0]->pic_handphone : "";
                    $userHandphone = (!empty($userHandphone) && substr($userHandphone, 0,1 ) == 0) ? "62" . substr($userHandphone, 1) : "";
                    $projectDivisi = $data->project_divisi;
                    $dataId = $data->id;
                    $data->id = ($xRow + 1);
                    $data->deadline = date("d/m/Y", strtotime($data->deadline));
                    $data->project_divisi = '<div class="table-seg-box" style="background-color: #' . $data->project_divisi_bg . '; color: #' . $data->project_divisi_color . '">' . ucwords($data->project_divisi) . '</div>';
                    $dataProgress = '<div class="progress">
                                        <div class="progress-bar ' . $bgProgressBar . ' progress-bar-striped" role="progressbar" style="width: ' . $data->progress . '%;" aria-valuenow="' . $data->progress . '" aria-valuemin="0" aria-valuemax="100">' . $data->progress . '%</div>
                                       </div>';
                    $data->progress = $data->progress . "%";
                    $data->activity = $data->last_activity;
                    $data->priority = ($data->priority == "Yes") ? "<span class='top-priority'><i class='fas fa-angle-double-up'></i> TOP</span>" : "";
                    $data->action = "";
                    // if ($access_level->project->is_super == 1 || ($access_level->project->as_divisi == 1 && strtoupper($user_access["divisi"]) == strtoupper($projectDivisi)) || $asAssign)
                    $data->action .= "<a class='btn btn-default btn-eye' href='" . base_url("../activities/lists/$data->slug"). "' data-toggle='tooltip' data-placement='bottom' title='View Project'><i class='far fa-eye'></i></button>";

                    $dataLink = !empty($data->link) ?  "href='" . $data->link . "' target='_blank'" : "javascript:void(0);";
                    $data->action .= "<a class='btn btn-default btn-wa' href='https://wa.me/" . $userHandphone . "' target='_blank' data-toggle='tooltip' data-placement='bottom' title='Whatsapp PIC Leader'><i class='fab fa-whatsapp'></i></a>";
                    $data->action .= "<a class='btn btn-default btn-link' " . $dataLink . " data-toggle='tooltip' data-placement='bottom' title='Evidence'><i class='fas fa-link'></i></a>";
                    // $data->action .= "<button class='btn btn-default btn-link' " . $dataLink . " data-placement='bottom' title='Evidence' data-toggle='modal' data-target='#modal-evidence'><i class='fas fa-link'></i></button>";

                    // if ($access_level->project->is_super == 1 || ($access_level->project->as_divisi == 1 && strtoupper($user_access["divisi"]) == strtoupper($projectDivisi)) || $asAssign)
                    $data->action .= "<a class='btn btn-default btn-comment' href='" . base_url("../activities/lists/$data->slug#comment-text") . "' data-toggle='tooltip' data-placement='bottom' title='Comment'><i class='far fa-comment'></i></a>";

                    if ($access_level->project->is_super == 1 || ($access_level->project->as_divisi == 1 && strtoupper($user_access["divisi"]) == strtoupper($projectDivisi) && intval($access_level->project->access->edit) == 1))
                        $data->action .= "<button type='button' class='btn btn-default btn-edit' data-toggle='modal' data-target='#modal-proyek' onclick='editProject(\"" . $data->slug . "\");' data-toggle='tooltip' data-placement='bottom' title='Edit Project'><i class='fas fa-edit'></i></button>";

                    if ($access_level->project->is_super == 1 || ($access_level->project->as_divisi == 1 && strtoupper($user_access["divisi"]) == strtoupper($projectDivisi) && intval($access_level->project->access->delete) == 1))
                        $data->action .= "<button type='button' class='btn btn-default btn-delete' onclick='removeProject(\"" . $dataId . "\");' data-toggle='tooltip' data-placement='bottom' title='Delete Project'><i class='far fa-trash-alt'></i></button>";

                    $data->strips = $strips;
                    $res[] = $data;

                    $dataMobile["id"] = ($key + 1);
                    $dataMobile["data"] = ''.
                        '<div class="datatable-project-mobile">'.
                        '   <label class="title">' . $data->name . '</label>'.
                        '   <label class="subs">Tipe : ' . $data->project_type . '</label>'.
                        '   <label class="subs">Due Date : ' . $data->deadline . '</label>'.
                        '   <div class="mobile-segs row">'.
                            $data->project_divisi.
                            $data->priority.
                        '   </div>' .
                            $dataProgress.
                        '   <div class="datatable-project-mobile-action">'.
                                $data->action.
                        '   </div>'.
                        '</div>';
                    '';
                    $dataMobile["strips"] = $strips;

                    $resMobile[] = $dataMobile;
                    $xRow++;
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

    public function getDetail()
    {
        header('Content-Type: application/json');
        $url = parent::build_api_url('projects/get/detail');
        $response = $this->somplakapi->run_curl_api($url, ["slug" => $this->input->post('slug')]);
        $resApi = json_decode($response);
        $resApi->data->item->deadline = date("d-m-Y", strtotime($resApi->data->item->deadline));

        echo json_encode($resApi);
    }

    public function doCreate()
    {
        header('Content-Type: application/json');
        $url = parent::build_api_url('projects/create');
        $data["name"] = !is_null($this->input->post("project_name")) ? $this->input->post("project_name") : "";
        $data["divisi"] = !is_null($this->input->post("project_divisi")) ? $this->input->post("project_divisi") : "";
        $data["priority"] = !is_null($this->input->post("project_priority")) ? $this->input->post("project_priority") : "";
        $data["type"] = !is_null($this->input->post("project_type")) ? $this->input->post("project_type") : "";
        $data["deadline"] = !is_null($this->input->post("project_deadline")) ? date("Y-m-d", strtotime($this->input->post("project_deadline"))) : "";
        $data["progress"] = !is_null($this->input->post("project_progress")) ? intval($this->input->post("project_progress")) : 0;
        $data["link"] = !is_null($this->input->post("project_link")) ? $this->input->post("project_link") : "";
        $data["description"] = !is_null($this->input->post("project_description")) ? $this->input->post("project_description") : "";
        $data["pic_ids"][] = [
            "id" => !is_null($this->input->post("pic_leader_id")) ? $this->input->post("pic_leader_id") : 0,
            "name" => !is_null($this->input->post("pic_leader_name")) ? $this->input->post("pic_leader_name") : "",
            "type" => 1
        ];

        if (!is_null($this->input->post("pic_member_id")) && !is_null($this->input->post("pic_member_name"))) {
            $picMembers = $this->input->post("pic_member_name");
            foreach ($this->input->post("pic_member_id") as $key => $picMember) {
                $data["pic_ids"][] = [
                    "id" => $picMember,
                    "name" => $picMembers[$key],
                    "type" => 0
                ];
            }
        }

        $response = $this->somplakapi->run_curl_api($url, $data);
        $response = json_decode($response);

        echo json_encode($response);
    }

    public function doUpdate()
    {
        header('Content-Type: application/json');
        $url = parent::build_api_url('projects/update');
        $data["id"] = !is_null($this->input->post("project_id")) ? $this->input->post("project_id") : "";
        $data["name"] = !is_null($this->input->post("project_name")) ? $this->input->post("project_name") : "";
        $data["divisi"] = !is_null($this->input->post("project_divisi")) ? $this->input->post("project_divisi") : "";
        $data["priority"] = !is_null($this->input->post("project_priority")) ? $this->input->post("project_priority") : "";
        $data["type"] = !is_null($this->input->post("project_type")) ? $this->input->post("project_type") : "";
        $data["deadline"] = !is_null($this->input->post("project_deadline")) ? date("Y-m-d", strtotime($this->input->post("project_deadline"))) : "";
        $data["progress"] = !is_null($this->input->post("project_progress")) ? intval($this->input->post("project_progress")) : 0;
        $data["link"] = !is_null($this->input->post("project_link")) ? $this->input->post("project_link") : "";
        $data["description"] = !is_null($this->input->post("project_description")) ? $this->input->post("project_description") : "";
        $data["pic_ids"][] = [
            "id" => !is_null($this->input->post("pic_leader_id")) ? $this->input->post("pic_leader_id") : 0,
            "name" => !is_null($this->input->post("pic_leader_name")) ? $this->input->post("pic_leader_name") : "",
            "type" => 1
        ];

        if (!is_null($this->input->post("pic_member_id")) && !is_null($this->input->post("pic_member_name"))) {
            $picMembers = $this->input->post("pic_member_name");
            foreach ($this->input->post("pic_member_id") as $key => $picMember) {
                $data["pic_ids"][] = [
                    "id" => $picMember,
                    "name" => $picMembers[$key],
                    "type" => 0
                ];
            }
        }

        $response = $this->somplakapi->run_curl_api($url, $data);
        $response = json_decode($response);

        echo json_encode($response);
    }

    public function doRemove()
    {
        header('Content-Type: application/json');
        $url = parent::build_api_url('projects/remove');
        $data["id"] = !is_null($this->input->post("id")) ? $this->input->post("id") : "";

        $response = $this->somplakapi->run_curl_api($url, $data);
        $response = json_decode($response);

        echo json_encode($response);
    }
}