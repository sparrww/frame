<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
// 权限

namespace  Admin\Controller;

use Lib\Controller as Controller,Lib\Lib as Lib;

class powerController extends controlController{

	const POWER_ERROR_MESSAGE		=	'请填写完整信息！';
	const POWER_SUCCESS_MESSAGE	    =	'保存成功！';
	const POWER_FAILURE_MESSAGE	    =	'保存失败！';
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
		$this->m = Lib::getinstance()->A('Admin\Model\power',Null,'Model');
        $this->m_power_class = Lib::getinstance()->A('Admin\Model\powerClass',Null,'Model');
    }

	/*
	权限管理
	*/
	public function index(){
		include $this->display('Power/index.html',
				['array' => $this->m->getAll()]
			);
	}

	/*
	权限添加
	*/
	public function add(){
        $array = $this->m_power_class->getAll();
		$this->display('Power/add.html',$array);
	}

	/*
	权限编辑
	*/
	public function edit(){
        $array['list'] = $this->m_power_class->getAll();
        $data = $this->m->getOne($this->get('id'));
        $data['class_id'] = explode(',',$data['class_id']);
        $array['article'] = $data;
		$this->display('Power/edit.html',$array);
	}

	/*
	权限删除
	*/
	public function delete(){

		if($this->get(['id'])){
            $data = $this->m->getOne($this->get('id'));
            $this->r_log('编辑权限'.$data['name']);
			if($this->m->delete($this->get('id'))){
				$this->message(NULL,app_url('/power/execution/re/1/message/'.self::DELETE_SUCCESS_MESSAGE));
			}else{
				$this->message(NULL,app_url('/power/execution/re/1/message/'.self::DELETE_FAILURE_MESSAGE));
			}
			
		}else{
			$this->message(NULL,app_url('/power/execution/re/1/message/'.self::DELETE_FAILURE_MESSAGE));
		}
	}

	/*
	保存权限
	*/
	public function save(){

		if($this->post(['name'])){

            $array['name'] = $this->post()['name'];
            $array['class_id'] = implode($this->post()['class_id'],',');

			if($this->m->save($array,$this->get('id'))){

                if($this->get('id')){
                    $this->r_log('编辑权限'.$this->post('name'));
                }else{
                    $this->r_log('添加权限'.$this->post('name'));
                }
				$data = [
					'status' 	=>	'y',
					'message'	=>	self::POWER_SUCCESS_MESSAGE
				];
			}else{
				$data = [
					'status' 	=>	'n',
					'message'	=>	self::POWER_FAILURE_MESSAGE
				];
			}
		}else{
			$data = [
				'status' 	=>	'c',
				'message'	=>	self::POWER_ERROR_MESSAGE
			];
		}

		echo json_encode($data);
	}



	/*
	执行结果
	*/
	public function execution(){
		$this->display('Power/execution.html');
	}
}

?>