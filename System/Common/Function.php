<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio
 *******************************************************************/
// 函数库

defined('TPL_INCLUDE') or die( 'Restricted access');

/**
 * 文件载入
 *
 * @param  string $name	文件名称
 * @param  array  $ext	文件后缀
 * @return bool
 */
function import($name, $ext = '.php') {
    static $_loads = array();

    //$path = (substr($name, 0, 3) == 'App' ? APP_PATH : SYSTEM_PATH).'/';

    $path = SYSTEM_PATH.'/';

    //$name = str_replace('App.', '', $name);
    $name = str_replace('.', '/', $name);
    $file = $path . $name . $ext;

    if(isset($_loads[$file])) {       //如果已经载入过直接返回
        return true;
    }
    if(strpos($file, '*') > 1){       //如果有*号存在, 代表载入指定目录下的所有
        $files = glob($file);
        $len   = count($files);

        for($i = 0; $i < $len; $i++) {

            if(file_exists($files[$i])) {
                include_once($files[$i]);
                $_loads[$file] = true;
            }
        }
        return true;
    }elseif(file_exists($file)) {
        include_once($file);
        $_loads[$file] = true;
        return true;
    }
    return false;
}


/**
 * 读取或设置缓存
 *
 * @param   type:string  $name   缓存名称
 * @param   type:mixed   $value  缓存内容, null删除缓存
 * @param   type:path    $path   缓存路径
 * @return  mixed
 */
function cache($name, $value ="" , $path ="" ){
    //     return false;   //调试阶段, 不进行缓存
    $path = empty($path) ? UPLOAD_PATH ."data/" : $path;
    $file = $path . $name . ".php";
    if (empty($value)) {
        //缓存不存在
        if (!is_file($file)) {
            return false;
        }
        // 删除缓存
        if (is_null($value)) {
            unlink($file);
            return true;
        }
        $data = include $file;
        return $data;
    }
    $value = var_export($value, true);
    $value = "<?php defined('TPL_INCLUDE') or exit('Access Denied'); return {$value}; ?>";
    return file_put_contents($file, $value);
}


/**
 * 调用配置文件
 *
 * @param	string $path   文件夹路径
 * @return	array
 */
function C($string){

    $array=getconfig(CONFIG_PATH);

    if(is_array($array)){

        return $array[$string];

    }else{
        throwexce('config not array!');
    }
}

/**
 * @method 多维数组转字符串
 * @param type $array
 * @return type $srting
 * @author yanhuixian
 */
function arrayToString($arr) {
    if (is_array($arr)){
        return implode(',', array_map('arrayToString', $arr));
    }
    return $arr;
}

/**
 * 二维数组转一维数组
 *
 * @param   type:array  $array  数组
 * @return  array
 */
function array_multitosingle( $array ){

    static $result_array = array();

    foreach( $array as $key => $value )
    {
        if( is_array( $value ) )
        {
            $result_array = array_merge( $result_array, $value);
        }
    }
    return $result_array;
}

/**
 * 合并配置文件
 *
 * @param   type:array  $array  数组
 * @return  array
 */
function getconfig($config){

    foreach(getFile($config) as $v){

        $array[]=include_once($config.'/'.$v);

    }
    return array_multitosingle($array);
}

//--------------------------------------------------------
//	文件目录函数
//--------------------------------------------------------
/**
 * 批量创建目录
 *
 * @access  public
 * @param	string $path   文件夹路径
 * @param	int    $mode   权限
 * @return	bool
 */
function mkdirs($path, $mode = 0777){
    if (!is_dir($path)) {
        mkdirs(dirname($path), $mode);
        $error_level = error_reporting(0);
        $result      = mkdir($path, $mode);
        error_reporting($error_level);
        return $result;
    }
    return true;
}

/**
 * 删除文件夹
 *
 * @access  public
 * @param	string $path		要删除的文件夹路径
 * @return	bool
 */
