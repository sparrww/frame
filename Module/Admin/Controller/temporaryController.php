<?php
namespace  Admin\Controller;

use Lib\Controller as Controller,Lib\Lib as Lib;

class temporaryController extends Controller
{

    public function __construct(){
        $this->m = Lib::getinstance()->A('Admin\Model\base',Null,'Model');
    }

    /**
     * 替换图片地址
     */
    function index(){
        $sql="select * from xy_article_detailed";
        $arr= $this->m->prepare($sql)->execute()->fetchAll();

        foreach($arr as $v){
            $content = $v['content'];
            $aid = $v['aid'];
            $str2 = preg_replace('/(src=\")[^\"]*?\/upload\/html\/\d+\/\d+\/\d+/i', "$1/Upload/backImage", $content);
            if($content!=$str2){
                $sql="update xy_article_detailed set content=:content where aid='$aid'";
                $this->m->prepare($sql)->execute([
                    ':content'=>$str2
                ]);
            }
        }
        echo 'ok';
    }
}
