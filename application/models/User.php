<?php

class User extends CI_Model
{

    /**
     * Constructor model
     */
    public function __construct()
    {
        $this->load->database();
    }

    public function addUser($data)
    {
        $result = null;
        $resId = 0;
        $resMessage = "";

        $this->db->insert("tbl_users", $data);
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

    public function addUserAccess($data)
    {
        $result = null;
        $resId = 0;
        $resMessage = "";

        $this->db->insert("tbl_user_access", $data);
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

    public function getUserByEmail($email)
    {
        $this->db->select("*");
        $this->db->from("tbl_users");
        $this->db->where("email", $email);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->row();
        }

        return null;
    }

    public function getUserAccessByEmail($email)
    {
        $this->db->select('*');
        $this->db->from('tbl_user_access');
        $this->db->where("email", $email);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->row();
        }
        return null;
    }

    public function getUserAccessByUsername($username)
    {
        $this->db->select("a.password, b.*");
        $this->db->from("tbl_user_access as a");
        $this->db->join("tbl_users as b", "b.email=a.email");
        $this->db->where("LOWER(b.username)", $username);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->row();
        }
        return null;
    }

    // update row
    public function updateUserAccess($data)
    {
        $this->db->where('email', $data['email']);
        $this->db->update('tbl_user_access', $data);
        return true;
    }

    public function totalUsers($role = -1)
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_users");
        if ($role > 0)
            $this->db->where("role", $role);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            $row = $query->row();
            return $row->total;
        }

        return 0;
    }

    public function getUsers($role = -1, $offset = 0, $limit = 0)
    {
        $this->db->select("a.*, b.value as user_role, c.value as user_divisi");
        $this->db->from("tbl_users as a");
        $this->db->join("tbl_master as b", "b.id=a.role");
        $this->db->join("tbl_master as c", "c.id=a.divisi");
        if ($role > 0)
            $this->db->where("a.role", $role);

        if ($limit > 0)
            $this->db->limit($limit, $offset);

        $this->db->order_by("a.name", "asc");

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }

}