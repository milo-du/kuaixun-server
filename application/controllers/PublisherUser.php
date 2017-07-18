<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublisherUser extends BaseController
{
    function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        $mobile = $this->input->post('mobile');
        $pwd = $this->input->post('pwd');
        if (strlen($mobile) == 0) {
            $result = array('ret' => -1, 'msg' => '手机号不能为空');
            $this->result = $result;
            $this->jsonOutput();
            return;
        }
        if (strlen($pwd) == 0) {
            $result = array('ret' => -1, 'msg' => '密码不能为空');
            $this->result = $result;
            $this->jsonOutput();
            return;
        }
        $this->load->model('publisher_user_model');
        $data = $this->publisher_user_model->login($mobile, $pwd);
        if (count($data) == 0) {
            $result = array('ret' => -1, 'msg' => '手机号不存在或者密码错误');
            $this->result = $result;
            $this->jsonOutput();
        } else {
            $result = array('ret' => 0, 'data' => $data);
            $this->result = $result;
            $this->jsonOutput();
        }
    }

    public function get_user_list()
    {
        $offset = $this->input->get('offset');
        $limit = $this->input->get('limit');
        $this->load->model('publisher_user_model');
        $data = $this->publisher_user_model->get_user_list($offset, $limit);
    }

    public function register()
    {
        $mobile = $this->input->post('mobile');
        $pwd = $this->input->post('pwd');
        $ip = $this->input->ip_address();
        if (strlen($mobile) == 0) {
            $result = array('ret' => -1, 'msg' => '手机号不能为空');
            $this->result = $result;
            $this->jsonOutput();
            return;
        }
        if (strlen($pwd) == 0) {
            $result = array('ret' => -1, 'msg' => '密码不能为空');
            $this->result = $result;
            $this->jsonOutput();
            return;
        }
        $this->load->model('publisher_user_model');
        $data = $this->publisher_user_model->register($mobile, $pwd, $ip);
        if ($data) {
            $result = array('ret' => 0, 'msg' => '注册成功',);
            $this->result = $result;
            $this->jsonOutput();
        } else {
            $result = array('ret' => -1, 'msg' => '注册失败，请稍候重试');
            $this->result = $result;
            $this->jsonOutput();
        }
    }
}
