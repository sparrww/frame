<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
// 友情链接
namespace  Admin\Model;

use Lib\Model as Model,Lib\Lib as Lib;

class linkModel extends Model{


    /**
     * 获取单条友情链接
     *
     * @return array
     */
	public function getOne($id,$field='*'){

		$sql = <<<EOT
		select a.$field from @_friend_link a where id=:id
EOT;

		$re = $this->prepare($sql);

		$re->id = $id;

		$data =$re->execute()->fetch();

		return $data;
	}

    /**
     * 获取友情链接信息
     *
     * @return array
     */
    public function getAll($field='*'){

        $sql = <<<EOT
		select a.$field from @_friend_link a order by sort
EOT;

        $re = $this->prepare($sql);

        $data =$re->execute()->fetchAll();

        return $data;
    }



    /**
     * 保存友情链接
     *
     * @return array
     */
	public function save($array=[],$id=""){

		if(!$id){

		$sql = <<<EOT
		insert into `@_friend_link` (`name`,`link`,`w_status`) values (:name,:link,:w_status)
EOT;
		}else{

		$sql = <<<EOT
		update `@_friend_link` set
			name		=	:name,
			link 		=	:link,
			w_status    =   :w_status
			where id	=	$id
EOT;
		}

        $re = $this->prepare($sql);

		$re->name 		= $array['name'];
		$re->link 	= $array['link'];
        $re->w_status 	= $array['w_status'];
		
		return $re->execute();
	}


	public function linkDel($classid){

		$sql = "delete from `@_friend_link` where id in (".$classid.")";

		return $this->prepare($sql)->execute();
	}

    /**
     * 排序友情链接
     *
     * @return array
     */
	public function sort($array=[]){

			foreach($array as $k => $v){

			$sql = <<<EOT
			update `@_friend_link` set
				sort		=	$v
				where id	=	$k
EOT;

		$re = $this->prepare($sql)->execute();

			}

		return $re;
	}
}

?>