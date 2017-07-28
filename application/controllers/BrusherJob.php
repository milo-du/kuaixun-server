<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BrusherJob extends BaseController
{
    function __construct()
    {
        parent::__construct();
    }

    function getList()
    {
        $this->isBrusherLogin();
        $this->load->model('brusher_job_model');
        $offset = $this->input->get('offset');
        $limit = $this->input->get('limit');
        $uid = $this->input->get('uid');
        $offset = $offset ? $offset : 0;
        $limit = $limit ? $limit : 10;
        $result = $this->brusher_job_model->getJobList($uid, $offset, $limit);
        $this->result['data'] = $result;
        $this->jsonOutput();
    }

    function getReciveList()
    {
        $this->isBrusherLogin();
        $this->load->model('brusher_job_model');
        $offset = $this->input->get('offset');
        $uid = $this->input->get('uid');
        $limit = $this->input->get('limit');
        $offset = $offset ? $offset : 0;
        $limit = $limit ? $limit : 10;
        $result = $this->brusher_job_model->getReciveJobList($uid, $offset, $limit);
        $this->result['data'] = $result;
        $this->jsonOutput();
    }

    function recive()
    {
        $this->isBrusherLogin();
        $uid = $this->input->get('uid');
        $this->load->model('brusher_job_model');
        $jobID = $this->input->post('jobID');
        $this->result = $this->brusher_job_model->recive($jobID, $uid);
        $this->jsonOutput();
    }
}