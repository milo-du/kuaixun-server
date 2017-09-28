<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminPublisher extends BaseController
{
    function __construct()
    {
        parent::__construct();
    }
    function rechargePublisher(){
        $this->isAdminLogin();
        $this->load->model('admin_publisher_model');
        $money = $this->input->post('money');
        if (strlen($money) == 0) {
            $result = array('ret' => -1, 'msg' => '充值金额不能为空');
            $this->result = $result;
            $this->jsonOutput();
            return;
        }
        $uid = $this->input->get('uid');
        $result = $this->admin_publisher_model->rechargePublisher($uid, $money);
        $this->jsonOutput();
    }
    function setReadOnly(){
        $this->isAdminLogin();
        $this->load->model('admin_readonly_model');
        $money = $this->input->post('money');
        $count = $this->input->post('count');
        $provider = $this->input->post('provider');
        $brusherUserID = $this->input->post('brusherUserID');
        if (strlen($money) == 0) {
            $result = array('ret' => -1, 'msg' => '金额不能为空');
            $this->result = $result;
            $this->jsonOutput();
            return;
        }
        if (strlen($count) == 0) {
            $result = array('ret' => -1, 'msg' => '总数不能为空');
            $this->result = $result;
            $this->jsonOutput();
            return;
        }
        if (strlen($provider) == 0) {
            $result = array('ret' => -1, 'msg' => '提供者不能为空');
            $this->result = $result;
            $this->jsonOutput();
            return;
        }
        if (strlen($brusherUserID) == 0) {
            $result = array('ret' => -1, 'msg' => '用户ID不能为空');
            $this->result = $result;
            $this->jsonOutput();
            return;
        }
        $result = $this->admin_readonly_model->setReadOnly($brusherUserID,$money,$provider,$count);
        $this->jsonOutput();
    }
}