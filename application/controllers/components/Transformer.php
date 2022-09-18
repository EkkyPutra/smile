<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transformer
{
    public static function convertMasterTypeToInt($strType)
    {
        $masterType = 0;
        switch ($strType) {
            case "user":
                $masterType = 1;
                break;
            case "project":
                $masterType = 2;
                break;
            case "division":
                $masterType = 3;
                break;
        }

        return $masterType;
    }

    public static function convertMasterTypeToString($intType)
    {
        $masterType = "Unknown";
        switch ($intType) {
            case 1:
                $masterType = "Users Role";
                break;
            case 2:
                $masterType = "Project Type";
                break;
            case 3:
                $masterType = "Users Division";
                break;
        }

        return $masterType;
    }
}