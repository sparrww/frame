<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
// 模型类
//extends Controller

namespace Lib;

use Lib\Driver\DbPdo as DbPdo;

class Model extends Lib{

	protected $db;
	protected $config = [];
	protected $re;
	private $boundValue	= [];
	private $prepareSql;
	private $compiledSql;

	/**
	* 构造函数
	*/
    public function __construct(){
    	$this->db=$this->getDbObject('Db'.C('DB_TYPE'));
    	// if($name)
	}

	/*
	* 获取数据方法
	*/
	public function getDbObject($classname){
		$classfile=SYSTEM_DRIVER_PATH.'/'.$classname.'.php';
		if(file_exists($classfile)){
			include_once $classfile;
			if(!is_object($classname)){
				return new DbPdo(getconfig('Dbconfig.php'));
			}
		}
	}

	/*
	* 预处理语句
	* @param $sql	type:string
	*/
	public function prepare($sql){
		if($re) unset($re);
		$this->re = $this->formatPrepare(str_replace('@_',C('DB_PREFIX'),$sql));
		return $this;
	}

	/*
	* 绑定对象
	* @param $key	type:string
	* @param $value	type:string
	*/
	public function bindValue($array=[]){

		if($this->re){
			if(is_array($array)){
				$this->boundValue = $array;
				foreach($array as $key => $value){
					if(!preg_match("/(:[0-9a-zA-Z_]+)/",$key))	throwexce('Parameters error!');
						$this->re->bindValue($key,$this->quote($value));
					}
				}
			return $this;
		}else{
			throwexce('Object bindValue error!');
		}
	}

	/*
	 * 输出多条记录
     * @access public
	* @param $array  type:array
     * @return array
	*/
	public function execute($array=[]){
		if($this->re){
			if(is_array($array)){
				$this->bindValue($array);
			}
			$re=$this->re->execute();
			return $this;
		}else{
			throwexce('Object execute error!');
		}
	}

	/*
	 * 输出记录数
     * @access public
     * @return array
	*/
	public function count($field = 'COUNT(*)',$obj=\PDO::FETCH_ASSOC){
		$array = $this->re?$this->re->fetch($obj):'';
		return $array[$field];
	}

	/*
	 * 输出单条记录
     * @access public
     * @return array
	*/
	public function fetch($obj=\PDO::FETCH_ASSOC){
		return $this->re?$this->re->fetch($obj):null;
	}

	/*
	 * 输出多条记录
     * @access public
     * @return array
	 */
	public function fetchAll($obj=\PDO::FETCH_ASSOC){
		return $this->re?$this->re->fetchAll($obj):null;
	}

	/*
	 * 预处理SQL
     * @access public
     * @return array
	 */
    public function formatPrepare($sql){
		if(!isset($sql)) return throwexce(sprintf('%s Statement error!',$sql));
		$this->prepareSql=$sql;
		return $this->db->prepare($sql);
	}

	/**
	 * 魔术方法属性赋值
	 * @access	public
	 * @param	$key	type:string, desc:绑定参数键
	 * @param	$value	type:mixed, desc:绑定参数值
	 * @return	void
	 *
	 */
	public function __set( $key,$value){
		return $this->re?$this->re->bindValue(':'.ltrim($key,': '),$value):throwexce(sprintf('%s Statement error!',$sql));
	}

	/**
	 * 参数值过滤
	 * @access	public
	 * @param	$value	type:mixed, desc:需要过滤的参数
	 * @return	string
	 */
	public function quote($value){

		switch ($type=gettype($value)){

			case 'integer'		:
			case 'double'		: 	return $value;
			case 'string'		: 	return $value;//$this->db->quote( $value );
			case 'NULL'			: 	return 'NULL';
			case 'array'		:	$depth	= $this->getArrayDepth( $value );	// 判断数组深度
									if($depth===1){
										return $this->quoteArrayIn( $value );
									}
									if($depth===2){
										return $this->quoteArrayValue( $value );
									}
									throwexce("Incorrect data type");
			case 'boolean'		:	return $value ? '1' : '0';
			case 'object'		:
			case 'resource'		:
			case 'unknown type'	:				
			default				: 	
			throwexce("Incorrect data type");
		}
	}
	/**
	 * 获取数组深度
	 * @access	protected
	 * @param	$array	type:array
	 * @return	int
	 */
	protected function getArrayDepth($array=[]){ 
		$max_depth 	= 0;
		$iteriter	= new \RecursiveIteratorIterator( new \RecursiveArrayIterator($array), \RecursiveIteratorIterator::LEAVES_ONLY );
		foreach($iteriter as $k => $v){
			if($iteriter->getDepth()>$max_depth)	$max_depth = $iteriter->getDepth();
		}
		return $max_depth+1; 
	} 
	/**
	 * 过滤一维数组值
	 * @access	protected
	 * @param	$array	type:array, desc:数组
	 * @return	string
	 */
	protected function quoteArrayIn($array=[]){
		foreach ($array as $k => $v){
			$temp[$k] = $this->quote($v);
		}
		return $temp;
	}

	/**
	 * 过滤二维数组值
	 * @access	protected
	 * @param	$array	type:array
	 * @return	string
	 */
	protected function quoteArrayValue($array=[]){
		$temp	= [];
		foreach ($array as $key => $v){
			if(!is_array($v)) throwexce("Illegal data type");
			$temp[$key]	= $this->quoteArrayIn($v);
		}
		return $temp;
	}

