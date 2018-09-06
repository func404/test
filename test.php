<?php
$string='helloworld!';
$time = test();
$str="This is a $string $time morning!";

function test()
{
  return date('Y-m-d');
}

$res= eval("return '$str';"); //把代码当成php代码来执行
echo $res;

die('eval');
assert_options(ASSERT_ACTIVE,1);
assert_options(ASSERT_WARNING, 0);
assert_options(ASSERT_QUIET_EVAL,1);

function my_assert_handler($file='test.php', $line='2', $code='fa')
{
    echo "<hr>Assertion Failed:File '$file'<br />Line '$line'<br />Code '$code'<br /><hr />";
}

 assert_options(ASSERT_CALLBACK, 'my_assert_handler');
// assert('1==2');
echo 555555555555; 
die('断言');
/**
 * 表示一个作用于某对象结构中的各元素的操作。它使你可以在不改变各元素的类的前提下定义作用于这些元素的新操作。
 */
abstract class Visitor {
    abstract public function visitConcreteElementA(ConcreteElementA $elementA);
    abstract public function visitConcreteElementB(concreteElementB $elementB);
}

abstract class Element
{
    abstract public function accept(Visitor $visitor);
}


//具体访问者角色(ConcreteVisitor)
class ConcreteVisitor1 extends Visitor {
    public function visitConcreteElementA(ConcreteElementA $elementA) {
        var_dump($elementA->getName() . " visited by ConcerteVisitor1");
    }
    public function visitConcreteElementB(ConcreteElementB $elementB) {
        var_dump($elementB->getName() . " visited by ConcerteVisitor1");
    }
}
class ConcreteVisitor2 extends Visitor {
    public function visitConcreteElementA(ConcreteElementA $elementA) {
        var_dump($elementA->getName() . " visited by ConcerteVisitor2");
    }
    public function visitConcreteElementB(ConcreteElementB $elementB) {
        var_dump($elementB->getName() . " visited by ConcerteVisitor2");
    }
}

//具体节点（Node）角色(ConcreteElement)
class ConcreteElementA extends Element {
    private $name;
    public function __construct($name) {
        $this->name = $name;
    }
    public function getName() {
        return $this->name;
    }
    public function accept(Visitor $visitor) {
        $visitor->visitConcreteElementA($this);
    }
}
class ConcreteElementB extends Element {
    private $name;
    public function __construct($name) {
        $this->name = $name;
    }
    public function getName() {
        return $this->name;
    }
    public function accept(Visitor $visitor) {
        $visitor->visitConcreteElementB($this);
    }
}

//对象结构角色(ObjectStructure)
class ObjectStructure {
    private $collection;
    public function __construct() {
        $this->collection = array();
    }
    public function attach(Element $element) {
        return array_push($this->collection, $element);
    }
    public function detach(Element $element) {
        $index = array_search($element, $this->collection);
        if ($index !== FALSE) {
            unset($this->collection[$index]);
        }
        return $index;
    }
    public function accept(Visitor $visitor) {
        foreach ($this->collection as $value) {
            $value->accept($visitor);
        }
    }
}

$elementA = new ConcreteElementA("ElementA");
$elementB = new ConcreteElementB("ElementB");
$elementA2 = new ConcreteElementB("ElementA2");
$visitor1 = new ConcreteVisitor1();
$visitor2 = new ConcreteVisitor2();

$os = new ObjectStructure();
$os->attach($elementA);
$os->attach($elementB);
$os->attach($elementA2);
$os->detach($elementA);
$os->accept($visitor1);
$os->accept($visitor2);

die('访问者模式');
/**
 * 给定一个语言，定义它的文法的一种表示，并定义一个解释器，这个解释器使用该表示来解释语言中的句子。
 */
abstract class AbstractExpression 
{
   abstract public function Interpret($context); //解释
}

//TerminalExpression:终结符表达式
class TerminalExpression extends AbstractExpression
{
    public function Interpret($context)
    {
        var_dump('终端解释器');
    }
}


//NonterminalExpression:非终结符表达式
class NonterminalExpression extends AbstractExpression
{
    public function Interpret($context)
    {
        var_dump('非终端解释器');
    }
}


//Context: 环境类
class Context
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


$context=new Context();
$lists[]=new TerminalExpression();
$lists[]=new NonterminalExpression();
$lists[]=new TerminalExpression();
$lists[]=new NonterminalExpression();     //解释器分段解释内容

foreach ($lists as $value){
    $value->Interpret($context);
}



