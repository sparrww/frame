<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
// 友情链接

namespace  Admin\Controller;

use Lib\Controller as Controller,Lib\Lib as Lib;

class linkController extends controlController{

	const LINK_ERROR_MESSAGE		=	'请填写完整信息！';
	const LINK_SUCCESS_MESSAGE	=	'保存成功！';
	const LINK_FAILURE_MESSAGE	=	'保存失败！';
	const SORT_SUCCESS_MESSAGE		=	'排序成功！';
	const SORT_FAILURE_MESSAGE		=	'排序失败！';
	const DELETE_SUCCESS_MESSAGE	=	'删除成功！';
	const DELETE_FAILURE_MESSAGE	=	'删除失败！';

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
		$this->m = Lib::getinstance()->A('Admin\Model\link',Null,'Model');
    }

	/*
	友情链接管理
	*/
	public function index(){
        $array['article_list'] = $this->m->getAll();
		include $this->display('Link/index.html',$array);
	}

	/*
	友情链接添加
	*/
	public function add(){
		include $this->display('Link/add.html');
	}

	/*
	友情链接编辑
	*/
	public function edit(){
		include $this->display('Link/edit.html',[
			'link'		=> $this->m->getOne($_GET['id'])]);
	}

	/*
	友情链接删除
	*/
	public function delete(){

		if($this->get(['id'])){
			
			if($this->m->linkDel($this->get('id'))){
                $link = $this->m->getOne($_GET['id']);
                $this->r_log('删除友情链接'.$link['name']);
				$this->message(NULL,app_url('/link/execution/re/1/message/'.self::DELETE_SUCCESS_MESSAGE));
			}else{
				$this->message(NULL,app_url('/link/execution/re/1/message/'.self::DELETE_FAILURE_MESSAGE));
			}
			
		}else{
			$this->message(NULL,app_url('/link/execution/re/1/message/'.self::DELETE_FAILURE_MESSAGE));
		}
	}

	/*
	保存友情链接
	*/
	public function save(){
		if($this->post(['name','link'])){
			if($this->m->save($this->post(),$this->get('id'))){
                if($this->get('id')){
                    $this->r_log('编辑友情链接'.$this->post('name'));
                }else{
                    $this->r_log('添加友情链接'.$this->post('name'));
                }
				$data = [
					'status' 	=>	'y',
					'message'	=>	self::LINK_SUCCESS_MESSAGE
				];
			}else{
				$data = [
					'status' 	=>	'n',
					'message'	=>	self::LINK_FAILURE_MESSAGE
				];
			}
		}else{
			$data = [
				'status' 	=>	'c',
				'message'	=>	self::LINK_ERROR_MESSAGE
			];
		}

		echo json_encode($data);
	}

	/*
	保存友情链接
	*/
	public function sort(){

			if($this->m->sort($_POST['sort'])){
                $this->r_log('友情链接排序'.$this->post('name'));
				$data = [
					'status' 	=>	'y',
					'message'	=>	self::SORT_SUCCESS_MESSAGE
				];
			}else{
				$data = [
					'status' 	=>	'n',
					'message'	=>	self::SORT_FAILURE_MESSAGE
				];
			}

		echo json_encode($data);
	}

	/*
	执行结果
	*/
	public function execution(){
		include $this->display('Link/execution.html');
	}
}

?>