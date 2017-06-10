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
            'pwd'=>'require'
        ]);
        if($params['name'] == 'admin' && $params['pwd'] == 'Aa123456'){
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