die('解释器模式');
/**
 * 享元模式(Flyweight Pattern)：运用共享技术有效地支持大量细粒度对象的复用。系统只使用少量的对象，而这些对象都很相似，状态变化很小，可以实现对象的多次复用。由于享元模式要求能够共享的对象必须是细粒度对象，因此它又称为轻量级模式，它是一种对象结构型模式。
 */
abstract class Flyweight {
    abstract public function operation($state);
}

//具体享元角色
class ConcreteFlyweight extends Flyweight {
    private $state = null;
    public function __construct($state) {
        $this->state = $state;
    }
    public function operation($state) {
        var_dump('具体Flyweight:'.$state);
    }

}

//不共享的具体享元，客户端直接调用
class UnsharedConcreteFlyweight extends Flyweight {
    private $state = null;
    public function __construct($state) {
        $this->state = $state;
    }
    public function operation($state) {
        var_dump('不共享的具体Flyweight:'.$state);
    }
}

//享元工厂角色
class FlyweightFactory {
    private $flyweights;
    public function __construct() {
        $this->flyweights = array();
    }
    public function getFlyweigth($state) {
        if (isset($this->flyweights[$state])) {
            return $this->flyweights[$state];
        } else {
            return $this->flyweights[$state] = new ConcreteFlyweight($state);
        }
    }
}


$f = new FlyweightFactory();
$a = $f->getFlyweigth('state A');
$a->operation("other state A");

$b = $f->getFlyweigth('state B');
$b->operation('other state B');

/* 不共享的对象，单独调用 */
$u = new UnsharedConcreteFlyweight('state A');
$u->operation('other state A');
die('享元模式');
/**
 * 用一个中介对象来封装一系列的对象交互，中介者使各对象不需要显式地相互引用，从而使其耦合松散，而且可以独立地改变它们之间的交互。中介者模式又称为调停者模式，它是一种对象行为型模式
 */

//Mediator: 抽象中介者
abstract class Mediator
{
    abstract public function Send($message,$colleague);
}

//ConcreteMediator: 具体中介者
class ConcreteMediator extends Mediator
{
    public function __set($name, $value)
    {
        $this->$name=$value;
    }
    public function Send($message, $colleague)
    {
        if ($colleague==$this->colleague1){
            $this->colleague2->Notify($message);
        }else{
            $this->colleague1->Notify($message);
        }
    }
}


//Colleague: 抽象同事类
abstract class Colleague
{
    public function __construct($mediator)
    {
        $this->mediator=$mediator;
    }
}

//ConcreteColleague: 具体同事类
class ConcreteColleague1 extends Colleague
{
    public function Send($message){
        $this->mediator->Send($message,$this);
    }
    public function Notify($message){
        var_dump('1收到消息：'.$message);
    }
}
class ConcreteColleague2 extends Colleague
{
    public function Send($message){
        $this->mediator->Send($message,$this);
    }
    public function Notify($message){
        var_dump('2收到消息：'.$message);
    }
}

$concreteMediator = new ConcreteMediator;
$concreteMediator->colleague1 = new ConcreteColleague1($concreteMediator);
$concreteMediator->colleague2 = new ConcreteColleague2($concreteMediator);

$concreteMediator->Send('ConcreteColleague1 的任务',$concreteMediator->colleague1);
$concreteMediator->colleague2->Send('ConcreteColleague2 的任务');


die('中介者模式');
/**
 * 使多个对象都有机会处理请求，从而避免请求的发送者和接收者之间的耦合关系。将这个对象连成一条链，并沿着这条链传递该请求，直到有一个对象处理它为止。
 */

/**
 * //抽象处理者角色(Handler:Approver)
 */
abstract class Handler
{
  
    public function SetSuccessor(Handler $successor){
        $this->successor=$successor;
    }
    abstract public function HandleRequest($request);
}

/**
 * //具体处理者角色(ConcreteHandler:President)
 */
class ConcreteHandle1 extends Handler
{
  public function HandleRequest($request)
  {
       if($request>=0 && $request<10){
            var_dump(self::class.':'.$request);
        }elseif ($this->successor!=null){
            $this->successor->HandleRequest($request);
        }
    
  }
}

class ConcreteHandle2 extends Handler
{
    public function HandleRequest($request)
    {
        if($request>=10 && $request<20){
            var_dump(self::class.':'.$request);
        }elseif ($this->successor!=null){
            $this->successor->HandleRequest($request);
        }
    }
}
class ConcreteHandle3 extends Handler
{
    public function HandleRequest($request)
    {
        if($request>=20 && $request<30){
            var_dump(self::class.':'.$request);
        }elseif ($this->successor!=null){
            $this->successor->HandleRequest($request);
        }
    }
}

