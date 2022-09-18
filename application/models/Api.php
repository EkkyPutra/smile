<?php

class Api extends CI_Model
{

    /**
     * Constructor model
     */
    public function __construct()
    {
        $this->load->database();
    }

    public function checkAccessLog($ip, $date)
    {
        $this->db->select("*");
        $this->db->from("tbl_log_access");
        $this->db->where("ip", $ip);
        $this->db->where("created", $date);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if (!is_null($query)) {
            return $query->row();
        }

        return null;
    }

    public function accessCount()
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_log_access");

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->row();
        }

        return null;
    }

    public function addAccessLog($data)
    {
        $this->db->insert("tbl_log_access", $data);
    }
}