function rmdirs($path){
    $error_level = error_reporting(0);
    if ($dh = opendir($path)) {
        while (false !== ($file=readdir($dh))) {
            if ($file != '.' && $file != '..') {
                $file_path = $path.'/'.$file;
                is_dir($file_path) ? rmdirs($file_path) : unlink($file_path);
            }
        }
        closedir($dh);
    }
    $result = rmdir($path);
    error_reporting($error_level);
    return $result;
}


/**
 * 写入文件
 *
 * @access  public
 * @param	string $files		文件名
 * @return	bool
 */
function fileWrite($content,$files,$path){
    mkdirs($path);

    $fp = fopen($path.'/'.$files, 'a+');
    $re=fputs($fp, $content);
    fclose($fp);
    if($re){
        return true;
    }else{
        return false;
    }
}


/**
 * 读取目录列表
 *
 * @access  public
 * @return	bool
 */
function getDir($dir) {
    $dirArray[]=NULL;
    if (false != ($handle = opendir ( $dir ))) {
        $i=0;
        while ( false !== ($file = readdir ( $handle )) ) {
            //去掉"“.”、“..”以及带“.xxx”后缀的文件

            if ($file != "." && $file != ".."&&!strpos($file,".")) {
                $dirArray[$i]=$file;
                $i++;
            }
        }
        //关闭句柄

        closedir ( $handle );
    }
    return $dirArray;
}



/**
 * 读取文件列表
 *
 * @param	type:dir  $dir
 * @return	$array
 */
function getFile($dir) {
    $fileArray[]=NULL;
    if (false != ($handle = opendir ( $dir ))) {
        $i=0;
        while( false !== ($file = readdir ( $handle )) ) {


            //去掉"“.”、“..”以及带“.xxx”后缀的文件
            if ($file != "." && $file != ".."&&strpos($file,".")) {
                $fileArray[$i]=$file;
                if($i==100){
                    break;
                }
                $i++;
            }
        }
        //关闭句柄
        closedir ( $handle );
    }

    return $fileArray;

}


/**
 * XML转ARRAY
 *
 * @param  type:xml  $xml
 * @return $array/Xml
 */
function xml_to_array( $xml )
{
    $reg = "/<(\\w+)[^>]*?>([\\x00-\\xFF]*?)<\\/\\1>/";
    if(preg_match_all($reg, $xml, $matches))
    {
        $count = count($matches[0]);
        $arr = array();
        for($i = 0; $i < $count; $i++)
        {
            $key= $matches[1][$i];
            $val = xml_to_array( $matches[2][$i] );  // 递归
            if(array_key_exists($key, $arr))
            {
                if(is_array($arr[$key]))
                {
                    if(!array_key_exists(0,$arr[$key]))
                    {
                        $arr[$key] = array($arr[$key]);
                    }
                }else{
                    $arr[$key] = array($arr[$key]);
                }
                $arr[$key][] = $val;
            }else{
                $arr[$key] = $val;
            }
        }
        return $arr;
    }else{
        return $xml;
    }
}

/**
 * 替换文件路径以网站根目录开始，防止暴露文件的真实地址
 *
 * @param   type:path  $path
 * @return  type:path  返回一个相对当前站点的文件路径
 */
function replpath($path){
    $root_path = str_replace(DIRECTORY_SEPARATOR, '/', ROOT_PATH);
    $src_path = str_replace(DIRECTORY_SEPARATOR, '/', $path);
    return str_replace($root_path, '', $src_path);
}


/**
 * 当前模块
 *
 * @return boolean
 */
function itemName(){
    $exp=explode('?',$_SERVER['REQUEST_URI']);
    if($exp[1]==""){
        $array=explode("/",$_SERVER['PATH_INFO']);
        if($array[1]){
            return $array[1];
        }else{
            return C('DEFAULT_MODULE');
        }
    }else{
        return $_GET['module'];
    }
}

/**
 * php 接收流文件
 *
 * @param  type:file  $file 接收后保存的文件名
 * @return boolean
 */
function receiveStreamFile($receiveFile){

    $streamData = isset($GLOBALS['HTTP_RAW_POST_DATA'])? $GLOBALS['HTTP_RAW_POST_DATA'] : '';

    if(empty($streamData)){
        $streamData = file_get_contents('php://input');
    }

    if($streamData!=''){
        $ret = file_put_contents($receiveFile, $streamData, true);
    }else{
        $ret = false;
    }

    return $ret;

}

