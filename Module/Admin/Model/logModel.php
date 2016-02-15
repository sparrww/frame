<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
// 日志
namespace  Admin\Model;

use Lib\Model as Model;

class logModel extends Model{

    /**
     * 获取日志信息
     * @access public
     * @return array
     */
	public function getAll($page=20){

		$sql = <<<EOT
		select * from `@_log_content` order by id desc
EOT;

        $count = $this->prepare("select COUNT(distinct a.id) num from @_log_content a")->execute()->count('num');

        $data = $this->sqlpage($sql, [], $count,$page);

		return $data;
	}
    /**
     * 记录日志信息
     * @access public
     * @return array
     */
    public function save($array){

        $sql = <<<EOT
		insert into `@_log_content` set
		message=:message,datetime=:datetime,controller=:controller,operate=:operate,user=:user;
EOT;
        $re =$this->prepare($sql);
        $re->message = $array['message'];
        $re->datetime = $array['datetime'];
        $re->controller = $array['controller'];
        $re->operate = $array['operate'];
        $re->user = $array['user'];

        $data = $re->execute();
        return $data;
    }
}

?>