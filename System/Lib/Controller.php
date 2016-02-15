<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio
 *******************************************************************/
//
namespace Lib;

use Lib\Template as Template;

class Controller{

	/**
	 * 模版方法
	 *
	 * @return string
	 */
    public function display($path,$array=[]){

		if(C('CACHE')){

            $ext=".php";

			$cfile=md5($_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);

			$file=CACHE_DATA_PATH.'/'.$cfile.$ext;

			if(file_exists($file) && (filemtime($path) < filemtime($file))){

				include $file;

			}else{
                ob_start();
                extract($array);
                include Template::tpl($path);

				if(!file_put_contents($file,ob_get_contents())){
					throwexce(sprintf('Cache file error, check the directory “%s” writable',CACHE_DATA_PATH));
				}
                ob_end_flush();
			}

		}else{

			extract($array);
			include Template::tpl($path);
		}
	}

    /**
     * 模版方法
     *
     * @return string
     */
    public function createHtml($path,$array=[],$path_arr=[],$file_name='index.html'){
        if(C('HTML')){
            $file_name?$file_name:$file_name='index.html';
            $create_class = Lib::getinstance()->A('Admin\Expand\CreateHtml',$path_arr,'Expand');
            $create_class->start();
            $this->display($path,$array);
            $create_class->end($file_name);
            $this->display($path,$array);
        }else{
            $this->display($path,$array);
        }

    }

	/**
	 * 验证码
	 *
	 * @return string
	 */
	public static function validate(){
		$_vc = new validatecode();		//实例化一个对象
		return $_vc->doimg();
	}

	/**
	 * 文件缓存
	 *
	 * @return string
	 */
	public function fcache($data,$op=false){
		if(!is_null($op)){
			if($op){
				return cache($this->cfile,$data);
			}else{
				return cache($this->cfile);
			}
		}else{
			return cache($this->cfile,null);
		}
	}

    public function post($param = "",$h=false){

		if(!empty($_POST)){
	    	if(is_array($param)){
	    		foreach ($param as $v) {
	    			if($_POST[$v]==""){
	    				return false;
	    			}
		    		if($h){
		    			$_POST[$v]=trim(filter_var($_POST[$v],FILTER_SANITIZE_MAGIC_QUOTES));
		    		}
	    		}
	    		return true;

	    	}elseif($param){

	    		if($h){
	    			$_POST[$param]=trim(filter_var($_POST[$param],FILTER_SANITIZE_STRING));
	    		}

	    		return trim($_POST[$param]);
	    	}
    		return $_POST;
		}else{
			return ;
		}
    }


    public function get($param = "",$h=false){

		if(!empty($_GET)){
	    	if(is_array($param)){
	    		foreach ($param as $v) {
	    			if($_GET[$v]==""){
	    				return false;
	    			}
		    		if($h){
		    			$_GET[$v]=trim(filter_var(urldecode($_GET[$v]),FILTER_SANITIZE_MAGIC_QUOTES));
		    		}
	    		}
	    		return true;

	    	}elseif($param){

	    		if($h){
	    			$_GET[$param]=trim(filter_var(urldecode($_GET[$param]),FILTER_SANITIZE_STRING));
	    		}

	    		return trim($_GET[$param]);
	    	}
    		return $_GET;
		}else{
			return ;
		}
    }

