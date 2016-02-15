<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
// 首页
namespace  Admin\Model;

use Lib\Model as Model;

class userModel extends Model{


    public function getOne($id){

        $sql = <<<EOT
		select a.*,b.name from `@_manage` a left join `@_power` b on a.power_id=b.id where a.id=:id;
EOT;
        $re = $this->prepare($sql);
        $re->id = $id;
        return $re->execute()->fetch();
    }


	public function getAll(){
		
		$sql = <<<EOT
		select a.*,b.name from `@_manage` a left join `@_power` b on a.power_id=b.id order by a.power_id;
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
    public function save($array=[],$id=""){

        if(!$id){

            $sql = <<<EOT
		insert into `@_manage` (`admin`,`password`,`power_id`,`status`,`addtime`) values (:admin,:password,:power_id,:status,:addtime)
EOT;
        }else{

            if($array['password']){
                $sql = <<<EOT
                update `@_manage` set
                    password 	=	:password,
                    status      =   :status,
                    power_id    =   :power_id
                    where id	=	:id
EOT;
            }else{
                $sql = <<<EOT
                update `@_manage` set
                    status      =   :status,
                    power_id    =   :power_id
                    where id	=	:id
EOT;
            }

        }

        $re = $this->prepare($sql);

        if(!$id){
            $re->admin 		= $array['admin'];
            $re->password 	= $array['password'];
            $re->power_id 	= $array['power_id'];
            $re->status 	= $array['status'];
            $re->addtime 	= date('Y-m-d H:i:s',time());
        }else{
            if($array['password']){
                $re->id 		= $id;
                $re->password 	= $array['password'];
                $re->power_id 	= $array['power_id'];
                $re->status 	= $array['status'];
            }else{
                $re->id 		= $id;
                $re->power_id 	= $array['power_id'];
                $re->status 	= $array['status'];
            }
        }


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