<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once(APPPATH . "controllers/components/Transformer.php");

class Create
{
    protected $CI;
    protected $appSrc;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->helper(array());
        $this->CI->load->model(array());
        $this->CI->load->library(array(
            'form_validation'
        ));
    }

    public function action(&$responseObj, &$jsonInputObj, &$responsecode, &$responseMessage)
    {
        if (!isset($jsonInputObj->type) || !isset($jsonInputObj->value)) {
            throw new Exception("Data tidak lengkap. Silahkan cek kembali data anda!", 422);
        }

        $this->CI->form_validation->set_data((array) $jsonInputObj);

        $masterType = Transformer::convertMasterTypeToInt($jsonInputObj->type);
        $checkMasterExist = $this->CI->master->getMasterByTypeValue($masterType, $jsonInputObj->value);
        if (!is_null($checkMasterExist))
            throw new Exception("Master data telah terdaftar", 422);

        $dataMaster = [
            "type" => $masterType,
            "value" => $jsonInputObj->value
        ];
        $master = $this->CI->master->addMaster($dataMaster);
        if (!is_null($master) && $master->result > 0) {
            $dataMaster["type"] = ucwords($jsonInputObj->type);
            $dataMaster["value"] = ucwords($jsonInputObj->value);
            $responsecode = 200;
            $responseObj  = [
                "name"  => "Master Created",
                "item"  => $dataMaster
            ];
        }
    }
}
