<?php
/**
 * 抽象状态类
 */
abstract class State 
{
  public  abstract function Handle(Context $context);
  
}

/**
 * 具体状态类
 */
class Context 
{
  
  function __construct(State $state)
  {
     $this->state = $state;
  }

  public function __set($key='',$value='')
  {
     $this->$key=$value; 
  }

  public function _get($value='')
  {
     return $this->$value ;
  }

  public function request($value='')
  {
     $this->state->Handle($this);
  }
}

/**
 * 具体状态类
 */
class ConcreteStateA extends State
{
  
  function __construct()
  {
   
  }

  public function Handle(Context $context)
  {
    $context->state = new ConcreteStateB();
  }
}

die('状态模式');
/**
 * 观察者模式
 */
//Subject: 目标
abstract class Subject
{
    private $observers=[];
    public function Attach($observer){
        $this->observers[]=$observer;
    }
    public function Detach($observer){
        foreach ($this->observers as $value){
            if($value != $observer)
                $this->observers[] = $value;
        }
    }
    public function Notify(){
        foreach ($this->observers as $observer){
            $observer->Update();
        }
    }
}

//Observer: 观察者
abstract class Observer
{
    public abstract function Update();
}

//ConcreteSubject: 具体目标
class ConcreteSubject extends Subject
{
    public function __set($name, $value)
    {
        $this->$name=$value;
    }
    public function __get($name)
    {

        return $this->$name;
    }
}

//ConcreteObserver: 具体观察者
class ConcreteObserver extends Observer
{
    public function __construct($subject,$name){
        $this->subject=$subject;
        $this->name=$name;
    }
    public function __set($name, $value)
    {
        $this->$name=$value;
    }
    public function __get($name)
    {
        return $this->$name;
    }
    public function Update()
    {
        $this->observerState=$this->subject->SubjectState;
        var_dump('观察者'.$this->name.'的新状态是'.$this->observerState);
    }
}

$a=new ConcreteSubject();
$a->Attach(new ConcreteObserver($a,'X'));
$a->Attach(new ConcreteObserver($a,'Y'));
$a->Attach(new ConcreteObserver($a,'Z'));
$a->SubjectState='ABC';
$a->Notify();




die('观察者模式');
//原型类
abstract class Prototype
{
    public function __construct($id){
        $this->id=$id;
    }
    public function __get($name){
        return $this->$name;
    }
    public function __set($name, $value)
    {
        $this->$name=$value;
    }

    public abstract  function clone();
}

//具体原型类
class ConcretePrototype extends Prototype
{
    //返回自身
    public function clone()
    {
        return clone $this;//浅拷贝
    }
}

//测试浅拷贝
class DeepCopyDemo
{
    public $array;
}

$demo=new DeepCopyDemo();
$demo->array=array(1,2);
$obj1=new ConcretePrototype($demo);
$obj2=$obj1->clone();
var_dump($obj1);
var_dump($obj2);
$demo->array=array(3,5);
var_dump($obj1);
var_dump($obj2);

die('浅拷贝');
 function select_one($arr)
{
  $length = count($arr);
  for ($i=0; $i <$length ; $i++) { 
      $min = $i;
      for ($j=$i+1; $j <$length ; $j++) { 
          if ($arr[$min]>$arr[$j]) {
              $min = $j; 
          }
      }
    $temp = $arr[$i];
    $arr[$i] = $arr[$min];
    $arr[$min]=$temp;
  }
  return $arr;
}

print_r(select_one([1,21,11,6,97,0,22]));

die('直接选择排序');
/**
 * 递归了,快速排序
 * @param  [type] $arr [description]
 * @return [type]      [description]
 */
function quick_sort($arr){
    $length=count($arr);
    if($length<=1){
        return $arr;
    }
    $left=$right=array();
    //将$arr[0]作为基准值
    $pivot=$arr[0];
    for ($i=1; $i <$length ; $i++) {
        if($arr[$i]<$pivot){
            $left[]=$arr[$i];
        }else{
            $right[]=$arr[$i];
        }
    }
    return array_merge(quick_sort($left),(array)$pivot,quick_sort($right));
}

print_r(quick_sort([53,89,12,98,25,37,92,5]));

die('快速排序');
/**
 * 适配器模式  1.类的适配模式  2 对象的适配器模式 3接口的适配器模式
 */
class Source 
{
  
  function __construct()
  {
    
  }

  public function method1()
  {
     echo __METHOD__;
  }
}

interface Targetable{

    public function  method1();
    public function  method2();
    
}


/**
 * 
 */
class AdapterTest extends Source implements Targetable
{
  
  function __construct()
  {
   
  }

  public function method2()
  {
    echo __METHOD__;
  }
}

/**
 * 
 */
class Adapter extends Source implements Targetable
{
  
  private static $source;
  function __construct()
  {
    
  }




}

$test =  new AdapterTest();
$test->method1();
$test->method2();


die('类的适配器模式');
json_encode(['s'],JSON_UNESCAPED_SLASHES);
die('json测试');
include("/usr/local/var/www/gitdone/websocket/helpers.php");
include("/usr/local/var/www/gitdone/websocket/Config.php");
class Cache
{

    private static $handler = null;

    private static $_instance = null;

