<?php
require_once 'constant.php';

class web_base extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function build_api_url($url)
    {
        return API_HOST . $url;
    }

    protected function getApiResData($response)
    {
        $data = json_decode($response);
        if ($data->result == 200) {
            if ($data->result == 200) {
                return json_encode($data);
            } else if ($data->result == 401) {
                return json_encode($data);
            } else {
                return json_encode($data);
            }
        } else {
            return json_encode(array("result" => 201, "message" => "Gagal! Lakukan beberapa saat lagi"));
        }
    }
}