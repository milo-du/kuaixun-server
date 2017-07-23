<?php

class Publisher_flow_model extends CI_Model
{
    //保存发布者流水记录
    public function save($payID, $jobID, $userID, $money, $actionName)
    {
        $sql = "INSERT INTO publisher_flow (payID,jobID,userID,money,actionName) VALUES(?,?,?,?,?)";
        $this->db->query($sql, array($payID, $jobID, $userID, $money, $actionName));
    }
    public function getList($uid, $offset = 0, $limit = 10)
    {
        $this->db->where('userID', $uid);
        $total = $this->db->count_all_results('publisher_flow', FALSE);
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $data = $query->result_array();
        return ['total' => $total, 'data' => $data];
    }
}