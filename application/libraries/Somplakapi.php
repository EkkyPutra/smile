<?php

class Somplakapi
{
    private $data;

    public function __construct()
    {
        $this->data = &get_instance();
    }

    public function run_curl_api($url, $body)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        // read timeout
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

        $result = curl_exec($ch);
        // printf($result);die;
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $response = json_decode($result);
        if (json_last_error() === JSON_ERROR_NONE && $response != null && $response->result == 600) {
            redirect($response->data);
            die();
        }

        if ($response != null && isset($response->result)) {
            if ($response->result == 200) {
                return json_encode(array(
                    "result" => $httpcode,
                    "data" => json_decode($result)
                ));
            } else {
                return json_encode([
                    "result" => 201,
                    "message" => $response->message,
                    "data" => null
                ]);
            }
        } else {
            return json_encode(array(
                "result" => 200,
                "data" => array(
                    "result" => 201,
                    "message" => "Terjadi kesalahan! Silahkan ulangi beberapa saat lagi"
                )
            ));
        }
    }
}