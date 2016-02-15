<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio
 *******************************************************************/
// 首页
namespace Admin\Model;

use Lib\Model as Model;

class articleModel extends Model
{


    /**
     * 获取单个文章
     *
     * @return array
     */
    public function getOne($id, $field = "")
    {

        $sql = <<<EOT
		select a.*,b.content,c.name columns_name,c.module from @_article a
		left join @_article_detailed b on a.id=b.aid
		left join xy_columns c on a.columnsid=c.id
		where a.id=:id;
EOT;
        $re = $this->prepare($sql);

        $this->id = $id;

        $data = $re->execute()->fetch();

        if ($field) {
            return $data[$field];
        } else {
            return $data;
        }
    }


    /**
     * 获取栏目文章
     *
     * @return array
     */
    public function getAll($classid='',$field='*'){

        $sql = <<<EOT
		select a.$field from @_article a where columnsid in ($classid) order by id desc
EOT;

        $re = $this->prepare($sql);

        $re->classid = $classid;

        return $re->execute()->fetchAll();
    }

    /**
    更新文章栏目id
     **/
    function gxColumnsId(){
        $sql = <<<aaa
        select * from xy_columns
aaa;
        $date = $this->prepare($sql)->execute()->fetchAll();
        foreach($date as $v){
            $id = $v['id'];
            if($v['columnsid']!=0) continue;
            $name = $v['module'];
            $sql = <<<AAA
            update xy_article set columnsid=$id where module_name='$name'
AAA;

            $aa = $this->prepare($sql)->execute();
            if(!$aa) die('!!!');
        }
        echo 'OK';exit;
    }

    /**
     * 替换内容
     *
     * @return array
     */
    public function repContent($field,$title,$rep){

        $sql = <<<ETO
update xy_article_detailed set $field =
concat(
SUBSTRING($field ,1,position('$title' in $field )-1),
'$rep' ,
substring($field ,position('$title' in $field )+char_length('$title'))) where $field like '%$title%'
ETO;

        $re = $this->prepare($sql);

        return $re->execute();

    }


    /**
     * 文章分页
     * @program $classid int
     * @return int
     */
    public function getPage($classid, $field = "", $title = "",$page)
    {

        $f = '`a`.*,`c`.name as columns_name';

            $w = (($field || $title) ? "a." . $field . " like '%" . $title . "%' and a.columnsid = c.id" : "a.columnsid = c.id and a.columnsid in ($classid)");

            $t = "`@_article` as a,`@_columns` as c";

            $count = $this->prepare("select COUNT(a.id) as num from {$t} where {$w}")->execute()->count('num');

            $data = $this->sqlpage("select {$f} from {$t} where {$w} group by a.id desc", [], $count,$page);//$this->prepare($sql)->execute()->count());

            return $data;

    }

    /**
     * 未审核文章分页
     * @program $classid int
     * @return int
     */
    public function ShgetPage($classid, $field = "", $title = "")
    {

        $f = '`a`.*,`c`.name as columns_name';

        if ($field || $title) {
            $w = <<<EOT
		    (a.$field like '%$title%' and (status=0 or status=2)) or (a.$field like '%$title%' and status_type=1)
EOT;
        } else {
            $w = <<<EOT
            (a.columnsid = c.id and a.columnsid in ($classid) and (status=0 or status=2)) or (a.columnsid = c.id and a.columnsid in ($classid) and status_type=1)
EOT;
        }

        $t = "`@_article` as a,`@_columns` as c";

        $data = $this->sqlpage("select {$f} from {$t} where {$w} group by a.id desc", [], $this->prepare("select COUNT(distinct a.title) as num from {$t} where {$w}")->execute()->count('num'));//$this->prepare($sql)->execute()->count());

        return $data;
    }

