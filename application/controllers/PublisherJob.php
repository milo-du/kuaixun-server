<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublisherJob extends BaseController
{
    function __construct()
    {
        parent::__construct();
    }

    function getList()
    {
        $this->isPublisherLogin();
        $this->load->model('Publisher_job_model');
        $uid = $this->input->get('uid');
        $offset = $this->input->get('offset');
        $limit = $this->input->get('limit');
        $offset = $offset ? $offset : 0;
        $limit = $limit ? $limit : 10;
        $result = $this->Publisher_job_model->getJobList($uid, $offset, $limit);
        $this->result['data'] = $result;
        $this->jsonOutput();
    }
    function publish()
    {
        $this->isPublisherLogin();
        $uid = $this->input->get('uid');
        $this->load->model('Admin_job_config_model');
        $this->load->model('Publisher_user_model');
        $configData = $this->Admin_job_config_model->getAdminJobConfig();
        $userInfo = $this->Publisher_user_model->getUserByUserID($uid);
        $userAmount = $userInfo[0]->amount;
        $publisherPrice = $configData[0]->publisherPrice;
        $link = $this->input->post('link');
        $title = $this->input->post('title');
        $initReadCount = $this->input->post('initReadCount');
        $endReadCount = $this->input->post('endReadCount');
        if (strlen($link) == 0) {
            $result = array('ret' => -1, 'msg' => '链接不能为空');
            $this->result = $result;
            $this->jsonOutput();
            return;
        }
        if (strlen($title) == 0) {
            $result = array('ret' => -1, 'msg' => '标题不能为空');
            $this->result = $result;
            $this->jsonOutput();
            return;
        }
        if (strlen($initReadCount) == 0) {
            $result = array('ret' => -1, 'msg' => '初始阅读量不能为空');
            $this->result = $result;
            $this->jsonOutput();
            return;
        }
        if (!$this->isInt($initReadCount)) {
            $result = array('ret' => -1, 'msg' => '初始阅读量只能为整数');
            $this->result = $result;
            $this->jsonOutput();
            return;
        }
        if (strlen($endReadCount) == 0) {
            $result = array('ret' => -1, 'msg' => '任务阅读量不能为空');
            $this->result = $result;
            $this->jsonOutput();
            return;
        }
        if (!$this->isInt($endReadCount)) {
            $result = array('ret' => -1, 'msg' => '任务阅读量只能为整数');
            $this->result = $result;
            $this->jsonOutput();
            return;
        }
        $publisherTotalPrice = $publisherPrice * $endReadCount;
        if ($userAmount < $publisherTotalPrice) {
            $result = ['ret' => 2002, 'msg' => '您的账户余额不足，请先充值'];
            $this->result = $result;
            $this->jsonOutput();
            return;
        }
        $this->load->model('Publisher_job_model');
        $result = $this->Publisher_job_model->publish($publisherTotalPrice, $uid, $link, $title, $initReadCount, $endReadCount, $publisherPrice);
        if ($result['res'] == 0) {
            //添加流水记录
            $newJobID = $result['id'];
            $this->load->model('Publisher_flow_model');
            $this->Publisher_flow_model->save(0, $newJobID, $uid, $publisherTotalPrice, '发布任务扣除');
            $this->jsonOutput();
        } else {
            $result = ['ret' => -1, 'msg' => '提交失败，请稍候重试'];
            $this->result = $result;
            $this->jsonOutput();
        }
    }
}