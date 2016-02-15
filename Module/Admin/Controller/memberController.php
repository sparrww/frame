<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
// 会员管理

namespace  Admin\Controller;

use Lib\Controller as Controller,Lib\Lib as Lib;

class memberController extends controlController{

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
		$this->m = Lib::getinstance()->A('Admin\Model\member',Null,'Model');
    }

	/*
	会员管理管理
	*/
	public function index(){
        $data = $this->m->getAll();
        $array['article_list'] = $data['list'];
        $array['fy'] = $data['fy'];
		$this->display('Member/index.html',$array);
	}


	/*
	会员管理编辑
	*/
	public function edit(){
		$this->display('Member/edit.html',[
			'member'		=> $this->m->getOne($_GET['id'])]);
	}

	/*
	会员管理删除
	*/
	public function delete(){

		if($this->get(['id'])){
			
			if($this->m->memberDel($this->get('id'))){
                $member = $this->m->getOne($_GET['id']);
                $this->r_log('删除会员'.$member['member_truename']);
				$this->message(NULL,app_url('/member/execution/re/1/message/'.self::DELETE_SUCCESS_MESSAGE));
			}else{
				$this->message(NULL,app_url('/member/execution/re/1/message/'.self::DELETE_FAILURE_MESSAGE));
			}
			
		}else{
			$this->message(NULL,app_url('/member/execution/re/1/message/'.self::DELETE_FAILURE_MESSAGE));
		}
	}

	/*
	保存会员管理
	*/
	public function save(){
		if($this->post()){
			if($this->m->save($this->post(),$this->get('id'))){
                if($this->get('id')){
                    $this->r_log('编辑会员管理'.$this->post('name'));
                }else{
                    $this->r_log('添加会员管理'.$this->post('name'));
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


    /**
     * ajax 返回
     * @return html
     */
    public function ajaxReturn(){
        $id = $this->get('id');
        $data = $this->m->getOne($id);
        die($this->display('Member/ajax.html',$data));
    }
	/*
	执行结果
	*/
	public function execution(){
		$this->display('Member/execution.html');
	}
}

?>