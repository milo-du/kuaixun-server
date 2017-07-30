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
}