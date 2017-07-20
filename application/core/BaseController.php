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
}