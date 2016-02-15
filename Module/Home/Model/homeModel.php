<?php
/*******************************************************************
 * @authors Air
 * @date    2014-09-06
 * @copy    Copyright © 2013-2018 Powered by Air Web Studio
 *******************************************************************/
// 首页
namespace Home\Model;

use Lib\Model as Model;

class homeModel extends Model
{

    public $num=1;
    public $arr=[];


    /**
     * 获取网站seo
     */
    public function getBase()
    {
        $sql = <<<EOT
		select * from xy_base;
EOT;

        $re = $this->prepare($sql);

        $data = $re->execute()->fetch();

        return $data;
    }

    /**
     * 获取网站友情链接
     */
    public function getLink()
    {
        $sql = <<<EOT
		select * from xy_friend_link order by sort asc;
EOT;

        $re = $this->prepare($sql);

        $data = $re->execute()->fetchAll();

        return $data;
    }

    /**
     * 获取导航
     */
    public function getColumns()
    {
        $sql = <<<EOT
		select * from `xy_columns` where nav=1 order by sort;
EOT;

        $re = $this->prepare($sql);

        $data = $re->execute()->fetchAll();

        return $data;
    }

    /**
     * 获取所有栏目列表
     */
    public function getColumnsAll($field='*')
    {
        $sql = <<<EOT
		select $field from `xy_columns`;
EOT;

        $re = $this->prepare($sql);

        $data = $re->execute()->fetchAll();

        return $data;
    }

    /**
     * 获取下级栏目列表
     */
    public function getColumnsList($classid,$limit='0,999')
    {
        $sql = <<<EOT
		select * from xy_columns where classid=:classid order by sort limit $limit
EOT;

        $re = $this->prepare($sql);
        $this->classid = $classid;
        $data = $re->execute()->fetchAll();

        return $data;
    }

    /**
     * 获取上级级栏目列表
     */
    public function getColumnsLast($classid,$field='*')
    {
        $sql = <<<EOT
		select $field from xy_columns where id=:classid
EOT;

        $re = $this->prepare($sql);
        $this->classid = $classid;
        $data = $re->execute()->fetch();

        return $data;
    }

    /**
     * 获取栏目层级
     *
     * @return array
     */
    public function columnsOption($classid=0){
        $sql = <<<EOT
		select * from `@_columns` where type='1'
EOT;
        $data =$this->prepare($sql)
            ->execute()
            ->fetchAll();
        return $this->classTree($data,$classid);
    }


    /**
     * @param $classid
     * @return null
     * 获取同级栏目
     */

    public function columnsPeer($classid){
        $sql = <<<EOT
		select * from `@_columns` where type='1' and classid=:classid
EOT;
        $data =$this->prepare($sql)
            ->execute([
                ':classid'=>$classid
            ])
            ->fetchAll();
        return $data;
    }


    /**
     * 遍历所有栏目
     *
     * @return array
     */
    public function classTree($data=[],$classid=0){
        $tree =[];
        foreach($data as $k => $v){
            if($v['classid'] == $classid){
                $v['class_list'] = $this->classTree($data, $v['id']);
                $tree[] = $v;
            }
        }
        return $tree;
    }

    /**
     * 获取栏目位置信息
     */
    public function getColumnsTop($classid)
    {
        $sql = <<<EOT
		select * from xy_columns where id=:classid
EOT;

        $re = $this->prepare($sql);
        $this->classid = $classid;
        $data = $re->execute()->fetch();
        if($data['classid']){
            $this->arr[$this->num]['template'] = $data['template'];
            $this->arr[$this->num]['name'] = $data['name'];
            $this->num++;
            $this->getColumnsTop($data['classid']);
        }else{
            $this->arr[$this->num]['template'] = $data['template'];
            $this->arr[$this->num]['name'] = $data['name'];
            $this->arr[$this->num]['module'] = $data['module'];
            return $this->arr;
        }
        return $this->arr;
    }


    /**
     * @param $id
     * @param string $field
     * @return null
     * 获取下级栏目
     */
    public function getColumnsClass($id,$field='*')
    {
        $sql = <<<EOT
		select $field from xy_columns where classid=:id
EOT;
        $re = $this->prepare($sql);
        $this->id = $id;
        return  $re->execute()->fetchAll();
    }


    /**
     * 根据字段获取单个栏目信息
     */
    public function getColumnOne($key,$value)
    {
        $sql = <<<EOT
        select * from `xy_columns` where $key=:value;
EOT;

        $re = $this->prepare($sql);

        $this->value = $value;

        $data = $re->execute()->fetch();

        return $data;
    }


    /**
     * 获取推荐
     */
    public function getArticleJ($field='*')
    {
        $sql = <<<EOT
        select $field from xy_article where attrib_j=1 and status=1 order by id desc;
EOT;

        $re = $this->prepare($sql);

        $data = $re->execute()->fetchAll();

        return $data;
    }

