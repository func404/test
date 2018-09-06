<?php

/**
 * @Author: Jingxinpo
 * @Date:   2018-08-06 11:12:13
 * @Last Modified by:   Jingxinpo
 * @Last Modified time: 2018-08-07 16:14:47
 */

class Mysql 
{
	
    private static $instance;
    public $dbms='mysql';     //数据库类型
    public $host='localhost'; //数据库主机名
    public $dbName='test';    //使用的数据库
    public $user='root';      //数据库连接用户名
    public $pass='';          //对应的密码

	function __construct($dbms='',$host='',$dbName='',$user='',$pass='')
	{  
		$dbms = empty($dbms)? $this->dbms : $dbms;
		$host = empty($host)?$this->host:$host;
		$dbName = empty($dbName)?$this->dbName:$dbName;
		$user = empty($user)?$this->user:$user;
		$pass = empty($pass)?$this->pass:$pass;
	    $dsn = "$dbms:host=$host;dbname=$dbName";
		self::$instance = new PDO($dsn, $user, $pass);

	}

	static public function getInstance($dbms='',$host='',$dbName='',$user='',$pass='')
	{
		if (!self::$instance) {
			self::$instance = new self($dbms,$host,$dbName,$user,$pass);
		}
	}

}

// $db = Mysql::getInstance();
function logger($fileName) {
    $fileHandle = fopen($fileName, 'a');
    while (true) {
        fwrite($fileHandle, yield . "\n");
    }
}
 

// Iterator 迭代器        Generator 生成器类//
/**
 * Generator::current  返回当前产生的值
 * Generator::key      返回当前产生的键
 * Generator::next     生成器继续执行
 * Generator::rewind   重置迭代器
 * Generator::send     向生成器中传入一个值
 * Generator::throw    向生成器中抛入一个异常
 * Generator::valid    检查迭代器是否被关闭
 * Generator::__wakeup 序列化回调
 *
 *
 * 那么这个跟yield有什么关系呢，这便是我们接下来要说的重点了。首先给大家介绍一下我总结出来的 yield 的特性,包含以下几点。
1.yield只能用于函数内部，在非函数内部运用会抛出错误。
2.如果函数包含了yield关键字的，那么函数执行后的返回值永远都是一个Generator对象。
3.如果函数内部同事包含yield和return 该函数的返回值依然是Generator对象，但是在生成Generator对象时，return语句后的代码被忽略。
4.Generator类实现了Iterator接口。
5.可以通过返回的Generator对象内部的方法，获取到函数内部yield后面表达式的值。
6.可以通过Generator的send方法给yield 关键字赋一个值。
7.一旦返回的Generator对象被遍历完成，便不能调用他的rewind方法来重置
8.Generator对象不能被clone关键字克隆
 */

// $logger = logger('./log');
// $logger->send('Foo');
// $logger->send('Bar');

function gen()
{
	$ret = (yield 'yield1');
     var_dump($ret);
    $ret = (yield  'yield2');
    $ret = yield 'yield3';
     var_dump($ret);
}
$gen = gen();
 // var_dump($gen->current());    // string(6) "yield1"
  var_dump($gen->send('ret1')); // string(4) "ret1"   (the first var_dump in gen)
                              // string(6) "yield2" (the var_dump of the ->send() return value)
// var_dump($gen->send('ret2')); // string(4) "ret2"   (again from within gen)