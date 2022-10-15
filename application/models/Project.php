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

    public function getProjectById($id)
    {
        $this->db->select("*");
        $this->db->from("tbl_project");
        $this->db->where("id", $id);
        $this->db->limit(1);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0)
            return $query->row();

        return null;
    }

    public function getProjectBySlug($slug)
    {
        $this->db->select("a.*, b.value as project_divisi, b.background as project_divisi_bg, b.color as project_divisi_color, c.value as project_type");
        $this->db->from("tbl_project as a");
        $this->db->join("tbl_master as b", "b.id=a.divisi");
        $this->db->join("tbl_master as c", "c.id=a.type");
        $this->db->where("a.slug", $slug);
        $this->db->limit(1);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->row();
        }

        return null;
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

    public function updateProject($data)
    {
        $this->db->where("id", $data["id"]);
        $this->db->update("tbl_project", $data);

        return $this->db->affected_rows();
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

    public function removeProject($id)
    {
        $this->db->delete('tbl_project', array(
            "id" => $id
        ));

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getProjectActivities($params, $lastProgress = false, $offset = 0, $limit = 0)
    {
        $this->db->select("a.*, b.name as project_name");
        $this->db->from("tbl_project_activities as a");
        $this->db->join("tbl_project as b", "b.id=a.project_id");
        $this->db->where("a.project_id", $params["project_id"]);
        $this->db->order_by("a.progress", "DESC");

        if ($limit > 0)
            $this->db->limit($limit, $offset);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0)
            if ($lastProgress)
                return $query->row();
            else
                return $query->result();

        return null;
    }

    public function saveActivity($data)
    {
        $this->db->insert("tbl_project_activities", $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }

        return 0;
    }

    public function totalProjectActivities($params = null)
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_project_activities");
        if (!is_null($params))
            $this->db->where($params);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            $row = $query->row();
            return $row->total;
        }

        return 0;
    }

    public function getLastProgressActivity($project_id)
    {
        $this->db->select("progress");
        $this->db->from("tbl_project_activities");
        $this->db->where("project_id", $project_id);
        $this->db->order_by("progress", "DESC");
        $this->db->limit(1);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0)
            return $query->row()->progress;

        return 0;
    }

    public function getProjectActivityById($id)
    {
        $this->db->select("*");
        $this->db->from("tbl_project_activities");
        $this->db->where("id", $id);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0)
            return $query->row();

        return null;
    }

    public function removeProjectActivity($id)
    {
        $this->db->delete('tbl_project_activities', array(
            "id" => $id
        ));

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateProjectActivity($data)
    {
        $this->db->where("id", $data["id"]);
        $this->db->update("tbl_project_activities", $data);

        return $this->db->affected_rows();
    }

    public function getCountProject($userId, $today, $type = "track", $isBau = false)
    {
        $this->db->select("count(b.id) as total");
        $this->db->from("tbl_project_pic as a");
        $this->db->join("tbl_project as b", "b.id=a.project_id");
        if ($isBau)
            $this->db->join("tbl_master as c", "c.id=b.type");

        $this->db->where("a.user_id", $userId);

        switch ($type) {
            case "track":
                $this->db->where("b.deadline >", $today);
                $this->db->where("b.progress < 100");
                break;
            case "complete":
                $this->db->where("b.progress = 100");
                break;
            case "late":
                $this->db->where("b.deadline <", $today);
                $this->db->where("b.progress < 100");
                break;
            case "all":
                break;
        }

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0)
            return $query->row()->total;

        return 0;
    }
}