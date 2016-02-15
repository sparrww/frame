<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
// 关键词链接
namespace  Admin\Model;

use Lib\Model as Model,Lib\Lib as Lib;

class tagLinkModel extends Model{


    /**
     * 获取单条关键词链接
     *
     * @return array
     */
	public function getOne($id,$field='*'){

		$sql = <<<EOT
		select a.$field from @_tag_link a where id=:id
EOT;

		$re = $this->prepare($sql);

		$re->id = $id;

		$data =$re->execute()->fetch();

		return $data;
	}

    /**
     * 获取关键词链接信息
     *
     * @return array
     */
    public function getAll($field='*'){

        $sql = <<<EOT
		select a.$field from @_tag_link a order by id desc
EOT;

        $re = $this->prepare($sql);

        $data =$re->execute()->fetchAll();

        return $data;
    }



    /**
     * 保存关键词链接
     *
     * @return array
     */
	public function save($array=[],$id=""){

		if(!$id){

		$sql = <<<EOT
		insert into `@_tag_link` (`name`,`link`) values (:name,:link)
EOT;
		}else{

		$sql = <<<EOT
		update `@_tag_link` set
			name		=	:name,
			link 		=	:link
			where id	=	$id
EOT;
		}

        $re = $this->prepare($sql);

		$re->name 		= $array['name'];
		$re->link 	= $array['link'];
		
		return $re->execute();
	}


	public function linkDel($classid){

		$sql = "delete from `@_tag_link` where id in (".$classid.")";

		return $this->prepare($sql)->execute();
	}

}

?>