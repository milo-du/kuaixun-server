<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends BaseController
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public
     * methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        //需要登录
        $this->isLogin();
        var_dump($this->router->fetch_directory());
        var_dump($this->router->fetch_class());
        var_dump($this->router->fetch_method());
        $aaa = $this->input->get('id');
        $arr = array('aa' => $aaa);
        $this->result = $arr;
        $this->jsonOutput();
    }

    public function login()
    {
        $userId = $this->input->get('userName');
        $passwd = $this->input->get('passwd');
        //查找用户表的的用户信息
        $dbPasswd = 'bfb7ca0181b66c21ea77edec46f2d7fa';
        $userName = 'test';
        echo md5('duming' . $passwd);
        if ($dbPasswd == md5('duming' . $passwd)) {
            $_SESSION['token'] = md5('duming' . $userId);
            $this->jsonOutput();
        } else {
            $this->result['ret'] = 2002;
            $this->result['msg'] = '用户名或者密码不正确';
            $this->jsonOutput();
        }
    }
}
