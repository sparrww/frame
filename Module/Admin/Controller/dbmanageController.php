<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
// 数据库管理

namespace  Admin\Controller;

use Lib\Controller as Controller,Lib\Lib as Lib;

class dbmanageController extends controlController{


	const DBMANAGE_lABNORMAL_MESSAGE	=	'数据异常请重试！';
	const DBMANAGE_EXECUTIONS_MESSAGE	=	'操作成功！';
	const DBMANAGE_EXECUTIONF_MESSAGE	=	'操作失败！';

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
		$this->m = Lib::getinstance()->A('Admin\Model\dbmanage',Null,'Model');
    }

	/*
	网站基本信息设置
	*/
	public function dbbackup(){
		$data['table'] = $this->m->listTable();
		include $this->display('Dbmanage/index.html',$data);
	}


    /**
     * 恢复数据
     *
     * @return array
     */
    public function dbregain(){
        $this->display('Dbmanage/dbregain.html',array("dblist" => array_filter(getDir(DBBACKUP_PATH))));
    }

    /**
     * 管理备份数据
     *
     * @return array
     */
    public function dbmanages(){
        $this->display('Dbmanage/dbmanages.html',array("dblist" => array_filter(getDir(DBBACKUP_PATH))));
    }

    /**
     * 删除信息
     *
     * @return array
     */
    public function delete(){

        if($this->m->deletefile($this->get())){
            $this->r_log('删除数据库备份文件');
            echo '<script type="text/javascript">alert("删除成功！");</script>';
            echo '<meta http-equiv="refresh" content="0;url=/Admin/dbmanage/dbmanages">';
        }else{
            echo '<script type="text/javascript">alert("删除失败！");window.history.back()</script>';
        }
    }

    /**
     * 批量操作
     *
     * @return array
     */
    public function one(){

        if($this->m->operating($this->get())){

            echo '<script type="text/javascript">alert("操作成功！");</script>';
            echo '<meta http-equiv="refresh" content="0;url='.app_url('/Dbmanage/dbbackup').'">';

        }else{

            echo '<script type="text/javascript">alert("操作失败！");window.history.back()</script>';

        }
    }

    /**
     * 批量操作
     *
     * @return array
     */
    public function batch(){
        $_POST = $this->post();
        if(!is_array($_POST['dbname'])){
                $data = [
                    'status'    =>  'c',
                    'message'   =>  self::DBMANAGE_lABNORMAL_MESSAGE
                ];
        }else{
            if($this->m->$_GET['method']($_POST['dbname'])){
                $this->r_log('备份恢复数据库');
                $data = [
                    'status'    =>  'y',
                    'message'   =>  self::DBMANAGE_EXECUTIONS_MESSAGE
                ];

            }else{

                $data = [
                    'status'    =>  'n',
                    'message'   =>  self::DBMANAGE_EXECUTIONS_MESSAGE
                ];

            }
        }
        echo json_encode($data);
    }

    /**
     * 执行
     *
     * @return array
     */
    public function regain(){

        if($this->m->regain()){

            $data = [
                'status'    =>  'y',
                'message'   =>  self::DBMANAGE_EXECUTIONS_MESSAGE
            ];

        }else{

            $data = [
                'status'    =>  'n',
                'message'   =>  self::DBMANAGE_EXECUTIONS_MESSAGE
            ];

        }
        echo json_encode($data);
    }

    /*
    执行结果
    */
    public function execution(){
        include $this->display('Dbmanage/execution.html');
    }

}

?>