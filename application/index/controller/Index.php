<?php
namespace app\index\controller;

use app\index\model\Api;

class Index extends Base
{

    public function index(){
        $default_id = $this->menu[0]['id'];
        $id = input('id',$default_id);
        $api = Api::get($id);
        return $this->fetch('index',['api'=>$api]);
    }




}
