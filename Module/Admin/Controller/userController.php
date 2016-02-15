<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
// 用户基本信息

namespace  Admin\Controller;

use Lib\Controller as Controller,Lib\Lib as Lib;

class userController extends controlController{


	const WEB_ERROR_MESSAGE		=	'请填写完整信息！';
	const WEB_SUCCESS_MESSAGE	=	'信息保存成功！';
	const WEB_FAILURE_MESSAGE	=	'信息保存失败！';
    const PRAMETER_ERROR	    =	'参数错误！';
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
		$this->m = Lib::getinstance()->A('Admin\Model\user',Null,'Model');
        $this->m_power = Lib::getinstance()->A('Admin\Model\power',Null,'Model');
    }

	/*
	用户基本信息设置
	*/
	public function index(){
        $array['user_list'] = $this->m->getAll();
		include $this->display('User/index.html',$array);
	}


    /**
     * 添加用户
     * @access public
     * @return template,array
     */
    public function add(){
        $array['list'] = $this->m_power->getAll();
        return $this->display('User/add.html',$array);
    }

    /**
     * 修改密码
     * @access public
     * @return template,array
     */
    public function edit(){
        $array = $this->m->getOne($this->get('id'));
        $array['list'] = $this->m_power->getAll();
        return $this->display('User/edit.html',$array);
    }

    /**
     * 保存密码
     * @access public
     * @return json
     */
    public function save(){
        if($this->post('admin')) {
            if($this->get('id')){
                if($this->post('password')){
                    $array['password'] = md5($this->post('password'));
                }
                $array['admin'] = $this->post('admin');
                $array['power_id'] = $this->post('power_id');
                $array['status'] = $this->post('status');
                $data = $this->m->save($array,$this->get('id'));
            }else{
                $array['admin'] = $this->post('admin');
                $array['power_id'] = $this->post('power_id');
                $array['password'] = md5($this->post('password'));
                $array['status'] = $this->post('status');
                $data = $this->m->save($array);
            }
            if ($data){
                if ($this->get('id')) {
                    $this->r_log('修改' . $this->post('admin') . '信息');
                } else {
                    $this->r_log('新增用户' . $this->post('admin'));
                }
                echo json_encode(array('message' => self::WEB_SUCCESS_MESSAGE));
            }
            else
                echo json_encode(array('message' => self::WEB_FAILURE_MESSAGE));
        }else{
            echo json_encode(array('message' => self::WEB_ERROR_MESSAGE));
        }

    }


    /*
	用户删除
	*/
    public function delete(){

        if($this->get(['id'])){
            $array = $this->m->getOne($this->get('id'));
            $this->r_log('删除用户'.$array['admin']);
            if($this->m->delete($this->get('id'))){
                $this->message(NULL,app_url('/user/execution/re/1/message/'.self::DELETE_SUCCESS_MESSAGE));
            }else{
                $this->message(NULL,app_url('/user/execution/re/1/message/'.self::DELETE_FAILURE_MESSAGE));
            }

        }else{
            $this->message(NULL,app_url('/user/execution/re/1/message/'.self::DELETE_FAILURE_MESSAGE));
        }
    }

    /**
    执行结果
     */
    public function execution(){
        include $this->display('User/execution.html');exit;
    }

}

?>