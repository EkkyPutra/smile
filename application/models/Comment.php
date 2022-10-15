<?php

class Comment extends CI_Model
{

    /**
     * Constructor model
     */
    public function __construct()
    {
        $this->load->database();
    }

    public function addRow($data)
    {
        $this->db->insert("tbl_project_comment", $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }

        return 0;
    }

    public function getComments($projectId, $commet_id = 0)
    {
        $this->db->select("a.*, b.name as username, c.value as user_role, d.value as user_divisi");
        $this->db->from("tbl_project_comment as a");
        $this->db->join("tbl_users as b", "b.username=a.user");
        $this->db->join("tbl_master as c", "c.id=b.role");
        $this->db->join("tbl_master as d", "d.id=b.divisi");
        $this->db->where("a.project_id", $projectId);
        $this->db->where("a.comment_id", $commet_id);
        $this->db->order_by("a.created", "DESC");

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0)
            return $query->result();

        return null;
    }

    public function totalComments($projectId)
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_project_comment");
        $this->db->where("project_id", $projectId);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            $row = $query->row();
            return $row->total;
        }

        return 0;
    }
}