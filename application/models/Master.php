<?php

class Master extends CI_Model
{

    /**
     * Constructor model
     */
    public function __construct()
    {
        $this->load->database();
    }

    public function addMaster($data)
    {
        $result = null;
        $resId = 0;
        $resMessage = "";

        $this->db->insert("tbl_master", $data);
        if ($this->db->affected_rows() > 0) {
            $resId = $this->db->insert_id();
        } else {
            $db_error = $this->db->error(); // Has keys 'code' and 'message'
            if (!empty($db_error) && isset($db_error['message'])) {
                $resMessage = $db_error['message'];
            }
        }

        $result = array(
            "result" => $resId,
            "message" => $resMessage
        );
        return (object) $result;
    }

    public function getMasterById($id)
    {
        $this->db->select("*");
        $this->db->from("tbl_master");
        $this->db->where("id", $id);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->row();
        }

        return null;
    }

    public function totalMasterByType($type)
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_master");
        $this->db->where("type", $type);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            $row = $query->row();
            return $row->total;
        }

        return 0;
    }

    public function getMasterByType($type, $offset = 0, $limit = 0)
    {
        $this->db->select("*");
        $this->db->from("tbl_master");
        $this->db->where("type", $type);

        if ($limit > 0)
            $this->db->limit($limit, $offset);

        $this->db->order_by("value", "asc");

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }

    public function getMasterByTypeValue($type, $value)
    {
        $this->db->select("*");
        $this->db->from("tbl_master");
        $this->db->where("type", $type);
        $this->db->where("value", strtolower($value));

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->row();
        }

        return null;
    }
}
