<?php

class Publisher_flow_model extends CI_Model
{
    //保存发布者流水记录
    public function save($payID, $jobID, $userID, $money, $actionName)
    {
        $sql = "INSERT INTO publisher_flow (payID,jobID,userID,money,actionName) VALUES(?,?,?,?,?)";
        $this->db->query($sql, array($payID, $jobID, $userID, $money, $actionName));
    }
}