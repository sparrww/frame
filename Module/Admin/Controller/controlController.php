<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio
 *******************************************************************/
// 控制器

namespace Admin\Controller;

use Lib\Controller as Controller, Lib\Lib as Lib;
use Lib\Exceptions;
use Lib\Model;

class controlController extends Controller
{
    /**
     * 验证登录
     */
    public function __construct()
    {

        session_start();
        if ($_SESSION['manage'] == "") {
            $this->message('',app_url('/login/index'));
        }
        if($_SESSION['power_id']){
            //获取控制器，方法
            if($this->get()) {

                $info = $this->get();
                $control = explode('\\', $info['controller']);
                $control = substr($control[2], 0, -10);
                $op = $info['operate'] ? $info['operate'] : 'index';

                $control_arr = array('home','temporary');
                $op_arr = array('execution');

                if(!in_array($control,$control_arr)){
                    if(!in_array($op,$op_arr)){
                        if(!$this->judge_power($control,$op)){
                            echo "<script>window.history.go(-1)</script>";exit;
                        }
                    }
                }
            }
        }
    }

    public function index(){
        $this->message('',app_url('/login/index'));
    }

    /**
     * 获取用户权限信息
     */

    public function power_class(){
        $m_power = Lib::getinstance()->A('Admin\Model\power', Null, 'Model');
        $arr_power =  $m_power->getOne($_SESSION['power_id']);
        return explode(',',$arr_power['class_id']);
    }

    /**
     * 清除静态html缓存
     * 目前支持一级目录
     * $file_name  文件名
     * $column_path  目录名
     */
    public function rdHtml($file_name,$column_path)
    {
        if(!C('HTML')) return;
        $p=DIRECTORY_SEPARATOR;
        if(strpos($column_path,$p)) $this->message('目前目录支持一级');
        if($file_name){
            if(!$column_path) $this->message('请传入目录');
            unlink(ROOT_PATH.$p.$column_path.$p.$file_name);
            $this->rdHtml('',$column_path);
        }else if($column_path){
            $page_arr = glob(ROOT_PATH.$p.$column_path.$p.'page*');
            foreach($page_arr as $v){
                unlink($v);
            }
            unlink(ROOT_PATH.$p.$column_path.$p.'index.html');
            unlink(ROOT_PATH.$p.'index.html');
        }else{
            $m_columns = Lib::getinstance()->A('Admin\Model\columns',Null,'Model');
            //$colums_arr = array_column($m_columns->getAllColumns('module'),'module');
            $colums_arr = $m_columns->getAllColumns('module');
            foreach($colums_arr as $v){
                $colums_arr_module[] = $v['module'];
            }
            $config_arr = ['Config','Module','Public','System','Upload'];
            $result = array_intersect($colums_arr_module,$config_arr);
            if($result)  echo '<script type="text/javascript">alert("栏目包含系统文件名");history.go(-1);</script>';
            foreach($colums_arr_module as $v){
                if($v!='zt' && $v!='zhuanti'){
                    rmdirs(ROOT_PATH.$p.$v.$p);
                }
            }
            $this->rdHtml('','zt');
            echo '<script type="text/javascript">alert("清除成功");history.go(-1);</script>';
        }
    }

    /**
     * 判断用户权限
     */

    public function judge_power($act,$op){
        if($_SESSION['power_id']){
            $m_power_class = Lib::getinstance()->A('Admin\Model\powerClass', Null, 'Model');
            $arr_power_one1 = $m_power_class->getOneByField($act,'construct');
            $arr_power_one2 = $m_power_class->getOneByField($act,$op);
            $arr_class_id = $this->power_class();
            if(!in_array($arr_power_one1['id'],$arr_class_id)){
                if(!in_array($arr_power_one2['id'],$arr_class_id)){
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        }else{
            return true;
        }

    }

    /**
     * 记录日志
     */
    public function r_log($message = '')
    {
        $model = Lib::getinstance()->A('Admin\Model\log', Null, 'Model');
        //存入数据库
        $info = $this->get();
        $control = explode('\\', $info['controller']);
        $control = substr($control[2], 0, -10);
        $op = $info['operate']?$info['operate']:'index';
        // $message = $message;
        $datetime = time();
        $user = $_SESSION['manage'];
        $insert_array = array('message' => $message, 'datetime' => $datetime, 'controller' => $control, 'operate' => $op,'user'=>$user);
        $data = $model->save($insert_array);
        if (!$data) die('日志存储失败');

        //写入日志文件
        $file_path = ITEM_PATH . '/Data/log';
        $file_name = date('Ymd', time());
        if (!file_exists($file_path)) {
            mkdirs($file_path);
        }
        $control_path = $info['controller'] . '\\' . $info['operate'];
        $log_content = $user . ' ' . $message;
        $content = '时间：' . date('Y-m-d H:i:s', time()) . "\r\n" . '路径：' . $control_path . "\r\n" . '内容：' . $log_content . "\r\n";
        $open = fopen("$file_path/$file_name.txt", "a");
        fwrite($open, $content);
        fclose($open);
    }


}

?>