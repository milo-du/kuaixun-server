<?php

class Publisher_job_model extends CI_Model
{
    public function getJobList($uid, $limit = 0, $offset = 10)
    {
        //$this->db->from('jobs');
        //$this->db->where('publisherID', $uid);
        //$this->db->limit($limit, $offset);
        $query = $this->db->get('jobs');
        $result =$query->result_array();
        $total=$this->db->count_all_results('jobs', FALSE);
        return ['total' => $total, 'data' => $result];
    }

    public function publish($jobTotalPrice, $uid, $link, $title, $initReadCount, $endReadCount, $price)
    {
        $this->db->trans_start();
        $sqlDeductions = 'update publisher_users set amount=amount-? where userID=?';
        $this->db->query($sqlDeductions, array($jobTotalPrice, $uid));
        $sqlPublish = 'insert into jobs(link,title,initReadCount,endReadCount,publisherID,price) values(?,?,?,?,?,?)';
        $this->db->query($sqlPublish, array($link, $title, $initReadCount, $endReadCount, $uid, $price));
        $newID = $this->db->insert_id();
        $this->db->trans_complete();
        $result = ['res' => -1];;
        if ($this->db->trans_status()) {
            $result = ['res' => 0, 'id' => $newID];
        }
        return $result;
    }
}