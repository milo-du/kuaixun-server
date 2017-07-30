<?php

class Admin_publisher_model extends CI_Model
{
    public function rechargePublisher($uid,$money)
    {
        $sql = "UPDATE publisher_users SET amount=amount+? where userID=?";
        return $this->db->query($sql, array($money,$uid));
    }
}