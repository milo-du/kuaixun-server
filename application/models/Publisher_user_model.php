<?php

class Publisher_user_model extends CI_Model
{
    public function get_user($uid)
    {
        $sql = 'SELECT * FROM publisher_users WHERE userID=?';
        $query = $this->db->query($sql, array($uid));
        return $query->result();
    }

    public function get_user_list($limit = 0, $offset = 10)
    {
        $sql = "SELECT * FROM publisher_users limit $limit,$offset";
        $query = $this->db->query($sql, array($offset, $limit));
        return $query->result_array();
    }

    public function login($mobile, $pwd)
    {
        $sql = 'SELECT * FROM publisher_users WHERE phone=? and password=?';
        $query = $this->db->query($sql, array($mobile, $pwd));
        return $query->result();
    }

    public function register($phone, $pwd, $ip)
    {
        $sql = "INSERT INTO publisher_users (phone,password,regIP,lastLoginIP) VALUES(" . $this->db->escape($phone) . "," . $this->db->escape($pwd) . "," . $this->db->escape($ip) . "," . $this->db->escape($ip) . ")";
        return $this->db->simple_query($sql);
    }

    public function updateLoginTime($ip, $uid)
    {
        $sql = "UPDATE publisher_users SET lastLoginTime=?,lastLoginIP=? where userID=?";
        return $this->db->query($sql, array(time(), $ip, $uid));
    }
}