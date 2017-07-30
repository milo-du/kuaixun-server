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
        $limit = (int)$limit;
        $offset = (int)$offset;
        $sql = 'select a.*,b.link,b.title,b.done,b.doneTime from brusher_job a left join jobs b on a.jobID=b.id order by a.id desc LIMIT ?,?';
        $query = $this->db->query($sql, array($offset, $limit));
        $data = $query->result_array();
        return ['total' => $total, 'data' => $data];
    }
    public function getBrusherApplyJobList($offset = 0, $limit = 10)
    {
        $this->db->where('statu', 0);
        $this->db->group_by("userID");
        $total = $this->db->count_all_results('brusher_apply_money', FALSE);
        $limit = (int)$limit;
        $offset = (int)$offset;
        $sql = 'select sum(money) as totalMoney,userID from brusher_apply_money where statu=0 group by userID LIMIT ?,?';
        $query = $this->db->query($sql, array($offset, $limit));
        $data = $query->result_array();
        return ['total' => $total, 'data' => $data];
    }

    public function sureApply($uid){
        $sql = "UPDATE brusher_apply_money SET statu=1 where userID=?";
        return $this->db->query($sql, array($uid));
    }
}