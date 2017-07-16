<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublisherUser extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        $mobile = $this->input->get('mobile');
        $pwd = $this->input->get('pwd');
        if (strlen($mobile) == 0) {
            $result = array('ret' => -1, 'msg' => '手机号不能为空');
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return;
        }
        if (strlen($pwd) == 0) {
            $result = array('ret' => -1, 'msg' => '密码不能为空');
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return;
        }
        $this->load->model('publisher_user_model');
        $data = $this->publisher_user_model->login($mobile, $pwd);
        if (count($data) == 0) {
            $result = array('ret' => -1, 'msg' => '手机号不存在或者密码错误');
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        } else {
            $result = array('ret' => 0, 'data' => $data);
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
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
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return;
        }
        if (strlen($pwd) == 0) {
            $result = array('ret' => -1, 'msg' => '密码不能为空');
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return;
        }
        $this->load->model('publisher_user_model');
        $data = $this->publisher_user_model->register($mobile, $pwd, $ip);
        if ($data) {
            $result = array('ret' => 0, 'msg' => '注册成功',);
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        } else {
            $result = array('ret' => -1, 'msg' => '注册失败，请稍候重试');
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }
}
