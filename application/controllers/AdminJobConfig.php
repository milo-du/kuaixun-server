<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminJobConfig extends BaseController
{
    function __construct()
    {
        parent::__construct();
    }

    function getAdminJobConfig()
    {
        $this->isAdminLogin();
        $this->load->model('Admin_job_config_model');
        $result = $this->Admin_job_config_model->getAdminJobConfig();
        $this->result['data'] = $result;
        $this->jsonOutput();
    }
    public function getAdminJobList()
    {
        $this->isAdminLogin();
        $offset = $this->input->get('offset');
        $limit = $this->input->get('limit');
        $offset = $offset ? $offset : 0;
        $limit = $limit ? $limit : 10;
        $this->load->model('Admin_job_config_model');
        $result = $this->Admin_job_config_model->getAdminJobList($offset, $limit);
        $this->result['data'] = $result;
        $this->jsonOutput();
    }
    function setAdminJobConfig()
    {
        $this->isAdminLogin();
        $this->load->model('Admin_job_config_model');
        $uid = $this->input->get('uid');
        $publisherPrice = $this->input->post('publisherPrice');
        $brusherPrice = $this->input->post('brusherPrice');
        if (strlen($publisherPrice) == 0) {
            $result = array('ret' => -1, 'msg' => '发布者价钱不能为空');
            $this->result = $result;
            $this->jsonOutput();
            return;
        }
        if (strlen($brusherPrice) == 0) {
            $result = array('ret' => -1, 'msg' => '刷手价钱不能为空');
            $this->result = $result;
            $this->jsonOutput();
            return;
        }
        $data = $this->Admin_job_config_model->setAdminJobConfig($publisherPrice, $brusherPrice, $uid);
        if ($data) {
            $result = array('ret' => 0, 'msg' => '设置成功');
            $this->result = $result;
            $this->jsonOutput();
        } else {
            $result = array('ret' => -1, 'msg' => '设置失败，请稍候重试');
            $this->result = $result;
            $this->jsonOutput();
        }
    }
}