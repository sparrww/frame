<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
// 用户
namespace  Admin\Model;

use Lib\Model as Model;

class memberModel extends Model
{

    /**
     * 获取单条用户
     *
     * @return array
     */
    public function getOne($id, $field = '*')
    {

        $sql = <<<EOT
		select a.$field from @_member a where member_id=:id
EOT;

        $re = $this->prepare($sql);

        $re->id = $id;

        $data = $re->execute()->fetch();

        return $data;
    }

    /**
     * 通过字段获取单条用户
     *
     * @return array
     */
    public function getOneByField($key,$value='',$field='*'){

        $sql = <<<EOT
		select $field from @_member where $key like '%$value%'
EOT;
        $re = $this->prepare($sql);

        $data =$re->execute()->fetch();

        return $data;

    }

    /**
     * 获取用户信息
     *
     * @return array
     */
    public function getAll($field = '*',$page=20)
    {

        $sql = <<<EOT
		select a.$field from @_member a order by member_id desc
EOT;

        $count = $this->prepare("select COUNT(distinct a.member_id) num from @_member a")->execute()->count('num');

        $data = $this->sqlpage($sql, [], $count,$page);

        return $data;
    }


    /**
     * 保存用户
     *
     * @return array
     */
    public function save($array = [], $id = "")
    {

        if (!$id) {
            $sql = <<<EOT
		insert into `@_member` (`open_id`) values (:open_id)
EOT;
            $re = $this->prepare($sql);
            $re->open_id    = $array['open_id'];
            return $re->execute()->lastinsertid();
        } else {

            $sql = <<<EOT
		update `@_member` set
			member_truename		=	:member_truename,
			member_sex 		    =	:member_sex,
			member_tel          =   :member_tel,
			member_card         =   :member_card,
			member_medical_card =   :member_medical_card
			where member_id	        =	$id
EOT;

            $re = $this->prepare($sql);

            $re->member_truename    = $array['member_truename'];
            $re->member_sex         = $array['member_sex'];
            $re->member_tel         = $array['member_tel'];
            $re->member_card        = $array['member_card'];
            $re->member_medical_card= $array['member_medical_card'];

            return $re->execute();
        }


    }


    /**
     * 更新就诊卡号
     *
     * @return array
     */
    public function editMedicalCard($array = [], $id = "")
    {
        $sql = <<<EOT
    update `@_member` set
        member_medical_card =   :member_medical_card
        where member_id	    =	$id
EOT;
        $re = $this->prepare($sql);
        $re->member_medical_card= $array['member_medical_card'];
        return $re->execute();
    }

    public function memberDel($classid)
    {

        $sql = "delete from `@_member` where member_id in (" . $classid . ")";

        return $this->prepare($sql)->execute();
    }
}

?>