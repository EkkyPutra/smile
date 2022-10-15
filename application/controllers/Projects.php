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
        $responseDivisi = $this->somplakapi->run_curl_api($urlDivisi, []);
        $resApiDivisi = json_decode($responseDivisi);

        $projectType = null;
        if ($resApiProejctType->result == 200)
            $projectType = $resApiProejctType->data->item;

        $usersDivisi = null;
        if ($resApiDivisi->result == 200)
            $usersDivisi = $resApiDivisi->data->item;

        $totalPage = 0;
        if ($resApi->result == 200) {
            $totalPage = $resApi->data->totalPage;
        }

        $data["is_performa"] = false;
        $data["projectType"] = $projectType;
        $data["usersDivisi"] = $usersDivisi;
        $data["totalPage"] = $totalPage;
        $data["isMobile"] = $this->agent->is_mobile();

        $this->load->view("public/project_management", $data);
    }

    public function getData()
    {
        header('Content-Type: application/json');
        $url = parent::build_api_url('projects/get/lists');
        $start = !is_null($this->input->post("start")) ? $this->input->post("start", true) : 1;
        $limit = !is_null($this->input->post("limit")) ? $this->input->post("limit", true) : 10;

        $data = [
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

                    $userHandphone = !is_null($data->pic) ? $data->pic[0]->pic_handphone : "";
                    $userHandphone = (!empty($userHandphone) && substr($userHandphone, 0,1 ) == 0) ? "62" . substr($userHandphone, 1) : "";
                    $dataId = $data->id;
                    $data->id = ($key + 1);
                    $data->deadline = date("d/m/Y", strtotime($data->deadline));
                    $data->project_divisi = '<div class="table-seg-box" style="background-color: #' . $data->project_divisi_bg . '; color: #' . $data->project_divisi_color . '">' . ucwords($data->project_divisi) . '</div>';
                    $data->progress = '<div class="progress">
                                        <div class="progress-bar ' . $bgProgressBar . ' progress-bar-striped" role="progressbar" style="width: ' . $data->progress . '%;" aria-valuenow="' . $data->progress . '" aria-valuemin="0" aria-valuemax="100">' . $data->progress . '%</div>
                                       </div>';
                    $data->priority = ($data->priority == "Yes") ? "<span class='top-priority'><i class='fas fa-angle-double-up'></i> TOP</span>" : "";
                    $data->action = "<a class='btn btn-outline-success mr-1' href='" . base_url("../activities/lists/$data->slug"). "'><i class='far fa-eye'></i></button>
                                     <a class='btn btn-outline-warning mr-1' href='https://wa.me/" . $userHandphone . "' target='_blank'><i class='fab fa-whatsapp'></i></a>
                                     <a class='btn btn-outline-primary mr-1' href='" . $data->link . "' target='_blank'><i class='fas fa-link'></i></a>
                                     <button type='button' class='btn btn-outline-info mr-1' onclick='editProject(\"" . $dataId . "\");'><i class='fas fa-edit'></i></button>
                                     <button type='button' class='btn btn-outline-danger' onclick='removeProject(\"" . $dataId . "\");'><i class='far fa-trash-alt'></i></button>";
                    $res[] = $data;

                    $dataMobile["data"] = ''.
                        '<div class="datatable-project-mobile">'.
                        '   <label class="title">' . $data->name . '</label>'.
                        '   <label class="subs">Tipe : ' . $data->project_type . '</label>'.
                        '   <label class="subs">Due Date : ' . $data->deadline . '</label>'.
                        '   <div class="mobile-segs row">'.
                            $data->project_divisi.
                            $data->priority.
                        '   </div>' .
                            $data->progress.
                        '   <div class="datatable-project-mobile-action">'.
                                $data->action.
                        '   </div>'.
                        '</div>';
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

    public function getDetail()
    {
        header('Content-Type: application/json');
        $url = parent::build_api_url('projects/get/detail');
        $response = $this->somplakapi->run_curl_api($url, ["id" => $this->input->post('id')]);
        $resApi = json_decode($response);

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
            "type" => 1
        ];

        if (!is_null($this->input->post("pic_member_id"))) {
            foreach ($this->input->post("pic_member_id") as $picMember) {
                $data["pic_ids"][] = [
                    "id" => $picMember,
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