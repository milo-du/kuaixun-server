<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BaseController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    public $result = ['ret' => 0, 'msg' => 'ok'];

    public function jsonOutput($isExit = true)
    {
        $origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : '';

        $allow_origin = array(
            'http://a.m.com',
            'http://b.m.com',
            'http://c.m.com',
            'http://s.runningdreamer.com',
            'http://p.runningdreamer.com',
            'http://a.runningdreamer.com',
            'http://120.24.102.79:7777',
        );
        if(in_array($origin, $allow_origin)){
            $this->output->set_header('Access-Control-Allow-Origin:'.$origin);
        }
        $this->output->set_header('Access-Control-Allow-Credentials:true');
        $this->output->set_content_type('json')->set_output(json_encode($this->result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE))->_display();
        if ($isExit) {
            exit;
        }
    }

    //发布者是否已登录
    public function isPublisherLogin()
    {
        $userId = $this->input->get('uid');
        $token = $this->input->get('token');
        $publisherToken = md5($userId + $token);
        if (isset($_SESSION['publisherToken']) && $_SESSION['publisherToken'] == $publisherToken) {
            if ($_SESSION['publisherExpire'] + 86400 < time()) {
                $this->result['ret'] = 2000;
                $this->result['msg'] = '对不起，你的登录已失效，请先登录';
                $this->jsonOutput();
            }
        } else {
            $this->result['ret'] = 2001;
            $this->result['msg'] = '您未登录，请先登录';
            $this->jsonOutput();
        }
    }
    //后台管理员是否已经登录
    public function isAdminLogin()
    {
        $userId = $this->input->get('uid');
        $token = $this->input->get('token');
        $adminToken = md5($userId + $token);
        if (isset($_SESSION['adminToken']) && $_SESSION['adminToken'] == $adminToken) {
            if ($_SESSION['adminExpire'] + 86400 < time()) {
                $this->result['ret'] = 2000;
                $this->result['msg'] = '对不起，你的登录已失效，请先登录';
                $this->jsonOutput();
            }
        } else {
            $this->result['ret'] = 2001;
            $this->result['msg'] = '您未登录，请先登录';
            $this->jsonOutput();
        }
    }

    //刷手是否已经登录
    public function isBrusherLogin()
    {
        $userId = $this->input->get('uid');
        $token = $this->input->get('token');
        $brusherToken = md5($userId + $token);
        if (isset($_SESSION['brusherToken']) && $_SESSION['brusherToken'] == $brusherToken) {
            if ($_SESSION['bursherExpire'] + 86400 < time()) {
                $this->result['ret'] = 2000;
                $this->result['msg'] = '对不起，你的登录已失效，请先登录';
                $this->jsonOutput();
            }
        } else {
            $this->result['ret'] = 2001;
            $this->result['msg'] = '您未登录，请先登录';
            $this->jsonOutput();
        }
    }
    /**
     * 验证手机号是否正确
     * @author honfei
     * @param number $mobile
     */
    function isMobile($mobile)
    {
        if (!is_numeric($mobile)) {
            return false;
        }
        return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
    }

    /**
     * 验证是否是整数
     * @author honfei
     * @param number $mobile
     */
    function isInt($str)
    {
        return preg_match("/^\d*$/", $str);
    }
    /**
     * 验证是否是金额
     * @author honfei
     * @param number $mobile
     */
    function isMoney($str)
    {
        return preg_match("/^([1-9]\d{0,9}|0)([.]?|(\.\d{1,2})?)$/", $str);
    }
}
