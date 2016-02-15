<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio  
 *******************************************************************/
// 控制器

namespace  Home\Controller;

use Lib\Controller as Controller,Lib\Lib as Lib;
use Lib\Exceptions;
use Lib\Model;

class controlController extends Controller
{

    //private $smsUrl                 =  'UserName=%s&UserPass=%s&subid=%s&Mobile=%s&Content=%s';
    public $array;

    public function __construct()
    {
        $this->m = Lib::getinstance()->A('Home\Model\home',Null,'Model');
        $this->m_columns = Lib::getinstance()->A('Admin\Model\columns',Null,'Model');

        //获取路由
        $url_str = trim($_SERVER['REQUEST_URI'],'/');
        $this->array['url_arr'] = explode('/',$url_str);

}


    /**
     * 生成缓存文件
     */
    public function createCache(){

        $path_file = UPLOAD_PATH.'/cache/';
        $file_name = $path_file.date('Ymd', time()).'.txt';
        if(!file_exists($file_name))
        {

            foreach($data2 as $v){
                $pinyin = $this->pinyin($v['name']);
                $array['arr'][] = [$pinyin=>$v['name']];
            }
            $data3 = $this->m['columns']->getAllByField('module','ksys','id');
            $data4 = $this->m['article']->getAll(arrayToString($data3),'title');
            foreach($data4 as $v){
                $pinyin = $this->pinyin($v['title']);
                $array['arr'][] = [$pinyin=>$v['title']];
            }

            if (!file_exists($path_file)) {
                mkdirs($path_file);
            }
            $open = fopen($file_name, "a");
            fwrite($open, serialize($array));
            fclose($open);
        }else{
            return;
        }
    }

    public function smsSend(){

        if($this->post('phone')){
            $url        = C('SMS_URL');
            $user       = C('SMS_USER');
            $pass       = C('SMS_PASS');
            $subid      = C('SMS_SUBID');
            $phone      = $this->post('phone');
            $code       = rand(1000,9999);
            $message    = sprintf(C('SMS_MESSAGE'),$code);

            if($this->curlSubmit($url,sprintf($this->smsUrl,$user,$pass,$subid,$phone,$message))){

                $output = [
                    'status'    =>  'y',
                    'data'      =>  [
                        'message'   =>  '发送成功'
                    ]
                ];
                $_SESSION['code'] = $code;
                $_SESSION['code_time'] = time();
            }else{
                $output = [
                    'status'    =>  'n',
                    'message'   =>  '发送失败'
                ];
            }
        }else{
            $output = [
                'status'    =>  'n',
                'message'   =>  '电话号码不能为空'
            ];
        }
        exit(json_encode($output));
    }


    //获取微信openid
    private function getOpenid(){
        $code=substr($_SERVER['QUERY_STRING'],strpos($_SERVER['QUERY_STRING'],'=')+1,strpos($_SERVER['QUERY_STRING'],'&')-4);
        if(strlen($code)<20) die('请授权后在尝试');
        $weixin =  file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".C('APPID')."&secret=".C('SECRET')."&code=".$code."&grant_type=authorization_code");//通过code换取网页授权access_token
        $jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
        $array = get_object_vars($jsondecode);//转换成数组
        return $array['openid'];//输出openid
    }


    //是否微信浏览
    private function is_weixin(){
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            return true;
        }
        return false;
    }


    //是否手机浏览
    private function is_mobile_request()
    {
        $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
        $mobile_browser = '0';
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
            $mobile_browser++;
        if ((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') !== false))
            $mobile_browser++;
        if (isset($_SERVER['HTTP_X_WAP_PROFILE']))
            $mobile_browser++;
        if (isset($_SERVER['HTTP_PROFILE']))
            $mobile_browser++;
        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
            'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
            'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
            'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
            'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
            'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
            'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
            'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
            'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
            'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-'
        );
        if (in_array($mobile_ua, $mobile_agents))
            $mobile_browser++;
        if (strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)
            $mobile_browser++;
        // Pre-final check to reset everything if the user is on Windows
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)
            $mobile_browser = 0;
        // But WP7 is also Windows, with a slightly different characteristic
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)
            $mobile_browser++;
        if ($mobile_browser > 0)
            return true;
        else
            return false;
    }

}

?>