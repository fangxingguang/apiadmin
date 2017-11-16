<?php
use think\Route;

Route::any('search', 'index/index/search');
Route::any('show/:id', 'index/index/index');

return [
//    '/show/:id'=>'index/index/index'
];
