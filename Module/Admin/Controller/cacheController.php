<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio
 *******************************************************************/
// 缓存基本信息

namespace Admin\Controller;

use Lib\Controller as Controller, Lib\Lib as Lib;

class cacheController extends controlController
{


    const WEB_ERROR_MESSAGE = '请填写完整信息！';
    const WEB_SUCCESS_MESSAGE = '缓存信息保存成功！';
    const WEB_FAILURE_MESSAGE = '缓存信息保存失败！';

    public $m;

    /**
     * 重定义构造器
     *
     * @param string $message
     * @param int $code
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
    }

    /**
     * 清除静态html缓存
     * 目前支持一级目录
     */
    public function rdHtml($file_name,$column_path)
    {
        $p=DIRECTORY_SEPARATOR;
        if(strpos($column_path,$p)) $this->message('目前目录支持一级');
        if($file_name){
            if(!$column_path) $this->message('请传入目录');

        }else if($column_path){
            $page_arr = glob(ROOT_PATH.$p.$column_path.$p.'page*');
            var_dump($page_arr);exit;
        }else{

        }
    }


}

?>