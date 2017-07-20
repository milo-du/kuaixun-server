<?php

class Publisher_user_model extends CI_Model
{
    public function getUserByUserID($uid)
    {
        $sql = 'SELECT * FROM publisher_users WHERE userID=?';
        $query = $this->db->query($sql, array($uid));
        return $query->result();
    }

    public function getUserByMobile($phone)
    {
        $sql = 'SELECT * FROM publisher_users WHERE phone=?';
        $query = $this->db->query($sql, array($phone));
        return $query->result();
    }

    public function getUserList($limit = 0, $offset = 10)
    {
        $sql = "SELECT * FROM publisher_users limit $limit,$offset";
        $query = $this->db->query($sql, array($limit, $offset));
        $total = $this->db->count_all('publisher_users');
        $result = $query->result_array();
        return ['total' => $total, 'data' => $result];
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