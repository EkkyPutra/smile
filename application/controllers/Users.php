<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/base/web_base.php';
date_default_timezone_set("Asia/Jakarta");

class Users extends web_base
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
        var_dump("ASDSAD");
    }

    public function doLogin()
    {
        $url = parent::build_api_url('users/login');
        $data = [
            "username" => !is_null($this->input->post("username_login")) ? $this->input->post("username_login", true) : null,
            "password" => !is_null($this->input->post("password_login")) ? md5($this->input->post("password_login", true)) : null
        ];

        $response = $this->somplakapi->run_curl_api($url, $data);
        $response = json_decode($response);

        if ($response->result == 200 && $response->message == "Success") {
            $admin = $response->data->item;
            $this->session->set_userdata('smile.pm', [
                "status" => "VALID",
                "name" => $admin->name,
                "username" => $admin->username,
                "role" => $admin->role,
                "email" => $admin->email,
                "avatar" => $admin->avatar,
                "handphone" => $admin->handphone,
                "last_login" => $admin->last_login
            ]);
        }

        echo json_encode($response);
    }

    public function doLogout()
    {
        $this->session->unset_userdata("smile.pm");
        $this->session->sess_destroy();
        redirect(BASE_URL . "login");
    }

    public function getData()
    {
        header('Content-Type: application/json');
        $url = parent::build_api_url('users/get/lists');
        $start = !is_null($this->input->get("start")) ? $this->input->get("start", true) : 0;
        $limit = !is_null($this->input->get("length")) ? $this->input->get("length", true) : 10;
        $page = ($limit > 0) ? (ceil($start / $limit) + 1) : 1;
        $data = [
            "role" => !is_null($this->input->get("role")) ? $this->input->get("role", true) : "all",
            "page" => $page,
            "limit" => $limit
        ];

        $order = $this->input->get("order");
        $orderField = "";
        $orderSort = "";
        switch (intval($order[0]["column"])) {
            case 2:
                $orderField = "name";
                $orderSort = $order[0]["dir"];
                break;
            case 3:
                $orderField = "user_role";
                $orderSort = $order[0]["dir"];
                break;
            case 4:
                $orderField = "user_divisi";
                $orderSort = $order[0]["dir"];
                break;
            case 3:
                $orderField = "handphone";
                $orderSort = $order[0]["dir"];
                break;
        }

        $data["sort"] = $orderField;
        $data["order"] = $orderSort;

        $response = $this->somplakapi->run_curl_api($url, $data);
        $resApi = json_decode($response);

        $draw = $this->input->get("draw");
        $totalRows = 0;
        $rowsPerPage = 0;
        $res = [];
        if ($resApi->result == 200) {
            $resData = $resApi->data->items;
            $totalRows = $resApi->data->totalRows;
            if (!is_null($resData)) {
                $rowsPerPage = count($resData);
                foreach ($resData as $key => $data) {
                    if (!empty($data->avatar)) {
                        if (@file_get_contents($data->avatar_thumb)) {
                            $resImage = $data->avatar_thumb;
                        } else {
                            $resImage = BASE_URL . IMAGE_DEFAULT_PATH . "no-avatar.png";
                        }
                    } else {
                        $resImage = BASE_URL . IMAGE_DEFAULT_PATH . "no-avatar.png";
                    }

                    switch ($data->user_role) {
                        case "administrator":
                            $userColor = "first";
                            break;
                        case "senior leader":
                            $userColor = "second";
                            break;
                        case "reguler user":
                            $userColor = "third";
                            break;
                        case "user project":
                            $userColor = "fourth";
                            break;
                        default:
                            $userColor = "fifth";
                            break;
                    }

                    $res[] = [
                        ($key + 1),
                        "<img src='" . $resImage . "' height='50' width='50' class='img-bordered-md img-circle' />",
                        ucwords($data->name),
                        '<div class="user-role ' . $userColor . '">' . ucwords($data->user_role) . '</div>',
                        ucwords($data->user_divisi),
                        $data->handphone,
                        "<button type='button' class='btn btn-outline-warning mr-2' onclick='editProduct(" . $data->id . ");'><i class='far fa-edit'></i></button><button type='button' class='btn btn-outline-danger' onclick='editProduct(" . $data->id . ");'><i class='far fa-trash-alt'></i></button>"
                    ];
                }
            }
        }

        $result = [
            "draw" => intval($draw),
            "recordsTotal" => $totalRows,
            "recordsFiltered" => $totalRows,
            "data" => !is_null($res) ? $res : []
        ];

        echo json_encode($result);
    }

    public function profile()
    {
        $profile = $this->session->userdata("smile.pm");
        $data["profile"] = $profile;

        $this->load->view("public/users_profile", $data);
    }

    public function management()
    {
        $this->load->view("public/users_management");
    }
}
