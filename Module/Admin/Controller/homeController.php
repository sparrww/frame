<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
// 首页
//extends Controller

namespace  Admin\Controller;

use Lib\Lib as Lib;

class homeController extends controlController{

	public $m;

    /**
     * 重定义构造器
     *
     * @param string $message
     * @param int $code
     * @return void
     */
	public function __construct(){
        parent::__construct();
		$this->m = Lib::getinstance()->A('Admin\Model\home',Null,'Model');
    }

	public function index(){
        if($this->judge_power('base','construct')) $array['base'] = 1;
        if($this->judge_power('user','construct')) $array['user'] = 1;
        if($this->judge_power('log','construct')) $array['log'] = 1;
        if($this->judge_power('dbmanage','construct')) $array['dbmanage'] = 1;
        if($this->judge_power('columns','construct')) $array['columns'] = 1;
        if($this->judge_power('article','construct')) $array['article'] = 1;
        if($this->judge_power('power','construct')) $array['power'] = 1;
        if($this->judge_power('link','construct')) $array['link'] = 1;
        if($this->judge_power('order','construct')) $array['order'] = 1;
        if($this->judge_power('member','construct')) $array['member'] = 1;
        if($this->judge_power('tag_link','construct')) $array['tag_link'] = 1;
		$this->display('index.html',$array);
	}


	public function main(){
		$this->display('main.html');
	}

    /**
     * 退出登录
     * @access public
     * @return url
     */
    public function quit(){
        session_start();
        session_destroy();
        echo '<meta http-equiv="refresh" content="0;url=/Admin">';
    }

}

?>