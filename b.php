<?php
if (function_exists("uploadprogress_get_info")) {
    $info = uploadprogress_get_info($_GET['progress_key']);
    if(!empty($info)){
        if(($info['bytes_uploaded'] < $info['bytes_total']) && !empty($info['bytes_uploaded']) && !empty($info['bytes_total'])){
            $proNum = floor(($info['bytes_uploaded']/$info['bytes_total'])*100);
        }else{
            $proNum = 100;
        }
        echo $proNum;
    }else{
        echo 0;
    }
}else{
    die('error');
}