<?php

class Admin_job_model extends CI_Model
{
    public function getPublisherJobList($offset = 0, $limit = 10)
    {
        $total = $this->db->count_all_results('jobs', FALSE);
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $data = $query->result_array();
        return ['total' => $total, 'data' => $data];
    }

    public function getBrusherJobList($offset = 0, $limit = 10)
    {
        $total = $this->db->count_all_results('brusher_job', FALSE);
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $data = $query->result_array();
        return ['total' => $total, 'data' => $data];
    }
}