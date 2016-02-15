<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio
 *******************************************************************/
// 首页
namespace  Admin\Model;

use Lib\Model as Model;

class dbmanageModel extends Model{



    /**
     * 数据表列表
     *
     * @return array
     */
	public function listTable(){

		$sql = 'SHOW TABLE STATUS FROM '.C("DB_NAME").';';
		$re = $this->prepare($sql);
		return $re->execute()->fetchAll();
	}

    /**
     * 修复数据
     *
     * @return array
     */
    public function repair($array){
        foreach($array as $v) {
            $sql = 'repair table `' . $v . '`';
            $result = $this->prepare($sql)->execute()->fetch();
            if (!$result) return false;
        }
        return true;
    }


    public function operating($array){

        $sql = $array['method']." table ".$array['dbname'];

        if($this->prepare($sql)->execute()->fetch()){

            return true;

        }else{

            return false;

        }
    }

    /**
     * 修复数据
     *
     * @return array
     */
    public function optimize($array){
        foreach($array as $v) {
            $sql = 'optimize table `' . $v . '`';
            $result = $this->prepare($sql)->execute()->fetch();
            if (!$result) return false;
        }

        return true;
    }

    /**
     * 修复数据
     *
     * @return array
     */
    public function backup($array){

        if($this->dbbackup($array)){

            return true;

        }else{

           return false;
        }
    }
    /**
     * 备份数据
     *
     * @return array
     */
    // public function backups(){
    //     if($this->dbbackup(time())){
    //         return array('status' => 'y');

    //     }else{

    //         return array('status' => 'n');
    //     }
    // }

    /**
     * 恢复数据
     *
     * @return array
     */
    public function regain(){
        if($this->dbregain($_POST['dbname'])){

            return array('status' => 'y');
        }else{

            return array('status' => 'n');
        }
    }

    /**
     * 数据管理
     *
     * @return array
     */

    public function deletefile($array){

        $dir=DBBACKUP_PATH.'/'.$array['name'].'/';


        if(file_exists($dir)){

            if(rmdirs($dir)){
                return true;

            }else{
                return false;

            }

        }else{
            return false;
        }
    }

}

?>