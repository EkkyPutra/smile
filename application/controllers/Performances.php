<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/base/web_base.php';
date_default_timezone_set("Asia/Jakarta");

class Performances extends web_base
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
        redirect(base_url("../performances/management"));
    }

    public function management()
    {
        $url = parent::build_api_url('performances/get/lists');
        $response = $this->somplakapi->run_curl_api($url, ["page" => 1, "limit" => 10]);
        $resApi = json_decode($response);

        $urlDivisi = parent::build_api_url("masters/get/division");
        $responseDivisi = $this->somplakapi->run_curl_api($urlDivisi, []);
        $resApiDivisi = json_decode($responseDivisi);

        $usersDivisi = null;
        if ($resApiDivisi->result == 200)
            $usersDivisi = $resApiDivisi->data->item;

        $totalPage = 0;
        if ($resApi->result == 200) {
            $totalPage = $resApi->data->totalPage;
        }

        $data["usersDivisi"] = $usersDivisi;
        $data["totalPage"] = $totalPage;
        $data["isMobile"] = $this->agent->is_mobile();

        $this->load->view("public/performance_management", $data);
    }

    public function getData()
    {
        header('Content-Type: application/json');
        $url = parent::build_api_url('performances/get/lists');
        $start = !is_null($this->input->post("start")) ? $this->input->post("start", true) : 1;
        $limit = !is_null($this->input->post("limit")) ? $this->input->post("limit", true) : 10;

        $data = [
            "divisi" => !is_null($this->input->post("user_divisi")) ? $this->input->post("user_divisi", true) : "all",
            "page" => $start,
            "limit" => $limit
        ];

        $params = $this->input->post("params");
        $data["query"] = !is_null($params) && isset($params["query"]) ? $params["query"] : "";

        $response = $this->somplakapi->run_curl_api($url, $data);
        $resApi = json_decode($response);
        $xRow = ($start - 1) * $limit;
        $totalPage = 0;
        $rowsPerPage = 0;
        $totalRows = 0;
        $res = [];
        $resMobile = [];

        if ($resApi->result == 200 && isset($resApi->data->items)) {
            $resData = $resApi->data->items;
            $totalPage = $resApi->data->totalPage;
            $totalRows = $resApi->data->totalRows;
            if (!is_null($resData)) {
                $rowsPerPage = count($resData);
                foreach ($resData as $key => $data) {
                    $data->id = ($xRow + 1);
                    $data->user_divisi = '<div class="table-seg-box" style="background-color: #' . $data->user_divisi_bg . '; color: #' . $data->user_divisi_color . '">' . ucwords($data->user_divisi) . '</div>';
                    $data->action = "<a href='" . base_url("../performances/detail/" . $data->username) ."' class='btn btn-default btn-eye btn-single mr-2'><i class='far fa-eye'></i></a>";
                    $res[] = $data;

                    $dataMobile["data"] = ''.
                        '<div class="datatable-activity-mobile">'.
                        '   <label class="title">' . $data->name . '</label>'.
                        '   <label class="mb-2">Proyek On Track <span class="subs-right">' . $data->project->ontrack . '</span></label>'.
                        '   <label class="mb-2">Proyek Terlambat <span class="subs-right">' . $data->project->late . '</span></label>'.
                        '   <label class="mb-2">Proyek Selesai <span class="subs-right">' . $data->project->complete . '</span></label>'.
                        '   <div class="mobile-segs row">'.
                                $data->user_divisi.
                        '   </div>'.
                        '   <div class="datatable-activity-mobile-action">'.
                                $data->action.
                        '   </div>'.
                        '</div>';
                    '';

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

    public function detail($username)
    {
        $url = parent::build_api_url('projects/get/lists');
        $response = $this->somplakapi->run_curl_api($url, ["page" => 1, "limit" => 10]);
        $resApi = json_decode($response);

        $urlProjectType = parent::build_api_url("masters/get/project");
        $responseProejctType = $this->somplakapi->run_curl_api($urlProjectType, []);
        $resApiProejctType = json_decode($responseProejctType);

        $urlMemberDetail = parent::build_api_url("performances/get/detail");
        $responseMemberDetail = $this->somplakapi->run_curl_api($urlMemberDetail, ["username" => $username]);
        $resApiMemberDetail = json_decode($responseMemberDetail);

        $urlDivisi = parent::build_api_url("masters/get/division");
        $responseDivisi = $this->somplakapi->run_curl_api($urlDivisi, []);
        $resApiDivisi = json_decode($responseDivisi);

        $projectType = null;
        if ($resApiProejctType->result == 200)
            $projectType = $resApiProejctType->data->item;

        $memberDetail = null;
        if ($resApiMemberDetail->result == 200)
            $memberDetail = $resApiMemberDetail->data->item;

        $usersDivisi = null;
        if ($resApiDivisi->result == 200)
            $usersDivisi = $resApiDivisi->data->item;

        $totalPage = 0;
        if ($resApi->result == 200) {
            $totalPage = $resApi->data->totalPage;
        }

        $data["is_performa"] = true;
        $data["projectType"] = $projectType;
        $data["memberDetail"] = $memberDetail;
        $data["usersDivisi"] = $usersDivisi;
        $data["totalPage"] = $totalPage;
        $data["isMobile"] = $this->agent->is_mobile();
        $data["user_access"] = $this->smile_session;

        $this->load->view("public/project_management", $data);
    }
}