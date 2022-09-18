<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Filefunction
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->helper(array(
            'file',
            'form',
            'url',
            'url_helper'
        ));

        $this->CI->load->model(array(
        ));

        $this->CI->load->library(array(
            'image_lib'
        ));
    }

    protected function _generate_name($length = 5)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = time();
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    protected function _generate_thumb($source_path, $prefix)
    {
        $target_path = "./files/thumbs/";
        if (!empty($prefix)) $target_path .= $prefix . "/";
        if (!is_dir($target_path)) mkdir($target_path, 0777, true);

        $config_manip = array(
            'image_library' => 'gd2',
            'source_image' => $source_path,
            'new_image' => $target_path,
            'maintain_ratio' => TRUE,
            'thumb_marker' => '_thumb',
            'width' => 300,
            'height' => 300
        );

        $this->CI->image_lib->initialize($config_manip);
        $this->CI->image_lib->resize();
        $this->CI->image_lib->clear();
    }

    protected function _resize($file, $size)
    {
        chmod($file, 0777);

        $result = TRUE;
        $config['image_library'] = 'gd2';
        $config['source_image'] = $file;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $size;
        $config['height'] = $size;
        $this->CI->image_lib->initialize($config);
        if (!$this->CI->image_lib->resize()) {
            $result = FALSE;
        }
        $this->CI->image_lib->clear();

        return $result;
    }

    protected function _save_to_local($file, $prefix)
    {
        try {
            if ($this->CI->myutils->startsWith($file, "http://") || $this->CI->myutils->startsWith($file, "https://")) {
                $opts = array(
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                    ),
                );
                $handle = @fopen($file, 'rb', false, stream_context_create($opts));
                if (!$handle) {
                    return NULL;
                } else {
                    $type = pathinfo($file, PATHINFO_EXTENSION);
                    $data = file_get_contents($file, false, stream_context_create($opts));

                    if ($type == "pdf")
                    $file = 'data:application/' . $type . ';base64,' . base64_encode($data);
                    else
                        $file = 'data:image/' . $type . ';base64,' . base64_encode($data);
                }
            }

            $filename = $this->_generate_name();

            $base64 = explode(";base64,", $file);
            if ($base64 != null && count($base64) > 1) {
                $base64data = base64_decode($base64[1]);
            } else {
                $base64data = base64_decode($file);
            }

            if ($base64[0] == 'data:application/pdf') {
                if (strlen($prefix) > 4 && substr($prefix, -4) == ".pdf") $filename = $prefix;
                else $filename .= ".pdf";

                $location = "./files/pdf/";
                if (!is_dir($location)) mkdir($location, 0777, true);
                if (file_put_contents($location . $filename, $base64data)) return $filename;
            } else {
                $filename .= ".png";

                $location = "./files/images/";
                if (!empty($prefix)) $location .= $prefix . "/";
                if (!is_dir($location)) mkdir($location, 0777, true);

                $image = imageCreateFromString($base64data);
                imagepng($image, $location . $filename, 0);

                if (filesize($location . $filename) != 0) {
                    list($width, $height) = getimagesize($location . $filename);
                    if ($height > 1024 || $width > 1024) {
                        if (!$this->_resize($location . $filename, 1024)) {
                            unlink($location . $file);

                            return NULL;
                        }
                    }

                    $this->_generate_thumb($location . $filename, $prefix);

                    return $filename;
                }
                return NULL;
            }
        } catch (\Exception $e) {
        }

        return NULL;
    }

    public function saveImages($files, $prefix = "", $isArray = false)
    {
        $result = [];

        if (is_array($files)) {
            foreach ($files as $file) {
                $filename = $this->_save_to_local($file, $prefix);
                if ($filename != NULL) {
                    if ($isArray)
                        $result[] = $filename;
                    else
                        $result = $filename;
                }
            }
        } else {
            $filename = $this->_save_to_local($files, $prefix);
            if ($filename != NULL) {
                if ($isArray)
                    $result[] = $filename;
                else
                    $result = $filename;
            }
        }

        return $result;
    }
}