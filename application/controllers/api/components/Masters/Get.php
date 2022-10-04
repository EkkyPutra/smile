<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once(APPPATH . "controllers/components/Transformer.php");

class Get
{
    protected $CI;
    protected $appSrc;

    public function __construct($type)
    {
        $this->CI = &get_instance();
        $this->CI->load->helper(array());
        $this->CI->load->model(array());
        $this->CI->load->library(array());

        $this->type = $type;
    }

    public function action(&$responseObj, &$jsonInputObj, &$responsecode, &$responseMessage)
    {
        if (empty($this->type))
            throw new Exception("Data tidak lengkap. Silahkan cek kembali data anda!", 422);

        $currPage = 1;
        $limit = 200;
        $totalPage = 1;
        $masters = null;
        $start = 0;

        if (isset($jsonInputObj->page) && $jsonInputObj->page > 0 && isset($jsonInputObj->limit) && $jsonInputObj->limit > 0) {
            $currPage = $jsonInputObj->page;
            $limit    = $jsonInputObj->limit;
            $start    = ($jsonInputObj->page - 1) * $limit;
        }

        $masterType = Transformer::convertMasterTypeToInt($this->type);
        $totalMasterType = $this->CI->master->totalMasterByType($masterType);

        if ($totalMasterType > 0) {
            $totalPage = ceil($totalMasterType / $limit);
            $getMasterType = $this->CI->master->getMasterByType($masterType, $start, $limit);
            foreach ($getMasterType as $master) {
                $masters[] = [
                    "id" => intval($master->id),
                    "value" => ucwords($master->value)
                ];
            }
        }

        $responsecode = 200;
        $responseObj  = [
            "name"  => "Master Lists of " . ucwords($this->type),
            "item"  => $masters,
            "currPage" => $currPage,
            "totalPage" => $totalPage,
            "limit" => $limit
        ];
    }
}
