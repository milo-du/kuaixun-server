<?php

class Admin_job_config_model extends CI_Model
{
    public function getAdminJobConfig()
    {
        $sql = 'SELECT * FROM admin_job_config order by createTime limit 0,1';
        $query = $this->db->query($sql);
        return $query->result();
    }
}