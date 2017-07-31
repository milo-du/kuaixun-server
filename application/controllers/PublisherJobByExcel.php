<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublisherJobByExcel extends BaseController
{
    function __construct()
    {
        parent::__construct();
    }

    function publish()
    {
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $uid = $this->input->get('uid');
        $offset = $this->input->get('offset');
        $limit = $this->input->get('limit');
        $offset = $offset ? $offset : 0;
        $limit = $limit ? $limit : 10;
        $result = $this->Publisher_flow_model->getList($uid, $offset, $limit);
        $this->result['data'] = $result;
        $this->jsonOutput();
    }
}