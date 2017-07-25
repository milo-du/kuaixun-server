<?php

class Admin_job_model extends CI_Model
{
    public function getJobList($offset = 0, $limit = 10)
    {
        $total = $this->db->count_all_results('jobs', FALSE);
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $data = $query->result_array();
        return ['total' => $total, 'data' => $data];
    }
}