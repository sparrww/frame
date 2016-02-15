<?php
/*******************************************************************
 * @authors FengCms
 * @web     http://www.fengcms.com
 * @email   web@fengcms.com
 * @date    2013-10-30 16:00:12
 * @version FengCms Beta 1.0
 * @copy    Copyright © 2013-2018 Powered by DiFang Web Studio
 *******************************************************************/
namespace Admin\Controller;

use Lib\Controller as Controller, Lib\Lib as Lib;

class loginController extends Controller
{
    /**
     * 登录验证
     * @access public
     * @return json
     */
    public function index()
    {
        session_start();
        if($_SESSION['manage']){
            $this->message('',app_url('/home/index'));exit;
        }
        if ($this->post()) {
            if ($_POST['admincode'] == C('ADMIN_CODE')) {
                $model = lib::getinstance()->A('Admin\Model', Null, 'Model');
                $user = $this->post('user');
                $password = md5($this->post('password'));
                $datetime = date('Y-m-d H:i:s',time());
                $sql = "select * from @_manage where admin=:user and password=:password and status=1";
                $re = $model->prepare($sql);
                $re->user = $user;
                $re->password = $password;
                $result = $re->execute()->fetch();
                $manage_id = $result['id'];
                if ($result) {
                    $_SESSION['manage'] = $_POST['user'];
                    $_SESSION['power_id'] = $result['power_id'];
                    $base_arr = lib::getinstance()->A('Admin\Model\base', Null, 'Model')->getOne();
                    $power_arr = Lib::getinstance()->A('Admin\Model\power', Null, 'Model')->getOne($_SESSION['power_id']);
                    $_SESSION['power_name'] = $power_arr['name'];
                    $_SESSION['base_name'] = $base_arr['name'];
                    $sql = "update @_manage set datetime='$datetime' where id='$manage_id'";
                    $model->prepare($sql)->execute();
                    echo json_encode(array('status' => 'y'));
                    exit;
                } else {
                    echo json_encode(array('status' => 'n'));
                    exit;
                }
            } else {
                echo json_encode(array('status' => 'c'));
                exit;
            }
        }
        $this->display('login.html');
    }

}


?>