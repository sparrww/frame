<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio
 *******************************************************************/
// 订单查询
namespace Admin\Model;

use Lib\Model as Model, Lib\Lib as Lib;

class orderModel extends Model
{


    /**
     * 获取单条订单
     *
     * @return array
     */
    public function getOne($id, $field = '*')
    {

        $sql = <<<EOT
		select a.$field,b.price,c.name,c.id columns_id,d.member_tel,d.member_card,d.member_medical_card,e.payment_name from @_order a left join @_article b on a.aid=b.id left join @_columns c on b.columnsid=c.id left join @_member d on a.buyer_id=d.member_id left join @_payment e on a.payment_id=e.payment_id where a.id=:id
EOT;

        $re = $this->prepare($sql);

        $re->id = $id;

        $data = $re->execute()->fetch();

        return $data;
    }

    /**
     * 获取订单信息
     *
     * @return array
     */
    public function getAll($field = '*',$page=10)
    {

        $sql = <<<EOT
		select a.$field from @_order a order by id desc
EOT;

        $count = $this->prepare("select COUNT(distinct a.id) num from @_order a")->execute()->count('num');

        $data = $this->sqlpage($sql, [], $count,$page);

        return $data;
    }


    /**
     * 根据日期,医生获取订单信息
     *
     * @return array
     */
    public function getAllByDate($aid, $date, $status = '1,2', $field = '*')
    {

        $sql = <<<EOT
		select a.$field from @_order a where aid in ($aid) and  a_date in ($date) and order_status in ($status) order by id desc
EOT;

        $re = $this->prepare($sql);

        $data = $re->execute()->fetchAll();

        return $data;
    }

    /**
     * 根据日期,用户获取订单信息
     *
     * @return array
     */
    public function getAllByMember($buyer_id, $date, $status = '1,2', $field = '*')
    {

        $sql = <<<EOT
		select a.$field from @_order a where buyer_id in ($buyer_id) and  a_date in ($date) and order_status in ($status) order by id desc
EOT;

        $re = $this->prepare($sql);

        $data = $re->execute()->fetchAll();

        return $data;
    }

    /**
     * 根据状态,用户获取订单信息
     *
     * @return array
     */
    public function getAllByStatus($buyer_id, $status = '3', $date = '',$page=20)
    {

        if($date)
            $sql = <<<EOT
		select a.*,b.price,c.name from @_order a left join @_article b on a.aid=b.id left join @_columns c on b.columnsid=c.id where a.buyer_id in ($buyer_id) and a.a_date in ($date) a.order_status in ($status) order by a.id desc
EOT;
        else
            $sql = <<<EOT
		select a.*,b.price,c.name from @_order a left join @_article b on a.aid=b.id left join @_columns c on b.columnsid=c.id where a.buyer_id in ($buyer_id) and a.order_status in ($status) order by a.id desc
EOT;
        $re = $this->prepare($sql);

        $data = $re->execute()->fetchAll();

        return $this->sqlPage($sql,[],count($data),$page);

    }

    /**
     * 获取科室下所有医生预约数目
     *
     * $aid_str 医生id
     * $today 今天
     * $end_day 结束天
     */
    public function getArtOrderCount($aid_str, $today, $end_day, $status = '1,2')
    {
        $sql = <<<EOT
		select count(a.id) num from @_order a where aid in ($aid_str) and a_date between $today and $end_day and order_status in ($status);
EOT;

        $re = $this->prepare($sql);

        $data = $re->execute()->fetch();

        return $data;
    }


    /**
     * 生成订单
     *
     * @return array
     */

    public function makeOrder($array = [], $id = "")
    {

        $member = Lib::getinstance()->A('Admin\Model\member', Null, 'Model');

        $this->beginTransaction();

        $mem_data = $member->save($array, $id);
        $order_data = $this->save($array);
        if (!$mem_data || !$order_data) {

            $this->rollback();

            return false;

        }

        $this->commit();
        return $order_data;
    }