    /**
     * 保存文章
     *
     * @return array
     */
    public function save(Array $array, $id = "")
    {

        if (!$id) {

            $sql = <<<EOT
		insert into `@_article` set
		    columnsid	=	:columnsid,
			attrib_j 	=	:attrib_j,
			attrib_g 	=	:attrib_g,
			attrib_t 	=	:attrib_t,
			attrib_r	=	:attrib_r,
			attrib_d 	=	:attrib_d,
			attrib_h 	=	:attrib_h,
			title 		=	:title,
			origin		=	:origin,
			tags 		=	:tags,
			info 		=	:info,
			img 		=	:img,
			img2 		=	:img2,
			html 		=	:html,
			academic_title 		=	:academic_title,
            honours     =	:honours,
			adept 		=	:adept,
			status      =   :status,
			time 		=	:time
EOT;
        } else {

            $sql = <<<EOT
		update `@_article` set
			columnsid	=	:columnsid,
			attrib_j 	=	:attrib_j,
			attrib_g 	=	:attrib_g,
			attrib_t 	=	:attrib_t,
			attrib_r	=	:attrib_r,
			attrib_d 	=	:attrib_d,
			attrib_h 	=	:attrib_h,
			title 		=	:title,
			origin		=	:origin,
			tags 		=	:tags,
			info 		=	:info,
			img 		=	:img,
			img2 		=	:img2,
			html 		=	:html,
			academic_title 		=	:academic_title,
            honours     =	:honours,
			adept 		=	:adept,
			status      =   :status,
			time 		=	:time
			where id	=	$id
EOT;
        }


        $re = $this->prepare($sql);

        $re->columnsid = $array['columnsid'];
        $re->attrib_j = $array['attrib_j'] ? 1 : 0;
        $re->attrib_g = $array['attrib_g'] ? 1 : 0;
        $re->attrib_t = $array['attrib_t'] ? 1 : 0;
        $re->attrib_r = $array['attrib_r'] ? 1 : 0;
        $re->attrib_d = $array['attrib_d'] ? 1 : 0;
        $re->attrib_h = $array['attrib_h'] ? 1 : 0;
        $re->title = $array['title'];
        $re->origin = $array['origin'];
        $re->tags = $array['tags'];
        $re->info = $array['info'];
        $re->html = $array['html'];
        $re->img = $array['img'];
        $re->img2 = $array['img2'];
        $re->academic_title = $array['academic_title'];
        $re->honours = $array['honours'];
        $re->adept = $array['adept'];
        $re->status = $array['status'];
        $re->time = time();

        if(!$id)  $data = $re->execute()->lastinsertid();
        else $data = $re->execute();
        if ($data) {
            if (!$id) {
                $sql = <<<EOT
                insert into @_article_detailed (aid,content) value (:aid,:content);
EOT;
                $re = $this->prepare($sql);
                $re->content = $array['content'];
                $re->aid = $data;
            } else {
                $sql = <<<EOT
                update @_article_detailed set
                    content     = :content
                    where aid   = $id
EOT;
                $re = $this->prepare($sql);
                $re->content = $array['content'];
            }
            return $re->execute();
        }
    }


    /**
     * ajax判断
     *
     * @return array
     */
    public function ajaxTitle($key,$value)
    {

        $sql = <<<EOT
		select * from xy_article where $key=:value
EOT;

        $re = $this->prepare($sql);

        $this->value = $value;

        return $re->execute()->fetch();
    }


    /**
     * ajax更新
     *
     * @return array
     */
    public function ajaxChange($field,$value,$id)
    {

        $sql = <<<EOT
            update @_article set
                $field     = $value
                where id   = $id
EOT;
        $re = $this->prepare($sql);
        return $re->execute();

    }

    /**
     * 删除文章
     *
     * @return array
     */
    public function delete($w, $field = 'id')
    {

        $sql = "delete from `@_article` where " . $field . " in ($w)";

        $re = $this->prepare($sql)->execute();

        if($field) $id='aid';

        $sql = "delete from `@_article_detailed` where " . $id . " in ($w)";
        return $this->prepare($sql)->execute();

    }

    /**
     * 审核
     * @program $classid int
     * @return int
     */
    public function aprrove($attrib, $id, $int)
    {

        $sql = <<<EOT
		update `@_article` set
			$attrib		=  $int,
			status_type =  1
			where id 	=  $id
EOT;
        return $this->prepare($sql)
            ->execute();
    }

    /**
     * 属性设置
     * @program $classid int
     * @return int
     */
    public function attrib($attrib, $id, $int)
    {

        $sql = <<<EOT
		update `@_article` set
			$attrib		=  $int
			where id 	=  $id
EOT;

        return $this->prepare($sql)
            ->execute();
    }

    /**
     * 记录转移
     * @program $classid int
     * @return int
     */
    public function move($data, $classid)
    {

        $sql = "
		update `@_article` set
			columnsid	=  $classid
			where id 	in (" . implode(',', $data) . ")";

        $re = $this->prepare($sql)
            ->execute();
        return $re;
    }
}

?>