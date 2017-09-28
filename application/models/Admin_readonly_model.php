<?php

class Admin_readonly_model extends CI_Model
{
    public function setReadOnly($uid,$money,$Provider,$Count)
    {
        $sql = "UPDATE readonly SET money=?,count=?,provider=? where brusherUserID=?";
        return $this->db->query($sql, array($money,$Count,$Provider,$uid));
    }
}