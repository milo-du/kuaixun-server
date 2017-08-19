<?php

class Admin_user_model extends CI_Model
{
    public function getUserByUserID($uid)
    {
        $sql = 'SELECT * FROM admin_users WHERE userID=?';
        $query = $this->db->query($sql, array($uid));
        return $query->result();
    }

    public function getUserByMobile($phone)
    {
        $sql = 'SELECT * FROM admin_users WHERE phone=?';
        $query = $this->db->query($sql, array($phone));
        return $query->result();
    }

    public function getAdminUserList($offset = 0, $limit = 10)
    {
        $sql = "SELECT * FROM admin_users limit $offset,$limit";
        $query = $this->db->query($sql, array($offset, $limit));
        $total = $this->db->count_all('admin_users');
        $result = $query->result_array();
        return ['total' => $total, 'data' => $result];
    }

    public function getPublisherUserList($offset = 0, $limit = 10)
    {
        $sql = "SELECT * FROM publisher_users limit $offset,$limit";
        $query = $this->db->query($sql, array($offset, $limit));
        $total = $this->db->count_all('publisher_users');
        $result = $query->result_array();
        return ['total' => $total, 'data' => $result];
    }

    public function getBrusherUserList($offset = 0, $limit = 10)
    {
        $sql = "SELECT * FROM brusher_users limit $offset,$limit";
        $query = $this->db->query($sql, array($offset, $limit));
        $total = $this->db->count_all('brusher_users');
        $result = $query->result_array();
        return ['total' => $total, 'data' => $result];
    }

    public function login($mobile, $pwd)
    {
        $sql = 'SELECT * FROM admin_users WHERE phone=? and password=?';
        $query = $this->db->query($sql, array($mobile, $pwd));
        return $query->result();
    }

    public function register($phone, $pwd, $ip)
    {
        $sql = "INSERT INTO admin_users (phone,password,regIP,lastLoginIP) VALUES(" . $this->db->escape($phone) . "," . $this->db->escape($pwd) . "," . $this->db->escape($ip) . "," . $this->db->escape($ip) . ")";
        return $this->db->simple_query($sql);
    }

    public function updateLoginTime($ip, $uid)
    {
        $sql = "UPDATE admin_users SET lastLoginTime=?,lastLoginIP=? where userID=?";
        return $this->db->query($sql, array(date('Y-m-d H:i:s', time()), $ip, $uid));
    }
    public function rechargePublisher($publisherUid,$money){
        $sql = "UPDATE admin_users SET lastLoginTime=?,lastLoginIP=? where userID=?";
        return $this->db->query($sql, array(date('Y-m-d H:i:s', time()), $ip, $uid));
    }
}