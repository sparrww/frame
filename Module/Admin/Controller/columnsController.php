<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
// 栏目

namespace  Admin\Controller;

use Lib\Controller as Controller,Lib\Lib as Lib;

class columnsController extends controlController{

	const COLUMNS_ERROR_MESSAGE		=	'请填写完整信息！';
	const COLUMNS_SUCCESS_MESSAGE	=	'保存成功！';
	const COLUMNS_FAILURE_MESSAGE	=	'保存失败！';
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
		$this->m = Lib::getinstance()->A('Admin\Model\columns',Null,'Model');
    }

	/*
	栏目管理
	*/
	public function index(){
        $array['article_list'] = $this->m->getAll($this->get('classid'));
		$this->display('Columns/index.html',$array);
	}

	/*
	栏目添加
	*/
	public function add(){
		include $this->display('Columns/add.html',[
			'classSelect'	=> $this->m->columnsOption($this->get('classid'))
			]);
	}

	/*
	栏目编辑
	*/
	public function edit(){
		include $this->display('Columns/edit.html',[
			'columns'		=> $this->m->getOne($_GET['id']),
			'classSelect'	=> $this->m->columnsOption($this->get('classid'))
			]);
	}

	/*
	栏目删除
	*/
	public function delete(){

		if($this->get(['id'])){
			
			if($this->m->delete($this->get('id'))){
                $columns = $this->m->getOne($_GET['id']);
                $this->r_log('删除栏目'.$columns['name']);
				$this->message(NULL,app_url('/columns/execution/re/1/message/'.self::DELETE_SUCCESS_MESSAGE));
			}else{
				$this->message(NULL,app_url('/columns/execution/re/1/message/'.self::DELETE_FAILURE_MESSAGE));
			}
			
		}else{
			$this->message(NULL,app_url('/columns/execution/re/1/message/'.self::DELETE_FAILURE_MESSAGE));
		}
	}

	/*
	保存栏目
	*/
	public function save(){
		if($this->post(['name','module'])){

			if($this->m->save($this->post(),$this->get('id'))){
                if($this->get('id')){
                    $this->rdHtml('',$this->post('module'));
                    $this->r_log('编辑栏目'.$this->post('name'));
                }else{
                    $this->r_log('添加栏目'.$this->post('name'));
                }
				$data = [
					'status' 	=>	'y',
					'message'	=>	self::COLUMNS_SUCCESS_MESSAGE
				];
			}else{
				$data = [
					'status' 	=>	'n',
					'message'	=>	self::COLUMNS_FAILURE_MESSAGE
				];
			}
		}else{
			$data = [
				'status' 	=>	'c',
				'message'	=>	self::COLUMNS_ERROR_MESSAGE
			];
		}

		echo json_encode($data);
	}

	/*
	排序栏目
	*/
	public function sort(){

			if($this->m->sort($_POST['sort'])){
                $this->r_log('栏目排序');
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

    /**
     * ajaxTitle
     * @return array
     */
    public function ajaxTitle(){
        $value = $this->post('param');
        $key = $this->post('name');
        $data = $this->m->ajaxTitle($key,$value);
        if($data){
            $output = ['status'=>'n','info'=>'模块名重复！'];
        }else{
            $output = ['status'=>'y','info'=>'模块名验证通过!'];
        }

        echo json_encode($output);exit;
    }

	/*
	转移
	*/
	public function shift(){
		include $this->display('Columns/shift.html',[
			'classSelect'	=> $this->m->columnsOption($this->get('classid'),true)
			]);
	}

    /**
     * 更新栏目classid
     */
    public function gxClasssId(){
        $this->m->gxClasssId();exit;
    }

	/*
	执行结果
	*/
	public function execution(){
		$this->display('Columns/execution.html');
	}
}

?>