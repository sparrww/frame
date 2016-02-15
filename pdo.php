<?php
/**
 * MySQL操作类
 * 日期：2015-04-01
 */
class mysql
{
    public $pdo = null;
    public $results = null;

    public function find($sql, $array=array())
    {
        $ok = $this->_process($sql, $array);
        if ($ok)
        {
            $this->results->setFetchMode(PDO::FETCH_ASSOC);
            $data = $this->results->fetch();
            return $data;
        }
        else
        {
            return false;
        }
    }

    public function finds($sql, $array=array())
    {
        $ok = $this->_process($sql, $array);
        if ($ok)
        {
            $this->results->setFetchMode(PDO::FETCH_ASSOC);
            $data = $this->results->fetchAll();
            return $data;
        }
        else
        {
            return array();
        }
    }

    public function update($sql, $array=array())
    {
        $ok = $this->_process($sql, $array);
        if ($ok === false)
            return -1;//执行出错返回-1
        else if ($ok)
            return $this->results->rowCount();
        else
            return 0;
    }

    public function insert($sql, $array=array())
    {
        $ok = $this->_process($sql, $array);
        if ($ok)
        {
            $id = $this->pdo->lastInsertId();
            $id = $id ? $id : 1;
            return $id;
        }
        else
        {
            return false;
        }
    }

    public function delete($sql, $array=array())
    {
        $ok = $this->_process($sql, $array);
        if ($ok === false)
            return -1;//执行出错返回-1
        else if ($ok)
            return $this->results->rowCount();
        else
            return 0;
    }

    public function query($sql, $array=array())
    {
        return $this->_process($sql, $array);
    }

    private function _process($sql, $array)
    {
        if (is_null($this->pdo)){
            $params = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//            PDO::ATTR_ERRMODE: 错误提示 .
//            PDO::ERRMODE_SILENT: 不显示错误信息，只显示错误码 .
//            PDO::ERRMODE_WARNING: 显示警告错误 .
//            PDO::ERRMODE_EXCEPTION: 抛出异常 .
                PDO::ATTR_PERSISTENT => true
            );
            try {
                $this->pdo = new PDO('mysql:host=127.0.0.1;dbname=dedecmsv57utf8sp1;port=3306;', 'root', 'root', $params);
            } catch (PDOException $error)
            {
                throw $error;
//            final function getMessage(); // 返回异常信息
//            final function getCode(); // 返回异常代码
//            final function getFile(); // 返回发生异常的文件名
//            final function getLine(); // 返回发生异常的代码行号
//            final function getTrace(); // backtrace() 数组
//            final function getTraceAsString(); // 已格成化成字符串的 getTrace() 信息
            }
        }
        try
        {
            $this->results = $this->pdo->prepare($sql);
            return $this->results->execute($array);
        }
        catch (PDOException $error)
        {
            die(__CLASS__ . ": [{$error->getCode()}]: {$error->getMessage()}\n");
        }
    }
}
$m = new mysql();
var_dump($m->finds('select * from dede_admintype'));