<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
// 首页
namespace  Admin\Model;

use Lib\Model as Model,Lib\Lib as Lib;

class columnsModel extends Model{


    /**
     * 获取单条栏目
     *
     * @return array
     */
	public function getOne($id,$field=""){

		$sql = <<<EOT
		select * from `@_columns` where id=:id
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
     * 获取所有栏目
     *
     * @return array
     */
    public function getAllColumns($field='*'){

        $sql = <<<EOT
		select $field from `@_columns` where type=1
EOT;

        $re = $this->prepare($sql);

        $data =$re->execute()->fetchAll();

        return $data;
    }

    /**
     * 通过字段获取单条栏目
     *
     * @return array
     */
    public function getOneByField($name,$value='',$field='*'){

        $sql = <<<EOT
		select $field from @_columns where $name like '%$value%'
EOT;

        $re = $this->prepare($sql);

        $data =$re->execute()->fetch();

        return $data;

    }

    /**
     * 通过字段获取多条栏目
     *
     * @return array
     */
    public function getAllByField($name,$value='',$field='*'){

        $sql = <<<EOT
		select $field from @_columns where $name like '%$value%'
EOT;

        $re = $this->prepare($sql);

        $data =$re->execute()->fetchAll();

        return $data;

    }

    /**
     * 获取下级栏目
     *
     * @return array
     */
	public function getAll($classid=0,$field='*'){

		$sql = <<<EOT
		select $field from `@_columns` where classid in ('$classid') and type='1' order by sort asc
EOT;

		$re = $this->prepare($sql);

		//$re->classid = $classid;

		return $re->execute()->fetchAll();
	}


    /**
     * ajax判断
     *
     * @return array
     */
    public function ajaxTitle($key,$value)
    {

        $sql = <<<EOT
		select * from xy_columns where $key=:value
EOT;

        $re = $this->prepare($sql);

        $this->value = $value;

        return $re->execute()->fetch();
    }

	/**
	 * 判断子栏目数量输出
	 * @program $classid int
	 * @return int
	 */
	public function columnsIsdonw($classid){

		if($this->columnsClassCount($classid)>0){

			return $classid;

		}else{

			return $this->getOne($classid,'classid');
		}
	}

	/**
	 * 获取子栏目数
	 * @program $classid int
	 * @return int
	 */
	private function columnsClassCount($classid){
		$sql = <<<EOT
		select COUNT(id) from `@_columns` where classid=:classid
EOT;

		$re = $this->prepare($sql);

		$re->classid = $classid;

		$row = $re->execute()->fetch();

		return $row['COUNT(id)'];
	}

    /**
     * 获取栏目层级
     *
     * @return array
     */
	public function getLevelId($classid){

		foreach($this->getAll($classid) as $k => $v){

			if($this->columnsClassCount($v['id'])>0){
				$string[] =$this->getLevelId($v['id']);
			}else{
				$string[] =$v['id'];
			}
		}
		return array_filter($string);
	}

    /**
     * 保存栏目
     *
     * @return array
     */
	public function save($array=[],$id=""){

		if(!$id){

		$sql = <<<EOT
		insert into `@_columns` (`name`,`module`,`img`,`type`,`nav`,`target`,`classid`,`template`,`title`,`keywords`,`content`,`description`) values (:name,:module,:img,:type,:nav,:target,:classid,:template,:title,:keywords,:content,:description)
EOT;
		}else{

		$sql = <<<EOT
		update `@_columns` set
			name		=	:name,
			module 		=	:module,
			img 		=	:img,
			type        =   :type,
			nav         =   :nav,
			target      =   :target,
			classid 	=	:classid,
			template 	=	:template,
			title       =   :title,
			keywords    =   :keywords,
			content     =   :content,
			description =   :description
			where id	=	$id
EOT;
		}

        $re = $this->prepare($sql);

		$re->name 		= $array['name'];
		$re->module 	= $array['module'];
        $re->img 	= $array['img'];
        $re->type 	= $array['type'];
        $re->nav 	= $array['nav'];
        $re->target 	= $array['target'];
		$re->classid 	= $array['classid'];
		$re->template 	= $array['template'];
        $re->title 	= $array['title'];
        $re->keywords 	= $array['keywords'];
        $re->content 	= $array['content'];
        $re->description 	= $array['description'];

		return $re->execute();
	}

    /**
     * 删除栏目
     *
     * @return array
     */
	public function delete($id){

		$columnsid = $id.($this->columnsClassCount($id)>0?','.implode(',',$this->getLevelId($id)):'');

		$article = Lib::getinstance()->A('Admin\Model\article',Null,'Model');

		$this->beginTransaction();

		if(!$this->columnsDel($columnsid) || !$article->delete($columnsid,'columnsid')){

			$this->rollback();

			return false;

		}

		$this->commit();
		return true;
	}

	private function columnsDel($classid){

		$sql = "delete from `@_columns` where id in (".$classid.")";

		return $this->prepare($sql)->execute();
	}


    /**
    更新栏目classid
     **/
    function gxClasssId(){
        $sql = <<<aaa
        select * from xy_columns
aaa;
        $date = $this->prepare($sql)->execute()->fetchAll();
        foreach($date as $v){
            $id = $v['id'];
            $name = $v['f_module'];

            if(!$name) continue;

            $sql = <<<aaa
        select id from xy_columns where module='$name'
aaa;
            $classid = $this->prepare($sql)->execute()->fetch();
            $sql = <<<AAA
            update xy_columns set classid=$classid[id] where id=$id
AAA;

            $aa = $this->prepare($sql)->execute();
            if(!$aa) die('!!!');
        }
        echo 'OK';exit;
    }

    /**
     * 排序栏目
     *
     * @return array
     */
	public function sort($array=[]){

			foreach($array as $k => $v){

			$sql = <<<EOT
			update `@_columns` set
				sort		=	$v
				where id	=	$k
EOT;

		$re = $this->prepare($sql)->execute();

			}

		return $re;
	}

    /**
     * 获取栏目层级
     *
     * @return array
     */
	public function columnsOption($classid=0,$f=false){
		$sql = <<<EOT
		select * from `@_columns` where type='1'
EOT;
		$data =$this->prepare($sql)
					->execute()
					->fetchAll();
		return $this->changeOption($this->classTree($data),$classid,$f);
	}


    /**
     * 遍历所有栏目
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
     * 栏目遍历排序
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
                            $arr .= '<option value="'.$v['id'].'" '.$option.'>'.str_repeat('──',$i).$v['name'].'</option>';
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