    /**
     * 保存订单
     *
     * @return array
     */
    public function save($array = [], $id = "")
    {
        if (!$id) {
            $sql = <<<EOT
		insert into `@_order` (`order_sn`,`aid`,`a_name`,`a_date`,`buyer_id`,`buyer_name`,`add_time`,`order_amount`,`order_status`,`reservation_code`) values
		(:order_sn,:aid,:a_name,:a_date,:buyer_id,:buyer_name,:add_time,:order_amount,:order_status,:reservation_code)
EOT;

            $re = $this->prepare($sql);

            $re->order_sn = $this->makeOrderSn($_SESSION['member_id']);
            $re->aid = $array['aid'];
            $re->a_name = $array['a_name'];
            $re->a_date = $array['a_date'];
            $re->buyer_id = $array['buyer_id'];
            $re->buyer_name = $array['buyer_name'];
            $re->add_time = $array['add_time'];
            $re->order_amount = $array['order_amount'];
            $re->order_status = $array['order_status'];
            $re->reservation_code = $array['reservation_code'];

            return $re->execute()->lastinsertid();
        } else {

            $sql = <<<EOT
		update `@_order` set
			order_status    =   :order_status
			where id	=	$id
EOT;
            $re = $this->prepare($sql);
            $re->order_status = $array['order_status'];
            return $re->execute();
        }
    }


    /**
     *更改单个字段信息
     */
    public function editOneField($key,$value,$id) {
        $sql = <<<EOT
		update `@_order` set
            $key        =   :value
			where id	=	:id
EOT;
        $re = $this->prepare($sql);
        $re->id = $id;
        $re->value = $value;
        return $re->execute();
    }


    /**
     *删除订单
     */
    public function orderDel($classid)
    {

        $sql = "delete from `@_order` where id in (" . $classid . ")";

        return $this->prepare($sql)->execute();
    }

    /**
     * 生成支付单编号(两位随机 + 从2000-01-01 00:00:00 到现在的秒数+微秒+会员ID%1000)，该值会传给第三方支付接口
     * 长度 =2位 + 10位 + 3位 + 3位  = 18位
     * 1000个会员同一微秒提订单，重复机率为1/100
     * @return string
     */
    public function makeOrderSn($member_id) {
        return mt_rand(10,99)
        . sprintf('%010d',time() - 946656000)
        . sprintf('%03d', (float) microtime() * 1000)
        . sprintf('%03d', (int) $member_id % 1000);
    }

    /**
     * 提交订单信息到微信
     */
    public function sendWxPay($array) {
        $sql = <<<EOT
		update `@_order` set
			payment_id      =   6,
			payment_time    =   :payment_time,
			where id	    =	:id
EOT;
        $re = $this->prepare($sql);
        $re->payment_time = time();
        $re->id = $array['order_id'];
        $re->execute();

        require_once(EXPAND_PATH.'wx_pay/example/phpqrcode/jsapi.php');
        $data['description']   = $array['描述'];
        $data['order_sn']      = $array['订单号'];
        $data['order_amount']  = $array['总金额'];
        $data['notify_url']    = $array['回调地址'];
        return $this->sendWxPay($data);
    }
    /**
     * 异步回调处理
     */
    public function notifyUrl() {
        require_once(EXPAND_PATH.'wx_pay/example/phpqrcode/notify.php');
    }

    /**
     * 异步回调成功后更改状态
     */
    public function notifyHandle($array) {
        $order_sn = $array['out_trade_no'];
        $sql = <<<EOT
		update `@_order` set
			order_status    =   2,
			finished_time   =   :finished_time,
			where order_sn	=	:order_sn
EOT;
        $re = $this->prepare($sql);
        $re->finished_time = time();
        $re->order_sn = $order_sn;
        $re->execute();
    }
}

?>