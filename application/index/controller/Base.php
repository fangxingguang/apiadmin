<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Base extends Controller
{
    public $admin = '';
    public $menu = '';
    public function _initialize()
    {
        $this->admin = session('admin');
        $this->assign('admin',$this->admin);
        $this->menu = $this->getMenu();
        $this->assign('menu',$this->menu);
    }

    //成功返回
    protected function suc($data='',$code=200){
        $this->result($data,$code,'success');
    }

    //失败返回
    protected function err($msg,$code=400){
         $this->result('',$code,$msg);
    }

    //参数验证
    protected function valid($rules){
        $data = [];
        foreach ($rules as $key => $rule) {
            $default = null;
            if (is_string($rule) && $rule) {
                $ruleArr = [];
                $rule = explode('|', $rule);
                foreach($rule as $item){
                    if (strpos($item, ':')) {
                        list($subType, $subRule) = explode(':', $item, 2);
                        $ruleArr[$subType] = $subRule;
                    }else{
                        $ruleArr[] = $item;
                    }
                }
                $rule = $ruleArr;
            }
            $rules[$key] = $rule;
            if(isset($rule['default'])){
                $default = $rule['default'];
                unset($rules[$key]['default']);
            }
            $data[$key] = input($key,$default);
            if(empty($rule)){
                unset($rules[$key]);
            }
        }
        $validate = new \app\index\service\Validate($rules);
        $result = $validate->check($data);
        if(!$result){
            $this->error($validate->getError());
        }
        return $data;
    }

    protected function getMenu(){
        $list = Db::table('api')->field(['id','title','pid'])->order('sort asc')->select();
        return $this->getTree($list,0);
    }

    protected function getTree($list,$pid){
        $temp=array();
        foreach($list as $k=>$v){
            if($v['pid']==$pid){
                $temp[$k]=$v;
                $temp[$k]['son']=$this->getTree($list,$v['id']);

            }
        }
        return $temp;
    }


}