    /**
     * 获取数据表字段信息
     * @access public.
     * @return array
     */
    public function getdbfields($name){
        return $this->db->list_fields($name);
    }

    /**
     * 转义字段
     * @access public
     * @param $string type:string
     * @param $array  type:array
     * @return Model
     */
	private function fieldEscape($string,$array=""){
		if(is_array($array)){
			$t=1;
			foreach($array as $k => $v){
				$field[]=$string.'.'.$k.' as '.$v;
				$t++;
			}
			return join(",",$field);
		}else{
			return $string.'.'.$array;
		}
	}

	/**
	 * 执行
	 * @access	public
	 * @param	$sql	type:string
	 * @return	void
	 */
	public function query($sql){
		if(isset($sql)){
			return $this->db->query($sql);
		}else{
			return throwexce(sprintf('%s Statement error!',$sql));			
		}
	}

	/**
	 * 执行
	 * @access	public
	 * @param	$sql	type:string
	 * @return	void
	 */
	public function exec($sql){
		if(isset($sql)){
			return $this->db->exec($sql);
		}else{
			return throwexce(sprintf('%s Statement error!',$sql));			
		}
	}

	/**
	 * 获取编译后SQL语句
	 * @access	public
	 * @return	sql
	 */
	public function getCompiledSql(){
		$this->compiledSql = strtr($this->prepareSql,$this->quote($this->boundValue));
		return $this->compiledSql;
	}

	/**
	 * 事务开启
	 * @access	public
	 * @return	void
	 */
	public function beginTransaction(){
		$this->db->begin();
	}

	/**
	 * 事务回滚
	 * @access	public
	 * @return	void
	 */
	public function rollback(){
		$this->db->rollback();
	}

	/**
	 * 事务提交
	 * @access	public
	 * @return	void
	 */
	public function commit(){
		$this->db->commit();
	}


    /**
     * 获取最后插入ID值
     */
    public function lastinsertid(){ 
        return $this->db->lastInsertId(); 
    } 

	/**
	 * 数组分页
	 * @program $arr array
	 * @program $page_per int
	 * @return string
	 */
	public function arraypage($array=[],$page_per,$showpage='10'){
		$page = new \lib\page(count($array),$page_per,[],$showpage);
		$data['list'] 	= $page->handlearray($array);
		$data['fy'] 	= $page->getpage();
	    $data['total']  = $page->gettotal();
		return $data;
	}

	/**
	 * 分页获取
	 *
	 * @return string
	 */
	public function sqlPage($sql,$array=[],$item_count,$page=20,$showpage='10'){
		$page = new \lib\Page($item_count,$page,[],$showpage);
		$arr['list']	=	$this->prepare($page->handlesql($sql))->execute($array)->fetchAll();//$this->excsql($page->handlesql($sql));
		$arr['fy']		=	$page->getpage();
		$arr['total']	=	$page ->gettotal();
		return $arr;
	}

    /**
     * 备份数据库
     */
    public function dbbackup($dbtable,$dbpath=DBBACKUP_PATH){
        $x=1;

        $path=$dbpath.'/'.date('Y-m-d_His'.rand(100,999));

        $filename = date("Y-m-d_H.i.s"); //存放路径，默认存放到项目最外层
        $size=2048;

        $this->query("set names 'utf8'");
        $sql = "set charset utf8;\r\n";

        foreach($dbtable as $k => $table){

            $q2 = $this->prepare("show create table `$table`")->execute()->fetch();

            $q2[0] = $q2;

            if($q2[0]['Create Table']!=""){

                $sql ='DROP TABLE IF EXISTS `'.$q2[0]['Table'].'`'.";\r\n". $q2[0]['Create Table'].";\r\n";

                foreach($this->prepare("select * from `$table`")->execute()->fetchAll() as $data){

                    $keys = array_keys($data);

                    $keys = array_map('addslashes', $keys);

                    $keys = join('`,`', $keys);

                    $keys = "`" . $keys . "`";

                    $vals = array_values($data);

                    $vals = array_map('addslashes', $vals);

                    $vals = join("','", $vals);

                    $vals = "'" . str_replace("\r\n","/r/n",$vals) . "'";

                    $sql .= "insert into `$table`($keys) values(".str_replace("''","NULL",$vals).");\r\n";


                    if(filesize($path.'/'.sprintf("%05d", $x).".sql")>($size)*1024){

                        $x++;

                    }
                    if(!fileWrite($csql.$sql,sprintf("%05d", $x).".sql",$path)){ return 0; }

                    $sql="";
                }

            }else{
                unset($k);
            }
        }
        return true;
    }

    /**
     * 恢复数据库
     */
    public function dbregain($fname,$dbpath=DBBACKUP_PATH) {

        $array=getFile($dbpath.'/'.$fname);

        foreach($array as $files){
            $sql_contents = file($dbpath.'/'.$fname.'/'.$files);
            $sql_str = '';
            foreach ($sql_contents as $k=>$line){
                $sql_str .= $line;
                if (';' == substr(rtrim($line), -1, 1)) {
                    //一条sql语句结束
                    $a =  $this->prepare(str_replace("/r/n","\r\n",trim($sql_str)))->execute();
                    if(!$a) return false;
                    unset($sql_str);
                    $sql_str = '';
                }
            }
        }
        return true;
    }
}


?>