<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
// 网站基本信息

namespace  Admin\Controller;

use Lib\Controller as Controller,Lib\Lib as Lib;

class articleController extends controlController{


	const ARTICLE_ERROR_MESSAGE		=	'请填写完整信息！';
	const ARTICLE_ATTRIBS_MESSAGE	=	'操作成功！';
	const ARTICLE_ATTRIBC_MESSAGE	=	'操作失败！';
	const ARTICLE_MOVES_MESSAGE		=	'转移成功！';
	const ARTICLE_MOVEC_MESSAGE		=	'转移失败！';
	const ARTICLE_SUCCESS_MESSAGE	=	'文章保存成功！';
	const ARTICLE_FAILURE_MESSAGE	=	'文章保存失败！';
	const ARTICLE_DELETES_MESSAGE	=	'文章删除成功！';
	const ARTICLE_DELETEC_MESSAGE	=	'文章删除失败！';
	const ARTICLE_SYSTEM_MESSAGE	=	'参数异常！';

	public $m = [];

    /**
     * 重定义构造器
     *
     * @param string $message
     * @param int $code
     * @return void
     */
	public function __construct(){
        parent::__construct();
		$this->m['article'] = Lib::getinstance()->A('Admin\Model\article',Null,'Model');
		$this->m['columns'] = Lib::getinstance()->A('Admin\Model\columns',Null,'Model');
    }


	/**
	 * 文章首页
	 * @return array
	 */
	public function index(){

		$classid = $this->get('classid')?$this->m['columns']->columnsIsdonw($this->get('classid')):0;

		$levelid = arrayToString($this->m['columns']->getLevelId($this->get('classid')));

        if($this->get('classid')){
            if($levelid){
                $num_id = $this->get('classid').','.$levelid;
            }else{
                $num_id = $this->get('classid');
            }
        }else{
            $num_id =  $levelid;
        }

		$data['columns'] = $this->m['columns']->getAll($classid);

        if($num_id){
            if($this->judge_power('article','aprrove') && $_SESSION['power_id']){
                $data['article'] = $this->m['article']->ShgetPage($num_id,$this->get('field'),$this->get('title'),20);
            }else{
                $data['article'] = $this->m['article']->getPage($num_id,$this->get('field'),$this->get('title'),20);
            }
        }
        foreach($data['article']['list'] as $k=>$v){
            $template = $this->m['columns']->getOne($v['columnsid'],'template');
            if(!$v['html']){
                $url = $template.$v['id'].'.shtml';
            }else{
                $url = $v['html'];
            }
            $v['url'] = $url;
            $data['article']['list'][$k] = $v;
        }
        $array['article_list']['columns'] = $data['columns'];
        $array['article_list']['article'] = $data['article'];
        $array['fy']	  = $data['article']['fy'];

        foreach($array['article_list']['columns'] as $k=>$v){
            if($this->m['columns']->getAll($v['id']))
                $array['article_list']['columns'][$k]['pid'] = 1;
            else
                $array['article_list']['columns'][$k]['pid'] = 0;
        }

        $this->display('Article/index.html',$array);

	}

	/**
	 * 文章添加
	 * @return array
	 */
	public function add(){
        $data['classSelect'] = $this->m['columns']->columnsOption($this->get('classid'),true);
		$this->display('Article/add.html',$data);
	}

    /**
     * 文章编辑
     * @return array
     */
	public function edit(){
		$data['article']		=	$this->m['article']->getOne($_GET['id']);

		$data['classSelect']	=	$this->m['columns']->columnsOption($data['article']['columnsid'],true);

		$this->display('Article/edit.html',$data);
	}

	/**
	 * 删除文章
	 * @return json
	 */
	public function delete(){

		if($this->get(['id'])){

			if($this->m['article']->delete($this->get('id'))){

                $article = $this->m['article']->getOne($_GET['id']);

                $this->rdHtml($this->get('id').'.shtml',$article['module']);

                $this->r_log('删除文章'.$article['name']);
				
				$this->message(NULL,app_url('/article/execution/re/1/message/'.self::ARTICLE_DELETES_MESSAGE));
			
			}else{

				$this->message(NULL,app_url('/article/execution/re/1/message/'.self::ARTICLE_DELETEC_MESSAGE));

			}
		}else{
			
			$this->message(NULL,app_url('/article/execution/re/1/message/'.self::ARTICLE_SYSTEM_MESSAGE));

		}

	}

	/**
	 * 保存文章
	 * @return json
	 */
	public function save(){

		if($this->post(['title'])){

			if($this->m['article']->save($this->post(),$this->get('id'))){
                $article = $this->m['article']->getOne($this->get('id'));
                if($this->get('id')){
                    $this->rdHtml($this->get('id').'.shtml',$article['module']);
                    $this->r_log('编辑文章　'.$this->post('title'));
                }else{
                    $this->rdHtml('',$article['module']);
                    $this->r_log('添加文章　'.$this->post('title'));
                }
				
				$data = [
					'status' 	=>	'y',
					'message'	=>	self::ARTICLE_SUCCESS_MESSAGE
				];
			}else{
				$data = [
					'status' 	=>	'n',
					'message'	=>	self::ARTICLE_FAILURE_MESSAGE
				];
			}
		}else{
			$data = [
				'status' 	=>	'c',
				'message'	=>	self::ARTICLE_ERROR_MESSAGE
			];
		}

		echo json_encode($data);
	}

	/**
	 * 批量操作
	 * @return json
	 */
	public function batch(){

		if($this->$_POST['method']($_POST['record'],$this->post('parameter'))){

				$data = [
					'status' 	=>	'y',
					'message'	=>	self::ARTICLE_ATTRIBS_MESSAGE
				];

		}else{

				$data = [
					'status' 	=>	'n',
					'message'	=>	self::ARTICLE_ATTRIBC_MESSAGE
				];
		}
		echo json_encode($data);
	}


