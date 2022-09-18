<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/base/web_base.php';
date_default_timezone_set("Asia/Jakarta");

class Home extends web_base
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
        $urlAccess = parent::build_api_url('other/accessLog');
        $access = [
            "ip" => $this->input->ip_address(),
            "agent" => json_encode($this->agent)
        ];

        $this->somplakapi->run_curl_api($urlAccess, $access);

        $urlSlider = parent::build_api_url('slider/get');
        $resApiSlider = $this->somplakapi->run_curl_api($urlSlider, null);
        $resApiSlider = json_decode($resApiSlider);

        $urlNews = parent::build_api_url('news/lists');
        $paramsNews = [
            "inHome" => true,
            "isShow" => true
        ];
        $resApiNews = $this->somplakapi->run_curl_api($urlNews, $paramsNews);
        $resApiNews = json_decode($resApiNews);

        $urlProductCat = parent::build_api_url('product/category/lists');
        $paramsProductCat = [
            "inHome" => true  
        ];
        $resApiProductCat = $this->somplakapi->run_curl_api($urlProductCat, $paramsProductCat);
        $resApiProductCat = json_decode($resApiProductCat);

        $slider = null;
        if ($resApiSlider->result == 200) {
            $slider = $resApiSlider->data->data->item->items;
        }

        $news = null;
        if (!is_null($resApiNews->data) && $resApiNews->data->result == 200) {
            $data["newsHome"] = $resApiNews->data->data->item;
        } else {
            $data["newsHome"] = null;
        }

        $productCat = null;
        if ($resApiProductCat->result == 200) {
            $productCat = $resApiProductCat->data;
        }

        $data["slider"] = $slider;
        $data["productCat"] = $productCat;

        $this->load->view("public/home", $data);
    }
}
