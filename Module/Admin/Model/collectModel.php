<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
// 医生收藏
namespace  Admin\Model;

use Lib\Model as Model;

class collectModel extends Model{


    /**
     * 根据用户获取收藏列表
     *
     * @return array
     */
    public function getOne($id,$field="*"){

        $sql = <<<EOT
		select a.$field from @_member_collect a where mid=:id order by aid desc;
EOT;
        $re = $this->prepare($sql);
        $re->id = $id;
        return $re->execute()->fetchAll();
    }


	public function getAll(){
		
		$sql = <<<EOT

EOT;
		$data =$this->prepare($sql)
					->execute()
					->fetchAll();
		return $data;
	}

    /**
     * 保存修改
     *
     * @return array
     */
    public function save($id="",$aid=""){

       $sql = <<<EOT
        insert into @_member_collect set mid=:mid,aid=:aid;
EOT;
       $re = $this->prepare($sql);
        $re->mid = $id;
        $re->aid = $aid;
        return $re->execute();
    }

    /**
     * 删除用户
     *
     * @return array
     */
    public function delete($w,$field='id'){

        $sql = "delete from `@_manage` where ".$field." in ($w)";

        $re = $this->prepare($sql);

        return $re->execute();

    }

}

?>