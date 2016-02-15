<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
namespace  Admin\Model;

use Lib\Model as Model,Lib\Lib as Lib;

class powerModel extends Model{


    /**
     * 获取单个权限
     *
     * @return array
     */
	public function getOne($id,$field=""){

		$sql = <<<EOT
		select * from `@_power` where id=:id
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
     * 获取下级栏目
     *
     * @return array
     */
    public function getAll(){

        $sql = <<<EOT
		select * from `@_power`
EOT;
        $re = $this->prepare($sql);

        return $re->execute()->fetchAll();
    }

    /**
     * 保存权限
     *
     * @return array
     */
	public function save($array=[],$id=""){

		if(!$id){

		$sql = <<<EOT
		insert into `@_power` (`name`,`class_id`) values (:name,:class_id)
EOT;
		}else{

		$sql = <<<EOT
		update `@_power` set 
			name		=	:name,
			class_id 	=	:class_id
			where id	=	$id
EOT;
		}

        $re = $this->prepare($sql);

		$re->name 		= $array['name'];
		$re->class_id 	= $array['class_id'];
		
		return $re->execute();
	}



    /**
     * 删除权限组
     *
     * @return array
     */
    public function delete($w,$field='id'){

        $sql = "delete from `@_power` where ".$field." in ($w)";

        $re = $this->prepare($sql);

        return $re->execute();

    }


    /**
     * 遍历所有权限
     *
     * @return array
     */
	public function classTree($data=[],$classid=0){
		$tree =[];
		foreach($data as $k => $v){
		   if($v['classid'] == $classid){
			$v['classid'] = $this->classTree($data, $v['id']);
			$tree[] = $v;
		   }
		}
		return $tree;
	}


    /**
     * 权限遍历排序
     *
     * @return option
     */
	public function changeOption($array=[],$vle=0,$w=false,$i=0){
		if(is_array($array)){
			if(count($array)>0){
				foreach($array as $k => $v) {
					if($w){
						($v['id']==$vle)?$option='selected':$option="";
						if(count($v['classid'])>0){
							$arr .= '<optgroup label="'.str_repeat('──',$i).$v['name'].'"></optgroup>';
							$arr .= $this->changeOption($v['classid'],$vle,$w,$i+1);
						}else{
							$arr .= '<option value="'.$v['id'].'" '.$option.'>'.str_repeat('──',$i).$v['name'].'</option>';
						}
					}else{
						($v['id']==$vle)?$option='selected':$option="";
						$arr .= '<option value="'.$v['id'].'" '.$option.'>'.str_repeat('──',$i).$v['name'].'</option>';
						if(count($v['classid'])>0){
							$arr .= $this->changeOption($v['classid'],$vle,$w,$i+1);
						}
					}
				}
			}
			return $arr;
		}
	}
}

?>