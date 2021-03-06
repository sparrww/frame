<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
// 加载

defined('TPL_INCLUDE') or die( 'Restricted access'); 

if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

/*------------------ 系统配置 ------------------*/

	// 项目版本
	define('VERSION', '2.0');
	define('APP_DEBUG', true);


	// 系统定义
	const CONTROLLER 			=   'Controller';	//控制器名称
	const MODEL					=   'Model';		//模型名称
	const EXPAND 				=	'Expand';		//扩展封装名称

	// 选择DEBUG模式
	if (defined('APP_DEBUG')) {
		error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING); 
	    ini_set("display_errors", 1);
	} else {
	    error_reporting(0);
	    ini_set("display_errors", 0);
	}

	// 设置程序运行时间
	ini_set('max_execution_time','0');
	//独立内存使用量
	ini_set("memory_limit","128M");
	// 设置页面时间
	set_time_limit(0);
	// 设置时区
	date_default_timezone_set("PRC");
	// 设置编码
	header("Content-Type:text/html;charset=UTF-8");
	// 脚本开始时间
	define('__BEGIN__', microtime(true));



	if(explode('?',$_SERVER['REQUEST_URI'])[1]==""){
		$array=explode("/",$_SERVER['PATH_INFO']);
		if(isset($array[1])){
			$item = $array[1];
		}else{
			$item = 'Home';
		}
	}else{
        $GLOBALS['get'] = $_GET;
        $item = 'Home';
    }
	define('ITEM',$item);

/*------------------ 路径定义 ------------------*/

	// 系统路径定义
	defined('SYSTEM_PATH')			or define('SYSTEM_PATH',__DIR__);
	defined('SYSTEM_LIB_PATH')		or define('SYSTEM_LIB_PATH',SYSTEM_PATH.'/Lib');
	defined('SYSTEM_COMMON_PATH')	or define('SYSTEM_COMMON_PATH',SYSTEM_PATH.'/Common');
	defined('SYSTEM_DRIVER_PATH')	or define('SYSTEM_DRIVER_PATH',SYSTEM_PATH.'/Driver');
	defined('CONFIG_PATH')			or define('CONFIG_PATH',ROOT_PATH.'/Config');
	defined('MODULE_PATH')			or define('MODULE_PATH',ROOT_PATH.'/Module');
    defined('UPLOAD_PATH')			or define('UPLOAD_PATH',ROOT_PATH.'/Upload');

	// 应用路径
    defined('ITEM_PATH')			or define('ITEM_PATH',MODULE_PATH.'/'.ITEM);
	defined('CONTROLLER_PATH') 		or define('CONTROLLER_PATH',ITEM_PATH.'/Controller');
	defined('MODEL_PATH')			or define('MODEL_PATH',ITEM_PATH.'/Model');
	defined('EXPAND_PATH')			or define('EXPAND_PATH',ITEM_PATH.'/Expand');
	defined('VIEW_PATH')			or define('VIEW_PATH',ITEM_PATH.'/View');
	defined('DATA_PATH')			or define('DATA_PATH',ITEM_PATH.'/Data');
	defined('CACHE_DATA_PATH')		or define('CACHE_DATA_PATH',DATA_PATH.'/Data');
	defined('CACHE_VIEW_PATH')		or define('CACHE_VIEW_PATH',DATA_PATH.'/Compile');
	defined('ERROR_PATH')			or define('ERROR_PATH',DATA_PATH.'/Error');
	defined('LOG_PATH')				or define('LOG_PATH',ERROR_PATH.'/logs');


	// 定义公用路径
	define('PUBLIC_PATH','/Public/');

	define('PCOMMON_PATH',PUBLIC_PATH.'Common/');
	define('JQUERY_PATH',PCOMMON_PATH.'Jquery/');
	define('EDITER_PATH',PCOMMON_PATH.'Editer/');

	define('SKIN_PATH',PUBLIC_PATH.ITEM.'/');
	
/*------------------ 加载库 ------------------*/

// 加载函数
include_once SYSTEM_COMMON_PATH.'/Function.php';

// 加载应用函数库
//import('App.common.*');

import('Lib.*');

Lib\Lib::getinstance()->run();

?>