    /**
     * 获取幻灯
     */
    public function getArticleH($field='*')
    {
        $sql = <<<EOT
        select $field from xy_article where attrib_h=1 and status=1 order by id desc;
EOT;

        $re = $this->prepare($sql);

        $data = $re->execute()->fetchAll();

        return $data;
    }

    /**
     * 获取首页头条
     */
    public function getArticleT($field='*')
    {
        $sql = <<<EOT
        select $field from xy_article where attrib_t=1 and status=1 order by id desc;
EOT;

        $re = $this->prepare($sql);

        $data = $re->execute()->fetchAll();

        return $data;
    }


    /**
     * 获取下级栏目
     *
     * @return array
     */
    public function getAll($classid=0,$field='*'){

        $sql = <<<EOT
		select $field from `@_columns` where classid in ($classid) and type='1' order by sort asc
EOT;

        $re = $this->prepare($sql);

        return $re->execute()->fetchAll();
    }

    /**
     * 获取栏目层级
     *
     * @return array
     */
    public function getLevelId($classid){

        foreach($this->getAll($classid) as $k => $v){

            if($this->columnsClassCount($v['id'])>0){
                $string[] =$this->getLevelId($v['id']);
            }else{
                $string[] =$v['id'];
            }
        }
        return array_filter($string);
    }

    /**
     * 获取子栏目数
     * @program $classid int
     * @return int
     */
    private function columnsClassCount($classid){
        $sql = <<<EOT
		select COUNT(id) from `@_columns` where classid=:classid
EOT;

        $re = $this->prepare($sql);

        $re->classid = $classid;

        $row = $re->execute()->fetch();

        return $row['COUNT(id)'];
    }

    /**
     * 获取栏目下文章信息
     */
    public function getArticleList($id_str,$page=20,$showpage=6)
    {
        $sql = <<<EOT
        select a.*,b.name,b.template from xy_article a
        left join xy_columns b on a.columnsid=b.id
        where columnsid in ($id_str) and status=1
        order by sort desc,id desc
EOT;
        $count = $this->prepare(" select count(*) num from xy_article where columnsid in ($id_str)")->execute()->fetch();

        return  $this->sqlPage($sql,[],$count['num'],$page,$showpage);

    }

    /**
     * 修改文章点击
     */
    public function editHits($id,$hit)
    {
        $sql = <<<EOT
        update xy_article set hits=:hit where id=:id
EOT;
        $this->prepare($sql)->execute([':hit'=>$hit+1,':id'=>$id]);
    }

    /**
     * 获取栏目下热点文章
     */
    public function getArticleR($id_str,$page)
    {
        $sql = <<<EOT
        select a.*,b.name,b.template from xy_article a
        left join xy_columns b on a.columnsid=b.id
        where columnsid in ($id_str) and status=1
        order by a.attrib_r desc,a.sort desc,a.id desc
        limit 0,$page
EOT;
        return $this->prepare($sql)->execute()->fetchAll();

    }

    /**
     * 获取栏目下文章信息
     */
    public function getArticleList2($id_str)
    {
        $sql = <<<EOT
        select a.*,b.name,b.template from xy_article a
        left join xy_columns b on a.columnsid=b.id
        where columnsid in ($id_str) and status=1
        order by sort desc,id desc
EOT;
        return $this->prepare($sql)->execute()->fetchAll();

    }

    /**
     * 获取单个文章信息
     */
    public function getArticle($id)
    {
        $sql = <<<EOT
        select a.*,b.content from xy_article a
        left join xy_article_detailed b on a.id=b.aid
        where a.id=:id and a.status=1;
EOT;
        $re = $this->prepare($sql);

        $this->id = $id;

        $data = $re->execute()->fetch();


        $this->editHits($id,$data['hits']);

        return $data;
    }

    /**
     * 获取上一篇下一篇文章信息
     */
    public function getArticleTopDown($id,$column_id,$field='*')
    {
        $sql = <<<EOT
        select a.$field from xy_article a
        where a.id>$id and a.status=1 and a.columnsid=$column_id limit 0,1
EOT;
        $re = $this->prepare($sql);

        $data['top'] = $re->execute()->fetch();

        $sql2 = <<<EOT
        select a.$field from xy_article a
        where a.id<$id and a.status=1 and a.columnsid=$column_id order by id desc limit 0,1
EOT;
        $re = $this->prepare($sql2);

        $data['down'] = $re->execute()->fetch();

        return $data;
    }


    /**
     * 根据字段获取文章信息
     */
    public function getArticleByField($byte,$bytename,$limit='0,30',$field='*')
    {
        $sql = <<<EOT
        select a.$field from xy_article a where $byte like '%$bytename%' and status=1 limit $limit;
EOT;

        $re = $this->prepare($sql);


        $data = $re->execute()->fetchAll();

        return $data;
    }




}