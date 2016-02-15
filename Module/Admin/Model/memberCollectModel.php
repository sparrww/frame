<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
// 会员收藏
namespace  Admin\Model;

use Lib\Model as Model,Lib\Lib as Lib;

class memberCollectModel extends Model
{


    /**
     * 获取单条会员收藏
     *
     * @return array
     */
    public function getOne($id, $field = '*')
    {

        $sql = <<<EOT
		select a.$field from @_member_collect a where mid=:id
EOT;
        $re = $this->prepare($sql);

        $re->id = $id;

        $data = $re->execute()->fetchAll();

        return $data;
    }

    /**
     * 获取会员收藏信息
     *
     * @return array
     */
    public function getAll($field = '*')
    {

        $sql = <<<EOT
		select a.$field from @_member_collect a order by sort
EOT;

        $re = $this->prepare($sql);

        $data = $re->execute()->fetchAll();

        return $data;
    }

    /**
     * 获取医生收藏信息
     *
     * @return array
     */
    public function getCollectNum($key,$value,$field = '*')
    {

        $sql = <<<EOT
		select a.$field from @_member_collect a where $key=$value
EOT;

        $re = $this->prepare($sql);

        $data = $re->execute()->fetchAll();

        return $data;
    }


    /**
     * 保存会员收藏
     *
     * @return array
     */
    public function save($array = [], $id = "")
    {

        if (!$id) {

            $sql = <<<EOT
		insert into `@_member_collect` (`name`,`member_collect`,`w_status`) values (:name,:member_collect,:w_status)
EOT;
        } else {

            $sql = <<<EOT
		update `@_member_collect` set
			name		=	:name,
			member_collect 		=	:member_collect,
			w_status    =   :w_status
			where id	=	$id
EOT;
        }

        $re = $this->prepare($sql);

        $re->name = $array['name'];
        $re->member_collect = $array['member_collect'];
        $re->w_status = $array['w_status'];

        return $re->execute();
    }


    /**
     * 删除会员收藏
     *
     * @return array
     */
    public function member_collectDel($classid)
    {

        $sql = "delete from `@_member_collect` where id in (" . $classid . ")";

        return $this->prepare($sql)->execute();
    }
}


?>