/*
 * 下载文件
 *
 * @param  type:path		$path  路径
 * @param  type:file		$file  文件
 * @param  type:ext  	$ext   扩展名
 * @return bool
 */
function downFile($path,$file,$ext=".png"){
    $name=time().rand(1000,9999).$ext;
    $fileName='/Upload/image/auth/'.$name;
    if(file_put_contents($path.'/'.$name,file_get_contents($file))){
        return $fileName;
    }else{
        return false;
    }
}

/*
 * 导出XLS文件
 *
 * @param  type:array	$data_ht  标题
 * @param  type:array	$data 	  内容
 * @param  type:String  $file_name 文件名
 */
function outputXlsHeader($data_ht,$data,$file_name = 'export'){
    header('Content-Type: text/xls');
    header ( "Content-type:application/vnd.ms-excel;charset=utf-8" );
    $str = mb_convert_encoding($file_name, 'gbk', 'utf-8');
    header('Content-Disposition: attachment;filename="' .$str . '.xls"');
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    header('Expires:0');
    header('Pragma:public');

    $table_data = '<table border="1">';
    $table_data .= '<tr>';
    foreach ($data_ht as $title){
        $title = mb_convert_encoding($title, 'gbk', 'utf-8');
        $table_data .= '<th>' . $title . '</th>';
    }
    $table_data .= '</tr>';
    foreach ($data as $line){

        $table_data .= '<tr>';
        foreach ($line as $key => &$item){

            $item = mb_convert_encoding($item, 'gbk', 'utf-8');
            $table_data .= '<td>' . $item . '</td>';
        }
        $table_data .= '</tr>';
    }
    $table_data .='</table>';
    echo $table_data;
    die();
}

/*
 * JS标签路径
 *
 * @param  type:path		$path    路径
 * @param  type:string	$data 	参数
 * @param  type:url		$url 	参数
 * @return path/url
 */
function app_url($path,$param="",$url=""){
    if(C("URL_TYPE")){
        return '/'.ITEM.$path.'/'.join('/',explode(',',$param));
    }else{
        return '/'.ITEM.$path.$param;
    }
}

/*
 * JQ标签路径
 *
 * @param  type:path		$path    路径
 * @return path
 */
function jq($path){
    return JQUERY_PATH.$path;
}

/*
 * 编辑器标签路径
 *
 * @param  type:path		$path    路径
 * @return path
 */
function editer($path){
    return EDITER_PATH.$path;
}

/*
 * skin标签路径
 *
 * @param  type:path		$path    路径
 * @return path
 */
function skin($path){
    return SKIN_PATH.$path;
}

/*
 * fms标签路径
 *
 * @param  type:path		$path    路径
 * @return path
 */
function fms($path){
    return PUBLIC_PATH.'filesmanager/'.$path;
}

//字符串的无乱码截取
function sub($str, $len)
{
    $string = '';
    $len = $len * 3;
    for ($i = 0; $i < $len; $i++) {
        if (ord(substr($str, $i, 1)) > 0xa0) {
            $string .= substr($str, $i, 3);    //默认采用utf编码，汉字3个字节
            $i = $i + 2;
        } else {
            $string .= substr($str, $i, 1);
        }
    }
    return $string;
}

/*
生成xls
*/
function export2csv($path, $data, $header=null)
{
    if(file_exists($path)) @unlink($path);
    if(!is_array($data)) return;

    $handle = fopen($path, 'w');

    if(is_array($header))
    {
        $keys = array_keys($header);
        $data = array_merge(array($header), $data);
    }
    else
    {
        $keys = array_keys($data[0]);
    }

    foreach($data as $row)
    {
        $rowText='';
        foreach($keys as $key)
        {
            $rowText .= "\t" . $row[$key];
        }

        $rowText = ltrim($rowText, "\t");
        if(!empty($rowText))
            fwrite($handle, $rowText . "\r\n");
    }
    fclose($handle);
}
?>