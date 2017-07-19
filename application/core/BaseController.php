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

    public function isLogin()
    {
        $userId = $this->input->get('userId');
        $token = $this->input->get('token');

        if (isset($_SESSION['token']) && $_SESSION['token'] == $token) {
            if ($_SESSION['expire'] + 86400 < time()) {
                $this->result['ret'] = 2000;
                $this->result['msg'] = '对不起，你的登录已失效，请先登录 ';
                $this->jsonOutput();
            }
        } else {
            $this->result['ret'] = 2001;
            $this->result['msg'] = '您未登录，请先登录';
            $this->jsonOutput();
        }
    }
}
