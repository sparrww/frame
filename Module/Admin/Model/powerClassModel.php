<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio
 *******************************************************************/
namespace  Admin\Model;

use Lib\Model as Model,Lib\Lib as Lib;

class powerClassModel extends Model{


    /**
     * 获取单个权限
     *
     * @return array
     */
    public function getOne($id,$field=""){

        $sql = <<<EOT
		select * from `@_power_class` where id=:id
EOT;

        $re = $this->prepare($sql);

        $re->id = $id;

        $data =$re->execute()->fetch();

        if($field){
            return $data[$field];
        }else{
            return $data;
        }
    }


    /**
     * 通过控制器，方法获取权限id
     *
     * @return array
     */
    public function getOneByField($act,$op,$type=0){

        $sql = <<<EOT
		select * from `@_power_class` where controller=:act and operate=:op and type=:type;
EOT;

        $re = $this->prepare($sql);

        $re->act = $act;
        $re->op  = $op;
        $re->type  = $type;

        return $re->execute()->fetch();

    }


    /**
     * 获取下级栏目
     *
     * @return array
     */
    public function getAll(){

        $sql = <<<EOT
		select * from `@_power_class` order by controller
EOT;
        $re = $this->prepare($sql);

        return $re->execute()->fetchAll();
    }



}

?>