$h1=new ConcreteHandle1();
$h2=new ConcreteHandle2();
$h3=new ConcreteHandle3();

$h1->SetSuccessor($h2);
// $h2->SetSuccessor($h3);
$h1->HandleRequest(5);
$h1->HandleRequest(15);  //如果handel1处理不了，将任务转给handel2,如果handel2处理不了，将任务转给下一个处理这
// $h1->HandleRequest(25);


die('职责链模式');
/**
 * 命令模式(Command Pattern)：将一个请求封装为一个对象，从而使我们可用不同的请求对客户进行参数化；对请求排队或者记录请求日志，以及支持可撤销的操作。命令模式是一种对象行为型模式，其别名为动作(Action)模式或事务(Transaction)模式。
 */
/**
 * 抽象命令类
 */
abstract class Command 
{
  
  function __construct($receiver)
  {
    $this->receiver=$receiver;
  }

   abstract public function Execute();
}

/**
 * 
 */
class ConcreteCommand extends Command
{
  
  function __construct($receiver)
  {
    parent::__construct($receiver);
  }

   public function Execute(){
        $this->receiver->Action();
    }

}


//Invoker: 调用者
class Invoker
{
    public function SetCommand(Command $command){
        $this->command=$command;
    }
    public function ExecuteCommand(){
        $this->command->Execute();
    }
}



//Receiver: 接收者
class Receiver
{
    public function Action(){
        var_dump('执行请求');
    }
}


$invoker = new Invoker;
$invoker->SetCommand(new ConcreteCommand(new Receiver));
$invoker->ExecuteCommand();





die('命令模式');
/**
 * 桥接模式:将抽象部分与它的实现部分分离，使它们都可以独立地变化。它是一种对象结构型模式，又称为柄体(Handle and Body)模式或接口(Interface)模式。
 */

//Implementor：实现类接口
abstract class Implementor
{
    abstract public function Operation();
}

//ConcreteImplementor：具体实现类
class ConcreteImplementorA extends Implementor
{
    public function Operation(){
        var_dump('A的方法执行');
    }
}

class ConcreteImplementorB extends Implementor
{
    public function Operation(){
        var_dump('B的方法执行');
    }
}


//Abstraction：抽象类
abstract class Abstraction
{
    abstract public function Operation();
}


//RefinedAbstraction：扩充抽象类
class RefinedAbstraction extends Abstraction
{
    public function SetImplementor($implementor){
        $this->implementor=$implementor;
    }
    public function Operation(){
        $this->implementor->Operation();
    }
}


$a=new RefinedAbstraction();
$a->SetImplementor(new ConcreteImplementorA());
$a->Operation();
// $a->implementor->Operation();

$a->SetImplementor(new ConcreteImplementorB());
$a->Operation();

die('桥接模式');
/**
 * 迭代器模式: 提供一种方法顺序访问一个聚合对象中的各个元素，而不是暴露其内部的表示。
 */
//ConcreteIterator:具体迭代器
class ConcreteIterator implements Iterator
{
    private $_key;
    private $_array;
    public function __construct($array){
        $this->_array=$array;
        $this->_key=0;
    }
    public function rewind(){
        $this->_key=0;
    }
    public function valid(){
        return isset($this->_array[$this->_key]);
    }
    public function current(){
        return $this->_array[$this->_key];
    }
    public function key(){
        return $this->_key;
    }
    public function next(){
        return ++$this->_key;
    }
}


//ConcreteAggregate:具体聚合类
class ConcreteAggregate implements IteratorAggregate
{
    protected $_arr;
    public function __construct($array){
        $this->_arr = $array;
    }
    public function getIterator(){
        return new ConcreteIterator($this->_arr); //迭代器类型
    }
}



$arr = array(5,8,1,3,2);
$a=new ConcreteAggregate($arr);
$b=$a->getIterator();
var_dump($b);//迭代器对象
foreach($b as $key=>$value){
    var_dump($key.':'.$value.'<br/>') ;
}


die('迭代器模式');
/**
 * 组合模式，将对象组合成树形结构以表示“部分-整体”的层次结构，组合模式使得用户对单个对象和组合对象的使用具有一致性。掌握组合模式的重点是要理解清楚 “部分/整体” 还有 ”单个对象“ 与 “组合对象” 的含义。
 */

/**
 * 组合模式
 */
//组合中的对象声明接口
abstract class Component
{
    public function __construct($name)
    {
        $this->name=$name;
    }
    abstract public function Add(Component $c);
    abstract public function Remove(Component $c);
    abstract public function Display($depth);
}


