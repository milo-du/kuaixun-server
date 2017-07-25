<?php

class Admin_job_config_model extends CI_Model
{
    public function getAdminJobConfig()
    {
        $sql = 'SELECT * FROM admin_job_config order by createTime limit 0,1';
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function setAdminJobConfig($publisherPrice,$bursherPrice){
        $sql = "INSERT INTO admin_job_config(publisherPrice,brusherPrice,regIP,lastLoginIP) VALUES(" . $this->db->escape($phone) . "," . $this->db->escape($pwd) . "," . $this->db->escape($ip) . "," . $this->db->escape($ip) . ")";
        return $this->db->simple_query($sql);
    }
}