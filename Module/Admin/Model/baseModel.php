<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
// 首页
namespace  Admin\Model;

use Lib\Model as Model;

class baseModel extends Model{

	public function getOne(){
		
		$sql = <<<EOT
		select * from `@_base`;
EOT;
		return $this->prepare($sql)
					->execute()
					->fetch();
	}

	public function edit(Array $array){

		$sql = <<<EOT
		update `@_base` set 
			name		=	:name,
			title 		=	:title,
			domran 		=	:domran,
			copyright 	=	:copyright,
			`keys`      =   :keys,
			description =	:description,
			sw_link     =	:sw_link,
			template 	=	:template
EOT;

		$re = $this->prepare($sql);

		$re->name 			= $array['name'];
		$re->title 			= $array['title'];
		$re->domran 		= $array['domran'];
        $re->keys 		    = $array['keys'];
		$re->copyright 		= $array['copyright'];
		$re->description 	= $array['description'];
        $re->sw_link 	    = $array['sw_link'];
		$re->template 		= $array['template'];

		return $re->execute();
	}
}

?>