    /**
     * 审核
     * @return json
     */
    public function aprrove($array = [],$attrib='status'){

        if($this->get('id')){
            $id = $this->get('id');
            $data = $this->m['article']->getOne($id);
            if($data['status'] == 1){
                if(!$this->m['article']->aprrove($attrib,$id,'0')){
                    echo "<script>alert('审核失败');history.go(-1)</script>";
                }
            }
            if($data['status'] == 0){
                if(!$this->m['article']->aprrove($attrib,$id,'1'))
                    echo "<script>alert('审核失败');history.go(-1)</script>";
            }
            if($data['status'] == 2){
                if(!$this->m['article']->aprrove($attrib,$id,'1'))
                    echo "<script>alert('审核失败');history.go(-1)</script>";
            }
            $article = $this->m['article']->getOne($_GET['id']);
            $this->r_log('审核文章'.$article['name']);
            echo "<script>alert('审核成功');history.go(-1)</script>";
        }
        else if(is_array($array)){

            foreach ($array as $k => $v) {
                $data = $this->m['article']->getOne($v);
                if($data['status'] == 1){
                    if(!$this->m['article']->aprrove($attrib,$v,'0')) return false;
                }
                if($data['status'] == 0){
                    if(!$this->m['article']->aprrove($attrib,$v,'1')) return false;
                }
                if($data['status'] == 2){
                    if(!$this->m['article']->aprrove($attrib,$v,'1')) return false;
                }
            }
            $this->r_log('批量审核文章');
            return true;
        }
        else{

            return false;
        }
    }

	/**
	 * 属性批量操作
	 * @return json
	 */
	public function batchDel($array = []){

		if(is_array($array)){

            $this->r_log('批量删除文章');

			foreach ($array as $k => $v) {
				if(!$this->m['article']->delete($v)) return false;
			}

			return true;
		}else{

			return false;
		}
	}

	/**
	 * 属性批量操作
	 * @return json
	 */
	public function attrib($array = [],$attrib){

		if(is_array($array)){

            $this->r_log('批量设置文章属性');

			foreach ($array as $k => $v) {
				if(!$this->m['article']->attrib($attrib,$v,'1')) return false;
			}

			return true;
		}else{

			return false;
		}
	}

	/**
	 * 属性批量操作
	 * @return json
	 */
	public function attribc($array = [],$attrib){

		if(is_array($array)){

            $this->r_log('批量取消文章属性');

			foreach ($array as $k => $v) {
				if(!$this->m['article']->attrib($attrib,$v,'0')) return false;
			}

			return true;
		}else{

			return false;
		}
	}

	/*
	转移
	*/
	public function move(){

		if($this->post(['columnsid','data'])){

			if($this->m['article']->move(array_filter(explode(',',$this->post('data'))),$this->post('columnsid'))){

				$this->message(NULL,app_url('/article/execution/re/1/message/'.self::ARTICLE_MOVES_MESSAGE));
				
			}else{

				$this->message(NULL,app_url('/article/execution/re/1/message/'.self::ARTICLE_MOVEC_MESSAGE));
			}
		}else{
			$this->message(NULL,app_url('/article/execution/re/1/message/'.self::ARTICLE_MOVEC_MESSAGE));
		}
	}


    /**
     * ajax 返回
     * @return html
     */
    public function ajaxReturn(){
        $id = $this->get('id');
        $data = $this->m['article']->getOne($id);
        $array['article'] = $data;

        //include ITEM_PATH.'/Common/jindu.php';
        $this->display('Article/ajax.html',$array);
    }


    /**
     * ajax更新
     * @return str
     */
    public function ajaxChange(){
        $field = $this->get('field');
        $this->get('value')?$value=$this->get('value'):$value=0;
        $id = $this->get('id');
        $data = $this->m['article']->ajaxChange($field,$value,$id);
        if($data){
            if($field=='price'){
                $arr = array('value'=>number_format($value,2),'id'=>$id);
            }else{
                $arr = array('value'=>$value,'id'=>$id);
            }
            echo json_encode($arr);exit;
        }
    }


    /**
     * ajaxTitle
     * @return array
     */
    public function ajaxTitle(){
        $value = $this->post('param');
        $key = $this->post('name');
        $data = $this->m['article']->ajaxTitle($key,$value);
        if($data){
            $output = ['status'=>'n','info'=>'用户名重复！'];
        }else{
            $output = ['status'=>'y','info'=>'用户名验证通过!'];
        }

        echo json_encode($output);exit;
    }


    /**
    导出xls文件
     */
    public function outCsv(){

        if($this->post('checked')){
            $id_arr = explode(',',$this->post('checked'));
            array_pop($id_arr);
            $filename = ROOT_PATH.'/Upload/csv/'; //设置文件名
            if (!file_exists($filename)) {
                mkdirs($filename);
            }
            $http_host = $_SERVER['HTTP_HOST'];
            foreach($id_arr as $k=>$v){
                $data = $this->m['article']->getOne($v);
                $template = $this->m['columns']->getOne($data['columnsid'],'template');
                $url = $http_host.$template.$data['id'].'.shtml';
                $xls_arr[] = array($data['title'],$url,date('Y-m-d',$data['time']));
            }
            $header = array('标题','链接','添加日期');
            export2csv($filename.'url.xls', $xls_arr, $header);
        }
    }


    /**
     * 更新文章栏目id
     */
    public function gxColumnsId(){
        $this->m['article']->gxColumnsId();exit;
    }

    /**
	 * 执行结果
	 * @return html
	 */
	public function execution(){
		$this->display('Article/execution.html');
	}

}

?>