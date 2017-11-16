<?php
namespace app\index\controller;

class Login extends Base
{
    public function _initialize()
    {
        $this->view->engine->layout(false);
    }

    public function index(){
        return $this->fetch('');
    }

    public function login(){
        $params = $this->valid([
            'name'=>'require',
            'pwd'=>'require',
            'code'=>'require|captcha'
        ]);
        $name = config('admin_name');
        $pwd = config('admin_pwd');
        if($params['name'] == $name && $params['pwd'] == $pwd){
            session('admin',1);
            $this->redirect('/');
        }else{
            $this->error('登录失败！');
        }
    }

    public function logout(){
        session('admin',null);
        $this->redirect('index/login/index');
    }

}
