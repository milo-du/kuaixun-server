<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BrusherUser extends BaseController
{
    function __construct()
    {
        parent::__construct();
    }

    function getUser()
    {
        $this->isBrusherLogin();
        $uid = $this->input->get('uid');
        $this->load->model('brusher_user_model');
        $data = $this->brusher_user_model->getUserByUserID($uid);
        if (count($data) == 0) {
            $result = array('ret' => -1, 'msg' => '该用户不存在');
            $this->result = $result;
        } else {
            $this->result['data'] = $data[0];
        }
        $this->jsonOutput();
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
        if (!$this->isMobile($mobile)) {
            $result = array('ret' => -1, 'msg' => '手机号格式不正确');
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
        $this->load->model('brusher_user_model');
        $data = $this->brusher_user_model->login($mobile, $pwd);
        if (count($data) == 0) {
            $result = array('ret' => -1, 'msg' => '手机号不存在或者密码错误');
            $this->result = $result;
            $this->jsonOutput();
        } else {
            $userInfo = $data[0];
            $userID = $userInfo->userID;
            $ip = $this->input->ip_address();
            //更新登录时间和IP
            $this->brusher_user_model->updateLoginTime($ip, $userID);
            $token = md5($userID + time());
            $tokenInfo = ['uid' => $userID, 'token' => $token];
            $result = array('ret' => 0, 'data' => $tokenInfo);
            $publisherToken = md5($userID + $token);
            $_SESSION['brusherToken'] = $publisherToken;
            $_SESSION['bursherExpire'] = time();
            $this->result = $result;
            $this->jsonOutput();
        }
    }

    function getUserList()
    {
        $this->isBrusherLogin();
        $offset = $this->input->get('offset');
        $limit = $this->input->get('limit');
        $offset = $offset ? $offset : 0;
        $limit = $limit ? $limit : 10;
        $this->load->model('brusher_user_model');
        $data = $this->brusher_user_model->getUserList($offset, $limit);
        $this->result['data'] = $data['data'];
        $this->result['total'] = $data['total'];
        $this->jsonOutput();
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
        if (!$this->isMobile($mobile)) {
            $result = array('ret' => -1, 'msg' => '手机号格式不正确');
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
        $this->load->model('brusher_user_model');
        $existsUserInfo = $this->brusher_user_model->getUserByMobile($mobile);
        if (count($existsUserInfo) > 0) {
            $result = array('ret' => -1, 'msg' => '该手机号已经存在');
            $this->result = $result;
            $this->jsonOutput();
        } else {
            $data = $this->brusher_user_model->register($mobile, $pwd, $ip);
            if ($data) {
                $result = array('ret' => 0, 'msg' => '注册成功');
                $this->result = $result;
                $this->jsonOutput();
            } else {
                $result = array('ret' => -1, 'msg' => '注册失败，请稍候重试');
                $this->result = $result;
                $this->jsonOutput();
            }
        }
    }
}