	/**
	 * 加密解密
	 * @access	public
	 * @param	$array		type:string
	 * @param	$operation	type:E(加密) | D(解密)
	 * @param	$key		type:string 密钥
	 * @return	array
	 */
	function encrypt($string,$operation='D',$key=''){
	    $key=md5($key);
	    $key_length=strlen($key);
        $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
	    $string_length=strlen($string);
	    $rndkey=$box=array();
	    $result='';
	    for($i=0;$i<=255;$i++){
	           $rndkey[$i]=ord($key[$i%$key_length]);
	        $box[$i]=$i;
	    }
	    for($j=$i=0;$i<256;$i++){
	        $j=($j+$box[$i]+$rndkey[$i])%256;
	        $tmp=$box[$i];
	        $box[$i]=$box[$j];
	        $box[$j]=$tmp;
	    }
	    for($a=$j=$i=0;$i<$string_length;$i++){
	        $a=($a+1)%256;
	        $j=($j+$box[$a])%256;
	        $tmp=$box[$a];
	        $box[$a]=$box[$j];
	        $box[$j]=$tmp;
	        $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
	    }
	    if($operation=='D'){
	        if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8)){
	            return substr($result,8);
	        }else{
	            return'';
	        }
	    }else{
	        return str_replace('=','',base64_encode($result));
	    }
	}

	/**
	 * 模拟POST提交
	 * @access	public
	 * @param	$url		type:url
	 * @param	$param		demo:a=123&b=456
	 * @return	array
	 */

	public function file_get_contents_post($url, $post) {
	    $options = array(
	        'http' => array(
	            'method' => 'POST',
	            // 'content' => 'name=caiknife&email=caiknife@gmail.com',
	            'content' => http_build_query($post),
	        ),
	    );

	    $result = file_get_contents($url, false, stream_context_create($options));

	    return $result;
	}


    public function curlSubmit($url,$data=[]) {
        //对空格进行转义
        $url = str_replace(' ','+',$url);
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_TIMEOUT,3); //定义超时3秒钟
        // POST数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));  //所需传的数组用http_bulid_query()函数处理
        //执行并获取url地址的内容
        $output = curl_exec($ch);
        $errorCode = curl_errno($ch);
        //释放curl句柄
        curl_close($ch);
        if(0 !== $errorCode) {
            return false;
        }
        return $output;
    }

	function curl_post($url, $post) {
	    $options = array(
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_HEADER         => false,
	        CURLOPT_POST           => true,
	        CURLOPT_POSTFIELDS     => $post,
	    );

	    $ch = curl_init($url);
	    curl_setopt_array($ch, $options);
	    $result = curl_exec($ch);
	    curl_close($ch);
	    return $result;
	}
	function message($string,$url=""){
		if($string){
			echo '<script type="text/javascript">alert("'.$string.'");</script>';
		}
		echo '<meta http-equiv="refresh" content="0;url='.$url.'">';
	}

    //字母表
    function getfirstchar($s0){
        $fchar = ord($s0{0});
        if($fchar >= ord("A") and $fchar <= ord("z") )return strtoupper($s0{0});
        $s1 = mb_convert_encoding($s0,"gbk","UTF-8");
        $s2 = mb_convert_encoding($s1,"UTF-8","gbk");
        if($s2 == $s0){$s = $s1;}else{$s = $s0;}
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if($asc >= -20319 and $asc <= -20284) return "A";
        if($asc >= -20283 and $asc <= -19776) return "B";
        if($asc >= -19775 and $asc <= -19219) return "C";
        if($asc >= -19218 and $asc <= -18711) return "D";
        if($asc >= -18710 and $asc <= -18527) return "E";
        if($asc >= -18526 and $asc <= -18240) return "F";
        if($asc >= -18239 and $asc <= -17760) return "G";
        if($asc >= -17759 and $asc <= -17248) return "H";
        if($asc >= -17247 and $asc <= -17418) return "I";
        if($asc >= -17417 and $asc <= -16475) return "J";
        if($asc >= -16474 and $asc <= -16213) return "K";
        if($asc >= -16212 and $asc <= -15641) return "L";
        if($asc >= -15640 and $asc <= -15166) return "M";
        if($asc >= -15165 and $asc <= -14923) return "N";
        if($asc >= -14922 and $asc <= -14915) return "O";
        if($asc >= -14914 and $asc <= -14631) return "P";
        if($asc >= -14630 and $asc <= -14150) return "Q";
        if($asc >= -14149 and $asc <= -14091) return "R";
        if($asc >= -14090 and $asc <= -13319) return "S";
        if($asc >= -13318 and $asc <= -12839) return "T";
        if($asc >= -12838 and $asc <= -12557) return "W";
        if($asc >= -12556 and $asc <= -11848) return "X";
        if($asc >= -11847 and $asc <= -11056) return "Y";
        if($asc >= -11055 and $asc <= -10247) return "Z";
        return null;
    }

    //汉字转拼音
    function pinyin($zh){
        $ret = "";
        $s1 = mb_convert_encoding($zh,"gbk","UTF-8");
        $s2 = mb_convert_encoding($s1,"UTF-8","gbk");
        if($s2 == $zh){$zh = $s1;}
        for($i = 0; $i < strlen($zh); $i++){
            $s1 = substr($zh,$i,1);
            $p = ord($s1);
            if($p > 160){
                $s2 = substr($zh,$i++,2);
                $ret .= $this->getfirstchar($s2);
            }else{
                $ret .= $s1;
            }
        }
        return strtoupper($ret);
    }

}

?>