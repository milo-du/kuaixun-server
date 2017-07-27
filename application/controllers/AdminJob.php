<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminJob extends BaseController
{
    function __construct()
    {
        parent::__construct();
    }
    function getPublisherJobList()
    {
        $this->isAdminLogin();
        $this->load->model('admin_job_model');
        $offset = $this->input->get('offset');
        $limit = $this->input->get('limit');
        $offset = $offset ? $offset : 0;
        $limit = $limit ? $limit : 10;
        $result = $this->admin_job_model->getPublisherJobList($offset, $limit);
        $this->result['data'] = $result;
        $this->jsonOutput();
    }

    function getBrusherJobList(){
        $this->isAdminLogin();
        $this->load->model('admin_job_model');
        $offset = $this->input->get('offset');
        $limit = $this->input->get('limit');
        $offset = $offset ? $offset : 0;
        $limit = $limit ? $limit : 10;
        $result = $this->admin_job_model->getBrusherJobList($offset, $limit);
        $this->result['data'] = $result;
        $this->jsonOutput();
    }
}