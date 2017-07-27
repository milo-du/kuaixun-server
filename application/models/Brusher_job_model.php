<?php

class Brusher_job_model extends CI_Model
{
    public function getJobList($offset = 0, $limit = 10)
    {
        $this->db->where('done', 0);
        $total = $this->db->count_all_results('jobs', FALSE);
        $limit = (int)$limit;
        $offset = (int)$offset;
        $sql = 'select * from jobs where done=0 LIMIT ?,?';
        $query = $this->db->query($sql, array($offset, $limit));
        $data = $query->result_array();
        return ['total' => $total, 'data' => $data];
    }

    public function getReciveJobList($uid, $offset = 0, $limit = 10)
    {
        $this->db->where('brusherUserID', $uid);
        $total = $this->db->count_all_results('brusher_job', FALSE);
        $limit = (int)$limit;
        $offset = (int)$offset;
        $sql = 'select a.*,b.link,b.title from brusher_job a left join jobs b on a.jobID=b.id where a.brusherUserID==? LIMIT ?,?';
        $query = $this->db->query($sql, array($uid, $offset, $limit));
        $data = $query->result_array();
        return ['total' => $total, 'data' => $data];
    }

    public function recive($jobID, $uid)
    {
        $sql = 'SELECT * FROM jobs WHERE id=?';
        $query = $this->db->query($sql, array($jobID));
        $jobData = $query->result_array();
        if ($jobData->length > 0) {
            $endReadCount = $jobData->endReadCount;
            $price = $jobData->price;
            $insertSql = "INSERT INTO brusher_job(jobID,price,brusherUserID,totalView,view) values(?,?,?,?,?)";
            $this->db->query($insertSql, array($jobID, $price, $uid, $endReadCount, 0));
            $result = array('ret' => 0, 'msg' => '领取成功');
            return $result;
        } else {
            $result = array('ret' => -1, 'msg' => '任务不存在');
            return $result;
        }
    }
}