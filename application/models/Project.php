<?php

class Project extends CI_Model
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
        $this->db->insert("tbl_project", $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }

        return 0;
    }

    public function addPic($data)
    {
        $this->db->insert("tbl_project_pic", $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }

        return 0;
    }

    public function totalProjects($params = null)
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_project");
        if (!is_null($params))
            $this->db->where($params);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            $row = $query->row();
            return $row->total;
        }

        return 0;
    }

    public function getProjects($params, $offset = 0, $limit = 0)
    {
        $this->db->select("a.*, b.value as project_divisi, b.background as project_divisi_bg, b.color as project_divisi_color, c.value as project_type");
        $this->db->from("tbl_project as a");
        $this->db->join("tbl_master as b", "b.id=a.divisi");
        $this->db->join("tbl_master as c", "c.id=a.type");
        
        if (!is_null($params))
            $this->db->where($params);

        if ($limit > 0)
            $this->db->limit($limit, $offset);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }

    public function getProjectMembers($projectId)
    {
        $this->db->select("a.id, (case when a.type=0 then 'pic_member' else 'pic_leader' end) as pic_type, b.name as pic_name, b.handphone as pic_handphone, b.avatar as pic_avatar, c.value as pic_role, d.value as pic_divisi");
        $this->db->from("tbl_project_pic as a");
        $this->db->join("tbl_users as b", "b.id=a.user_id");
        $this->db->join("tbl_master as c", "c.id=b.role");
        $this->db->join("tbl_master as d", "d.id=b.divisi");
        $this->db->where("a.project_id", $projectId);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }
}