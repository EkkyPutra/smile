<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
include_once(APPPATH . "controllers/base/constant.php");

class API_Controller extends CI_Controller
{
    public $jsonInputStr;
    public $jsonHeader;
    public $jsonInputObj;
    public $urlRouter = null;

    public $apiIO = null;
    public $responseObj = NULL;
    public $responseErrorObj = NULL;
    public $responseSuccessObj = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array(
            'myutils'
        ));
        $this->load->model(array(
            'api'
        ));

        header('Content-Type: application/json');
        $this->jsonInputStr = file_get_contents('php://input');
        $this->jsonInputStr = json_encode(json_decode($this->jsonInputStr));
        $this->jsonInputObj = (object) json_decode(trim($this->jsonInputStr));
        $this->urlRouter = $this->router->fetch_class() . "/" . $this->router->fetch_method();
    }

    protected function sendResponse($responseCode = 200, $responsMessage, $responseData = null)
    {
        $response = array(
            "result" => $responseCode,
            "message" => $responsMessage ?: 'Success',
            "data" => $responseData
        );

        if (!$this->responseErrorObj) {
            $response = array_merge($response, [
                "data" => $this->responseObj
            ]);
            $this->responseSuccessObj = $response;
        }

        echo json_encode($response);
        return;
    }

    protected function sendResponseError(&$responsMessage, $responseCode = 500)
    {
        $this->responseObj = NULL;
        $this->responseErrorObj = [
            "result" => $responsMessage->getCode() == 0 ? $responseCode : $responsMessage->getCode(),
            "message" => $responsMessage->getMessage()
        ];
        $this->sendResponse($responsMessage->getCode() == 0 ? $responseCode : $responsMessage->getCode(), $responsMessage->getMessage());
    }

    protected function checkValidation()
    {
        $words = array(
            "<?php",
            "<script",
            "<noscript"
        );
        $found = false;
        foreach ($words as $word) {
            $offset = strpos($this->jsonInputStr, $word);
            if ($offset !== false) {
                $this->sendResponse(422, "Unprocessable Entity!");
                die;
            }
        }
    }

    protected function writeLogInput($folderName = null, $logFileName = NULL)
    {
        if (!$folderName) {
            $folderName = $this->router->fetch_class();
        }
        if (!$logFileName) {
            $logFileName = $this->router->fetch_method();
        }

        $this->apiIO = "========= INPUT JSON =========\r\n";
        $this->apiIO .= $this->jsonInputStr . "\r\n";
        $this->myutils->writeApiLogs($folderName, $logFileName, $this->apiIO);
    }

    protected function writeLogOutput($folderName = null, $logFileName = NULL)
    {
        if (!$folderName) {
            $folderName = $this->router->fetch_class();
        }
        if (!$logFileName) {
            $logFileName = $this->router->fetch_method();
        }

        $this->apiIO = "========= OUTPUT =========\r\n";
        $this->apiIO .= json_encode($this->responseSuccessObj ?: $this->responseErrorObj) . "\r\n";
        $this->myutils->writeApiLogs($folderName, $logFileName, $this->apiIO);
    }
}