<?php

class Brusher_user_model extends CI_Model
{
    public function getUserByUserID($uid)
    {
        $sql = 'SELECT * FROM brusher_users WHERE userID=?';
        $query = $this->db->query($sql, array($uid));
        return $query->result();
    }

    public function getUserByMobile($phone)
    {
        $sql = 'SELECT * FROM brusher_users WHERE phone=?';
        $query = $this->db->query($sql, array($phone));
        return $query->result();
    }

    public function getUserList($offset = 0, $limit = 10)
    {
        $sql = "SELECT * FROM brusher_users limit $offset,$limit";
        $query = $this->db->query($sql, array($offset, $limit));
        $total = $this->db->count_all('publisher_users');
        $result = $query->result_array();
        return ['total' => $total, 'data' => $result];
    }

    public function login($mobile, $pwd)
    {
        $sql = 'SELECT * FROM brusher_users WHERE phone=? and password=?';
        $query = $this->db->query($sql, array($mobile, $pwd));
        return $query->result();
    }

    public function register($phone, $pwd, $ip)
    {
        $sql = "INSERT INTO brusher_users (phone,password,regIP,lastLoginIP) VALUES(" . $this->db->escape($phone) . "," . $this->db->escape($pwd) . "," . $this->db->escape($ip) . "," . $this->db->escape($ip) . ")";
        return $this->db->simple_query($sql);
    }

    public function updateLoginTime($ip, $uid)
    {
        $sql = "UPDATE brusher_users SET lastLoginTime=?,lastLoginIP=? where userID=?";
        return $this->db->query($sql, array(date('Y-m-d H:i:s', time()), $ip, $uid));
    }

    //设置刷手提现帐号(仅仅支持支付宝)
    public function setPayAcount($uid, $phone, $name)
    {
        $sql = "UPDATE brusher_users SET alipayPhone=?,alipayName=? where userID=?";
        return $this->db->query($sql, array($phone, $name, $uid));
    }

    //获取刷手提现帐号
    public function getPayAcount($uid)
    {
        $sql = 'SELECT alipayPhone,alipayName FROM brusher_users WHERE userID=?';
        $query = $this->db->query($sql, array($uid));
        return $query->result();
    }
    //提现申请
    public function applyMoney($uid,$money){
        $this->db->trans_start();
        $sqlDeductions = 'update brusher_users set amount=amount-? where userID=?';
        $this->db->query($sqlDeductions, array($money, $uid));
        $sqlBrusher = "INSERT INTO brusher_apply_money (userID,money) VALUES(?,?)";
        $this->db->query($sqlBrusher, array($uid,$money));
        $newID = $this->db->insert_id();
        $this->db->trans_complete();
        $result = ['res' => -1];;
        if ($this->db->trans_status()) {
            $result = ['res' => 0, 'id' => $newID];
        }
        else{
            $result = ['res' => -1, 'msg'=>'操作失败，请稍后重试'];
        }
        return $result;
    }
    //获取提现申请列表
    public function getApplyMoneyList($uid,$offset = 0, $limit = 10)
    {
        $this->db->where('userID', $uid);
        $total = $this->db->count_all_results('brusher_apply_money', FALSE);
        $limit = (int)$limit;
        $offset = (int)$offset;
        $sql = 'SELECT * FROM brusher_apply_money where userID=? order by id desc limit ?,?';
        $query = $this->db->query($sql, array($uid,$offset, $limit));
        $data = $query->result_array();
        return ['total' => $total, 'data' => $data];
    }

    //获取提现申请列表
    public function getExistsApplyMoneyList($uid)
    {
        $this->db->where('userID', $uid);
        $this->db->where('statu', 0);
        $total = $this->db->count_all_results('brusher_apply_money', FALSE);
        return $total;
    }
}