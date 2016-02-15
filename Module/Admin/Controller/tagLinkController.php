<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
// 关键词链接

namespace  Admin\Controller;

use Lib\Controller as Controller,Lib\Lib as Lib;

class tagLinkController extends controlController{

	const LINK_ERROR_MESSAGE		=	'请填写完整信息！';
	const LINK_SUCCESS_MESSAGE	=	'关键词替换成功！';
	const LINK_FAILURE_MESSAGE	=	'关键词替换失败！';
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
		$this->m = Lib::getinstance()->A('Admin\Model\tagLink',Null,'Model');
        $this->m_article = Lib::getinstance()->A('Admin\Model\article',Null,'Model');
    }

	/*
	关键词链接管理
	*/
	public function index(){
        $array['article_list'] = $this->m->getAll();
		$this->display('TagLink/index.html',$array);
	}

	/*
	关键词链接添加
	*/
	public function add(){
		$this->display('TagLink/add.html');
	}

	/*
	关键词链接编辑
	*/
	public function edit(){
		$this->display('TagLink/edit.html',[
			'link'		=> $this->m->getOne($_GET['id'])]);
	}

	/*
	关键词链接删除
	*/
	public function delete(){

		if($this->get(['id'])){
            $link = $this->m->getOne($_GET['id']);
			if($this->m->linkDel($this->get('id'))){
                $start_title = <<<str
<a href="{$link['link']}" target=_blank>{$link['name']}</a>
str;
                $this->m_article->repContent('content',$start_title,$link['name']);
                $this->r_log('删除关键词链接'.$link['name']);
				$this->message(NULL,app_url('/link/execution/re/1/message/'.self::DELETE_SUCCESS_MESSAGE));
			}else{
				$this->message(NULL,app_url('/link/execution/re/1/message/'.self::DELETE_FAILURE_MESSAGE));
			}
			
		}else{
			$this->message(NULL,app_url('/link/execution/re/1/message/'.self::DELETE_FAILURE_MESSAGE));
		}
	}

	/*
	保存关键词链接
	*/
	public function save(){
		if($this->post(['name','link'])){
            if($this->get('id')) $tag_link_arr = $this->m->getOne($this->get('id'));
			if($this->m->save($this->post(),$this->get('id'))){
                $title = <<<str
<a href="{$this->post('link')}" target=_blank>{$this->post('name')}</a>
str;
                if($this->get('id')){
                    $start_title = <<<str
<a href="{$tag_link_arr['link']}" target=_blank>{$tag_link_arr['name']}</a>
str;
                    $this->m_article->repContent('content',$start_title,$title);
                    $this->r_log('编辑关键词链接'.$this->post('name'));
                }else{
                    $this->m_article->repContent('content',$this->post('name'),$title);
                    $this->r_log('添加关键词链接'.$this->post('name'));
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
	执行结果
	*/
	public function execution(){
		include $this->display('TagLink/execution.html');
	}
}

?>