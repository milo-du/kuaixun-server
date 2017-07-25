<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminJob extends BaseController
{
    function __construct()
    {
        parent::__construct();
    }
    function getList()
    {
        $this->isAdminLogin();
        $this->load->model('Admin_job_model');
        $offset = $this->input->get('offset');
        $limit = $this->input->get('limit');
        $offset = $offset ? $offset : 0;
        $limit = $limit ? $limit : 10;
        $result = $this->Publisher_job_model->getJobList($offset, $limit);
        $this->result['data'] = $result;
        $this->jsonOutput();
    }
}