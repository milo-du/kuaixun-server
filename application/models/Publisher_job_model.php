<?php

class Publisher_job_model extends CI_Model
{
    public function getJobList($uid, $offset = 0, $limit = 10)
    {
        $this->db->where('publisherID', $uid);
        $total = $this->db->count_all_results('jobs', FALSE);
        $limit=(int)$limit;
        $offset=(int)$offset;
        $sql = 'select *,(select count(*) from brusher_job a where a.jobID=jobs.id) as totalBrushers from jobs where publisherID=? LIMIT ?,?';
        $query = $this->db->query($sql, array($uid, $offset, $limit));
        $data = $query->result_array();
        return ['total' => $total, 'data' => $data];
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