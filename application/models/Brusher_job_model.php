<?php

class Brusher_job_model extends CI_Model
{
    public function getJobList($brusheruid,$offset = 0, $limit = 10)
    {
        $this->db->where('done', 0);
        $total = $this->db->count_all_results('jobs', FALSE);
        $limit = (int)$limit;
        $offset = (int)$offset;
        $sql = 'SELECT a.*,(SELECT COUNT(1) FROM brusher_job where brusherUserID=? and JobID=a.ID) as reciveStatu  FROM jobs a WHERE Done=0 LIMIT ?,?';
        $query = $this->db->query($sql, array($brusheruid,$offset, $limit));
        $data = $query->result_array();
        return ['total' => $total, 'data' => $data];
    }

    public function getReciveJobList($uid, $offset = 0, $limit = 10)
    {
        $this->db->where('brusherUserID', $uid);
        $total = $this->db->count_all_results('brusher_job', FALSE);
        $limit = (int)$limit;
        $offset = (int)$offset;
        $sql = 'select a.*,b.link,b.title from brusher_job a left join jobs b on a.jobID=b.id where a.brusherUserID=? LIMIT ?,?';
        $query = $this->db->query($sql, array($uid, $offset, $limit));
        $data = $query->result_array();
        return ['total' => $total, 'data' => $data];
    }

    public function recive($jobID, $uid)
    {
        $existsSql = 'SELECT * FROM brusher_job WHERE jobID=? and brusherUserID=?';
        $existsBrusher = $this->db->query($existsSql, array($jobID, $uid))->result();
        if (count($existsBrusher) > 0) {
            $result = ['ret' => '-1', 'msg' => '您已经领取过了'];
            return $result;
        }
        $sql = 'SELECT * FROM jobs WHERE id=?';
        $query = $this->db->query($sql, array($jobID));
        $jobData = $query->result();
        $result = ['ret' => '-1', 'msg' => '领取失败，任务不存在'];
        if (count($jobData) > 0) {
            $endReadCount = $jobData[0]->endReadCount;
            $price = $jobData[0]->price;
            $insertSql = "INSERT INTO brusher_job(jobID,price,brusherUserID,totalView,view) values(?,?,?,?,?)";
            $this->db->query($insertSql, array($jobID, $price, $uid, $endReadCount, 0));
            $result = ['ret' => '0', 'msg' => '领取成功'];
        }
        return $result;
    }
}