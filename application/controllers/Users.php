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
        redirect(base_url("../users/management"));
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

        if ($response->result == 200) {
            $admin = $response->data->item;
            $this->session->set_userdata('smile.pm', [
                "status" => "VALID",
                "name" => $admin->name,
                "username" => $admin->username,
                "role" => $admin->role,
                "divisi" => $admin->divisi,
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
        $start = !is_null($this->input->post("start")) ? $this->input->post("start", true) : 1;
        $limit = !is_null($this->input->post("limit")) ? $this->input->post("limit", true) : 10;

        $data = [
            "role" => !is_null($this->input->post("user_role")) ? $this->input->post("user_role", true) : "all",
            "page" => $start,
            "limit" => $limit
        ];

        $data["query"] = !is_null($this->input->post("query")) ? $this->input->post("query") : "";

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
                    if (!empty($data->avatar)) {
                        if (@file_get_contents($data->avatar_thumb)) {
                            $resImage = str_replace("./", "/", $data->avatar_thumb);
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

                    $data->id = ($key + 1);
                    $data->avatar_thumb = "<img src='" . $resImage . "' height='50' width='50' class='img-bordered-md img-circle' />";
                    $data->user_role = '<div class="user-role ' . $userColor . '">' . ucwords($data->user_role) . '</div>';
                    $data->action = "<button type='button' class='btn btn-outline-warning mr-2' data-toggle='modal' data-target='#modal-lg' onclick='editUser(\"" . $data->username . "\");'><i class='far fa-edit'></i></button><button type='button' class='btn btn-outline-danger' onclick='removeUser(\"" . $data->username . "\");'><i class='far fa-trash-alt'></i></button>";
                    $res[] = $data;

                    $dataMobile["data"] = '' .
                        '<div class="datatable-activity-mobile">' .
                            $data->avatar_thumb.
                        '   <label class="title">' . $data->name . '</label>' .
                        '   <div class="mobile-segs row">' .
                                $data->user_role.
                        '   </div>' .
                        '   <label class="subs">' . $data->user_divisi . ' | ' . $data->handphone . '</label>' .
                        '   <div class="datatable-activity-mobile-action">' .
                                $data->action .
                        '   </div>' .
                        '</div>' .
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

    public function listsAjax()
    {
        header('Content-Type: application/json');
        $url = parent::build_api_url('users/get/lists');

        $data = [
            "query" => !is_null($this->input->get("term")) ? $this->input->get("term", true) : "",
            "page" => 1,
            "limit" => 100
        ];

        $response = $this->somplakapi->run_curl_api($url, $data);
        $resApi = json_decode($response);

        $result = [];
        if ($resApi->result == 200) {
            $resData = $resApi->data->items;
            if (!is_null($resData)) {
                foreach ($resData as $key => $data) {
                    $result[] = $data;
                }
            }
        }

        echo json_encode($result);
    }


    public function doCreate()
    {
        header('Content-Type: application/json');
        $url = parent::build_api_url('users/create');
        $data["name"] = !is_null($this->input->post("user_name")) ? $this->input->post("user_name") : "";
        $data["divisi"] = !is_null($this->input->post("user_divisi")) ? intval($this->input->post("user_divisi")) : 0;
        $data["role"] = !is_null($this->input->post("user_role")) ? intval($this->input->post("user_role")) : 0;
        $data["username"] = !is_null($this->input->post("username")) ? $this->input->post("username") : "";
        $data["handphone"] = !is_null($this->input->post("handphone")) ? $this->input->post("handphone") : "";

        if (isset($_FILES['user_avatar']['name']) && $_FILES['user_avatar']['name'] != "") {
            $avatarTmpPath = $_FILES['user_avatar']['tmp_name'];
            $avatar = file_get_contents($avatarTmpPath);
            $data["avatar"] = base64_encode($avatar);
        }

        $response = $this->somplakapi->run_curl_api($url, $data);
        $response = json_decode($response);

        echo json_encode($response);
    }

    public function profile()
    {
        $profile = $this->session->userdata("smile.pm");
        $data["profile"] = $profile;

        $this->load->view("public/users_profile", $data);
    }

    public function management()
    {
        $url = parent::build_api_url('users/get/lists');
        $response = $this->somplakapi->run_curl_api($url, ["page" => 1, "limit" => 10]);
        $resApi = json_decode($response);

        $urlRole = parent::build_api_url("masters/get/user");
        $responseRole = $this->somplakapi->run_curl_api($urlRole, []);
        $resApiRole = json_decode($responseRole);

        $urlDivisi = parent::build_api_url("masters/get/division");
        $responseDivisi = $this->somplakapi->run_curl_api($urlDivisi, []);
        $resApiDivisi = json_decode($responseDivisi);

        $usersRole = null;
        if ($resApiRole->result == 200)
            $usersRole = $resApiRole->data->item;

        $usersDivisi = null;
        if ($resApiDivisi->result == 200)
            $usersDivisi = $resApiDivisi->data->item;

        $totalPage = 0;
        if ($resApi->result == 200) {
            $totalPage = $resApi->data->totalPage;
        }

        $data["usersRole"] = $usersRole;
        $data["usersDivisi"] = $usersDivisi;
        $data["totalPage"] = $totalPage;
        $data["isMobile"] = $this->agent->is_mobile();

        $this->load->view("public/users_management", $data);
    }

    public function getDetail($username)
    {
        header('Content-Type: application/json');
        $url = parent::build_api_url('users/get/detail');
        $response = $this->somplakapi->run_curl_api($url, ["username" => $username]);
        $resApi = json_decode($response);

        if ($resApi->result == 200) {
            $profile = $resApi->data->item;
            $avatar = $profile->avatar;
            $avatarImg = @file_get_contents($avatar);
            if (!empty($profile->avatar)) {
                if ($avatarImg) {
                    $imageData = base64_encode($avatarImg);
                } else {
                    $avatar = IMAGE_DEFAULT_PATH . "no-avatar.png";
                    $imageData = base64_encode(@file_get_contents($avatar));
                }
            } else {
                $avatar = IMAGE_DEFAULT_PATH . "no-avatar.png";
                $imageData = base64_encode(@file_get_contents($avatar));
            }

            $resApi->data->item->avatar = "data: " . mime_content_type($avatar) . ";base64," . $imageData;
        }

        echo json_encode($resApi);
    }

    public function doUpdate()
    {
        header('Content-Type: application/json');
        $url = parent::build_api_url('users/update');
        $data["name"] = !is_null($this->input->post("user_name")) ? $this->input->post("user_name") : "";
        $data["divisi"] = !is_null($this->input->post("user_divisi")) ? intval($this->input->post("user_divisi")) : 0;
        $data["role"] = !is_null($this->input->post("user_role")) ? intval($this->input->post("user_role")) : 0;
        $data["old_username"] = !is_null($this->input->post("old_username")) ? $this->input->post("old_username") : "";
        $data["username"] = !is_null($this->input->post("username")) ? $this->input->post("username") : "";
        $data["handphone"] = !is_null($this->input->post("handphone")) ? $this->input->post("handphone") : "";

        if (isset($_FILES['user_avatar']['name']) && $_FILES['user_avatar']['name'] != "") {
            $avatarTmpPath = $_FILES['user_avatar']['tmp_name'];
            $avatar = file_get_contents($avatarTmpPath);
            $data["avatar"] = base64_encode($avatar);
        }

        $response = $this->somplakapi->run_curl_api($url, $data);
        $response = json_decode($response);

        echo json_encode($response);
    }

    public function doRemove()
    {
        header('Content-Type: application/json');
        $url = parent::build_api_url('users/remove');
        $data["username"] = !is_null($this->input->post("username")) ? $this->input->post("username") : "";

        $response = $this->somplakapi->run_curl_api($url, $data);
        $response = json_decode($response);

        echo json_encode($response);
    }
}
