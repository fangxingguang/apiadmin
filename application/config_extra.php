<?php

use think\Env;

return [
    //自定义配置
    'exception_tmpl'         => APP_PATH . 'index/view/public/error.html',

    'admin_name' => Env::get('admin_name'),
    'admin_pwd' => Env::get('admin_pwd'),

];