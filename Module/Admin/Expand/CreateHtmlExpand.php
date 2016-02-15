<?php
namespace Admin\Expand;
class CreateHtmlExpand
{

    /**
     * 构造函数
     */
    function __construct($array=[]) {

        $this->path  = $array[0];   //根目录
        $this->list1 = $array[1];   //一级目录
        $this->list2 = $array[2];   //二级目录
        $this->list3 = $array[3];   //三级目录

    }


    function mkCatalogue()
    {
        $p=DIRECTORY_SEPARATOR;
        if($this->list1 && $this->list2 && $this->list3){
            $filePath=$this->list1.$p.$this->list2.$p.$this->list3;
        }elseif($this->list1 && $this->list2){
            $filePath=$this->list1.$p.$this->list2;
        }elseif($this->list1){
        $filePath=$this->list1;
        }else{
            if(!$this->path){
                ob_end_clean();
                die('目录创建失败');
            }else{
                return $this->path.$p;
            }
        }
        $a=explode($p,$filePath);
        $this->path.=$p;
        foreach ( $a as $dir)
        {
            $this->path.=$dir.$p;
            if(!is_dir($this->path))
            {
                mkdir($this->path,0777);
            }
        }
        return $filePath.$p;
    }
    function start()
    {
        ob_start();
    }
    function end($fileName='index.html')
    {
        $path = $this->mkCatalogue();
        $info = ob_get_contents();
        $info = "\xEF\xBB\xBF".$info;
        $file=fopen($path.$fileName,'w+');
        fwrite($file,$info);
        fclose($file);
        ob_end_clean();
    }
}