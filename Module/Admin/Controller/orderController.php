<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
// 订单管理

namespace  Admin\Controller;

use Lib\Controller as Controller,Lib\Lib as Lib;

class orderController extends controlController{

	const LINK_ERROR_MESSAGE		=	'请填写完整信息！';
	const LINK_SUCCESS_MESSAGE	    =	'保存成功！';
	const LINK_FAILURE_MESSAGE	    =	'保存失败！';
	const DELETE_SUCCESS_MESSAGE	=	'删除成功！';
	const DELETE_FAILURE_MESSAGE	=	'删除失败！';
    const HOSPIYAL_SUCCESS_STATUS_1 =	'已到院';
    const HOSPIYAL_SUCCESS_STATUS_2 =	'未到院';
    const HOSPIYAL_FALSE_STATUS     =	'更改到院状态失败';

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
		$this->m = Lib::getinstance()->A('Admin\Model\order',Null,'Model');
    }

	/*
	订单管理管理
	*/
	public function index(){
        $data = $this->m->getAll();
        $array['article_list'] = $data['list'];
        $array['fy'] = $data['fy'];
		$this->display('Order/index.html',$array);
	}


	/*
	订单管理编辑
	*/
	public function edit(){
		$this->display('Order/edit.html',[
			'order'		=> $this->m->getOne($_GET['id'])]);
	}

	/*
	订单管理删除
	*/
	public function delete(){

		if($this->get(['id'])){
			
			if($this->m->orderDel($this->get('id'))){
                $order = $this->m->getOne($_GET['id']);
                $this->r_log('删除订单'.$order['order_sn']);
				$this->message(NULL,app_url('/order/execution/re/1/message/'.self::DELETE_SUCCESS_MESSAGE));
			}else{
				$this->message(NULL,app_url('/order/execution/re/1/message/'.self::DELETE_FAILURE_MESSAGE));
			}
			
		}else{
			$this->message(NULL,app_url('/order/execution/re/1/message/'.self::DELETE_FAILURE_MESSAGE));
		}
	}

	/*
	保存订单管理
	*/
	public function save(){
		if($this->post(['name','order'])){
			if($this->m->save($this->post(),$this->get('id'))){
                if($this->get('id')){
                    $this->r_log('编辑订单管理'.$this->post('name'));
                }else{
                    $this->r_log('添加订单管理'.$this->post('name'));
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
        die($this->display('Order/ajax.html',$data));
    }

    /**
     * ajax 到院状态返回
     * @return html
     */
    public function ajaxHospitalStatus()
    {
        if ($this->post()) {
            if($this->post('status')==0){
            $data = $this->m->editOneField('hospital_status', 1, $this->post('id'));
                if($data){
                    $output = ['status'=>'y1','info'=>self::HOSPIYAL_SUCCESS_STATUS_1];
                }else{
                    $output = ['status'=>'n','info'=>self::HOSPIYAL_FALSE_STATUS];
                }
            }else if($this->post('status')==1){
                $data = $this->m->editOneField('hospital_status',0,$this->post('id'));
                if($data){
                    $output = ['status'=>'y2','info'=>self::HOSPIYAL_SUCCESS_STATUS_2];
                }else{
                    $output = ['status'=>'n','info'=>self::HOSPIYAL_FALSE_STATUS];
                }
            }
        }else{
            $output = ['status'=>'n','info'=>self::HOSPIYAL_FALSE_STATUS];
        }
        echo json_encode($output);exit;
    }
	/*
	执行结果
	*/
	public function execution(){
		$this->display('Order/execution.html');
	}
}

?>