//叶子对象
class Leaf extends Component
{
    public function Add(Component $c){
        var_dump('add');
    }
    public function Remove(Component $c){
        var_dump('Remove');
    }
    public function Display($depth){
        var_dump(str_repeat('-',$depth).$this->name);
    }
}


//容器对象
class Composite extends Component
{
    private $children=[];
    public function Add(Component $c){
        $this->children[]=$c;
    }
    public function Remove(Component $c){
        foreach ($this->children as $child){
            if ($child!= $c){
                $a[]=$child;
            }
        }
        $this->children=$a;
    }
    public function Display($depth){
        var_dump(str_repeat('-',$depth).$this->name);
        foreach ($this->children as $value){
            $value->Display($depth+2);
        }
    }
}


$root=new Composite('root');
$root->Add(new Leaf('Leaf A'));
$root->Add(new Leaf('Leaf B'));

$comp=new Composite('Composite X');
$comp->Add(new Leaf('Leaf XA'));
$comp->Add(new Leaf('Leaf XB'));

$root->Add($comp);

$comp2=new Composite('Composite XY');
$comp2->Add(new Leaf('Leaf XYA'));
$comp2->Add(new Leaf('Leaf XYB'));

$comp->Add($comp2);

$root->Add(new Leaf('Leaf C'));
$leaf=new Leaf('Leaf D');
$root->Add($leaf);
$root->Display(1);

die('组合模式');
/**
 * 在不破坏封装性的前提下，捕获一个对象的内部状态，并在该对象之外保存这个状态。这样就可以将该对象恢复到原先保存的状态。
 */

/**
 * Originator (发起人)：记录当前时刻的内部状态，负责定义哪些属于备份范围的状态，负责创建和恢复备忘录数据。
 */
class Originator 
{
  
    function __construct()
    {
     # code...
    }

    public function __get($name)
    {
        return $this->$name;
    }
    public function __set($name, $value)
    {
        $this->$name=$value;
    }
    public function CreateMemento(){
        return (new Memento($this->state));
    }
    public function SetMemento(Memento $memento){
        $this->state=$memento->GetState();
    }
    public function show(){
        var_dump('State='.$this->state);
    }
}


/**
 * Memento(备忘录)
 * 负责存储发起人对象的内部状态，
 * 在需要的时候提供发起人需要的内部状态。
 */
class Memento
{
    public function __construct($state)
    {
        $this->state=$state;
    }
    public function GetState(){
        return $this->state;
    }
}

/**
 * Carataker(管理角色)：对备忘录进行管理，修改和获取备忘录。
 */
class Carataker 
{
  
   public function SetMemento($value){
        $this->memento=$value;
    }
    public function GetMemento(){
        return $this->memento;
    }
}

$a=new Originator();  //创建发起人
$a->state='On'; 
$a->show();   //发起人 state 的状态

$c=new Carataker();  //备忘录管理者创建
$c->SetMemento($a->CreateMemento());  //发起人创建备忘录，管理者记录备忘录的状态

$a->state='Off';
$a->show();   //改变发起者的state状态

$a->SetMemento($c->GetMemento()); //恢复发起者存储在管理者中状态
$a->show();

die('备忘录模式');
/**
 * 抽象状态类
 * 状态模式(State Pattern) ：允许一个对象在其内部状态改变时改变它的行为，对象看起来似乎修改了它的类。其别名为状态对象(Objects for States)，状态模式是一种对象行为型模式。
 */
abstract class State 
{
  public  abstract function Handle(Context $context);
  
}

/**
 * 环境类
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

  public function request()
  {
     $this->state->Handle($this);
  }
}

/**
 * 具体状态类A
 */
class ConcreteStateA extends State
{
  
  function __construct()
  {
   var_dump('ConcreteStateA');
  }

  public function Handle(Context $context)
  {
    $context->state = new ConcreteStateB();
  }
}

/**
 * 具体状态类B
 */
class ConcreteStateB extends State
{
  
  function __construct()
  {
   var_dump('ConcreteStateB');
  }

  public function Handle(Context $context)
  {
    $context->state = new ConcreteStateA();
  }
}


$a=new Context(new ConcreteStateA());
$a->Request();  //输出A,B
$a->Request();  // $context->state=ConcreteStateB  调用输出 A
$a->Request();  // $context->state=ConcreteStateA  调用输出 B
$a->Request();  // $context->state=ConcreteStateB  调用输出 A
  
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
 * @Last Modified by:   Jingxinpo
 * @Last Modified time: 2018-06-20 11:37:31
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