    private function __construct($host = '127.0.0.1', $port = 6379, $auth = '', $persistent = false)
    {
        $func = $persistent ? 'pconnect' : 'connect'; // 长链接
        self::$handler = new \Redis();
        self::$handler->$func($host, $port);
        
        if ('' != $auth) {
            self::$handler->auth($auth);
        }
        return self::$handler;
    }

    /**
     *
     * @return RedisPackage|null 对象
     */
    public static function getInstance($host = '127.0.0.1', $port = 6379, $auth = '', $persistent = false)
    {
        if (! (self::$_instance instanceof self)) {
            self::$_instance = new self($host, $port, $auth, $persistent);
        }
        return self::$handler;
    }

    /**
     * 禁止外部克隆
     */
    public function __clone()
    {
        trigger_error('Clone is not allow!', E_USER_ERROR);
    }
}

// $cache = Cache::getInstance();


var_dump(set_fid(set_sid(rand(1,90),1),1));

die('迭代器模式');
class MyIterator implements Iterator{
    
   private static $position;
   private static $data;
   function __construct($data)
   {
     if (!is_array($data) && count($data)<=0) {
        return '参数不是个数组或为空数组';
     }
     self::$data=$data;
     self::$position = 0 ;
   }

   public function rewind ()
   {
      self::$position = 0;
   }

    public function valid ()
   {
       return isset(self::$data[self::$position]);
   }
   /**
    * 必须实现
    */
   public function current()
   {
       return self::$data[self::$position];
   }

   public function key()
   {
       return self::$position;
   }

   public function next ()
   {
      ++self::$position;
   }
}

$it = new MyIterator(['s','t','fsf','p','o']);
foreach ($it as $key => $value) {
    var_dump($key, $value);
}

die('迭代器模式');
//观察者模式
//我的理解：将要修改的事件监听了，还缺一个触发器，再将要修改的东西发给各个类
//
abstract class EventGenerator{
    private $observers = array();
        function addObserver(Observer $observer){
        $this->observers[]=$observer;
    }
    function notify(){
        foreach ($this->observers as $observer){
            $observer->update();
        }
    }
}


interface Observer{
    function update();//这里就是在事件发生后要执行的逻辑
}
//一个实现了EventGenerator抽象类的类，用于具体定义某个发生的事件
//
class Event extends EventGenerator{
    function triger(){
        echo "Event<br>";
    }
}
class Observer1 implements Observer{
    function update(){
        echo "逻辑1<br>";
    }
}
class Observer2 implements Observer{
    function update(){
        echo "逻辑2<br>";
    }
}
$event = new Event();
$event->addObserver(new Observer1());
$event->addObserver(new Observer2());
$event->triger(); 
$event->notify();

die('观察者模式');
//单例模式

/**
 * 
 */
class SingleDog 
{
  private static $instance;
  function __construct()
  {
     echo "I`m ".__CLASS__;
  }
  
  /**
   * 查找
   * @return [type] [description]
   */
  public static function getInstance()
  {
     $res = self::$instance instanceof self;
     if (! self::$instance instanceof self) {
       return  self::$instance= new self(); 
     }
  }
}

$single = SingleDog::getInstance();

 
die;
/**
 *  工厂模式
 */
class People 
{
  private static $create;
  function __construct($class)
  {
    return  self::$create = new $class;
  }

 static public function getInstance($class)
  {
    if (!self::$create) {
          new self($class);
         var_dump(self::$create);
        return  self::$create;
    }
  }
}

 // var_dump($argc);

  $people = People::getInstance($argv[1]);
  $people->say();
 


 
 // $people = People::getInstance('Woman');
 //  $people->say();

 // var_dump();

/**
 * 
 */
class Man 
{
  
  function __construct()
  {
     echo "\nI`m man !\n";
  }

  public function say()
  {
     echo "I love you!!";
  }
}

class Woman
{
  
  function __construct()
  {

     echo "\n I`m ".__CLASS__." \n";
  }

  public function say()
  {
     echo "I love you too! !";
  }
}

die;
/**
 * @Author: smile
 * @Date:   2018-03-20 19:20:46
 * @Last Modified by:   smile
 * @Last Modified time: 2018-06-13 14:36:26
 */
/**
* ArrayAccess::offsetExists — 检查一个偏移位置是否存在
  ArrayAccess::offsetGet — 获取一个偏移位置的值
  ArrayAccess::offsetSet — 设置一个偏移位置的值
  ArrayAccess::offsetUnset — 复位一个偏移位置的值
*/
class Name implements ArrayAccess
{
	
    private static $name;
	function __construct()
	{
		self::$name = [

         'one'=>1,
         'two'=>2,
         'three'=>3
		];
	}

    public function offsetSet($offset, $value) {
    	echo "第一步\n";
        if (is_null($offset)) {
            self::$name[] = $value;
        } else {
            self::$name[$offset] = $value;
        }
    }
    public function offsetExists($offset) {
    	echo "第er步\n";
        return isset(self::$name[$offset]);
    }
    public function offsetUnset($offset) {
    	echo "第3步\n";
        unset(self::$name[$offset]);
    }
    public function offsetGet($offset) {
    	echo "第4步\n";
        return isset(self::$name[$offset]) ? self::$name[$offset] : null;
    }
}


$name = new Name;// 带括号不带括号的区别    构造函数有没有参数

// echo $name['one'];
$name->offsetSet('s','four'); 
echo $name->offsetGet('s');