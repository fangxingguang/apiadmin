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

    public function search(){
        $keywords = input('key');
        if(empty($keywords)){
            $this->redirect('/');
        }
        $where['content'] = ['like',"%$keywords%"];
        $list = Api::all($where);
        foreach ($list as $key => $val) {
            $list[$key]['title'] = str_ireplace($keywords, '<span style="color:red;">' . $keywords . '</span>', $val['title']);
            $content = trim(strip_tags(htmlspecialchars_decode($val['content'])));
            $start = 0;
            $position = mb_stripos($content, $keywords);
            if ($position !== false) {
                $start = $position;
                if ($position > 50) {
                    $start = $position - 50;
                }
            }
            $content = mb_substr($content, $start, 500, 'UTF-8');
            $content = str_ireplace($keywords, '<span style="color:red;">' . $keywords . '</span>', $content);
            $list[$key]['content'] = $content;
        }
        return $this->fetch('search',['list'=>$list]);
    }


}
