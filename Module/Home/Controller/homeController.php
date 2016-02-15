<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio
 *******************************************************************/
// 首页

namespace Home\Controller;

use Lib\Lib as Lib;

class homeController extends controlController
{

    /**
     * 重定义构造器
     *
     * @param string $message
     * @param int $code
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 首页
     *
     * @return html
     */
    public function index()
    {
        $this->display('index.html');
    }
}