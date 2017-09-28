<?php

class Admin_readonly_model extends CI_Model
{
    public function setReadOnly($uid,$money,$Provider,$Count)
    {
        $sql1 = "SELECT * FROM readonly where brusherUserID=?";
        $query = $this->db->query($sql1, array($uid));
        $data = $query->result_array();
        if(count($data)>0)
        {
            $sql2 = "UPDATE readonly SET money=?,count=?,provider=? where brusherUserID=?";
        }
        else{
            $sql2 = "insert readonly(money,count,provider,brusherUserID) values(?,?,?,?)";
        }
        return $this->db->query($sql2, array($money,$Count,$Provider,$uid));
    }
}