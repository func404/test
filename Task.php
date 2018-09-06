<?php

/**
 * @Author: Jingxinpo
 * @Date:   2018-08-07 16:23:32
 * @Last Modified by:   Jingxinpo
 * @Last Modified time: 2018-08-28 10:14:19
 */
/**
 *  还有另外一种线程，他的调度是由程序员自己写程序来管理的，对内核来说不可见。这种线程叫做『用户空间线程』。
	协程可以理解就是一种用户空间线程。
	协程，有几个特点：
	 1.协同，因为是由程序员自己写的调度策略，其通过协作而不是抢占来进行切换
	 2.在用户态完成创建，切换和销毁
	 3.⚠️ 从编程角度上看，协程的思想本质上就是控制流的主动让出（yield）和恢复（resume）机制
	 4.generator经常用来实现协程
 */


// $table = "table";
// $i=0;
// while($i++ < 10) {
//   echo $sql = "select * from " .  $table . " where id = " . $i ."\n";
// }

// die;
/**
 * 轻量级的协程类
 */
class Task 
{
	
    protected $taskId;
    protected $coroutine;
    protected $sendValue=null;
    protected $beforeFirstYield = true;

	function __construct($taskId,Generator $coroutine)
	{
		$this->taskId = $taskId;
		$this->coroutine = $coroutine;
	}

	public function getTaskId()
	{
		return $this->taskId;
	}

	public function setSendValue($sendValue)
	{
		$this->sendValue=$sendValue;
	}

	public function run()
	{
		if ($this->beforeFirstYield) {
			$this->beforeFirstYield = false;
			return $this->coroutine->current();
		}else{
			$retval = $this->coroutine->send($this->sendValue);
            $this->sendValue = null;
            return $retval;
		}
	}
	 public function isFinished() {
        return !$this->coroutine->valid();
    }
}


/**
 * 调度队列
 */
class Scheduler 
{
	protected $maxTaskId = 0;
    protected $taskMap = []; // taskId => task
    protected $taskQueue;

	function __construct()
	{
	   $this->taskQueue = new SplQueue();//php自带链表实现的队列
	}

	public function newTask(Generator $coroutine)
	{
		$tid = ++$this->maxTaskId;
        $task = new Task($tid, $coroutine);
        $this->taskMap[$tid] = $task;
        $this->schedule($task);
        return $tid;
	}


	 public function schedule(Task $task) {
        $this->taskQueue->enqueue($task);
    }
 
    public function run() {
        while (!$this->taskQueue->isEmpty()) {
            $task = $this->taskQueue->dequeue();
            $retval = $task->run();

            if ($retval instanceof SystemCall) {
            	$retval($task,$this);
            	continue;
            }
 
            if ($task->isFinished()) {
                unset($this->taskMap[$task->getTaskId()]);
            } else {
                $this->schedule($task);
            }
        }
    }
}

/**
 * 
 */
class SystemCall 
{
	protected $callback;

	function __construct(callable $callback)
	{
		$this->callback = $callback;
	}

	public function __invoke(Task $task,Scheduler $scheduler)
	{
		$callback = $this->callback;
		return $callback($task,$scheduler);
	}
}

//杀死任务
function killTask($tid) {
    return new SystemCall(
        function(Task $task, Scheduler $scheduler) use ($tid) {
            $task->setSendValue($scheduler->killTask($tid));
            $scheduler->schedule($task);
        }
    );
}

//新建任务
function newTask(Generator $coroutine) {
    return new SystemCall(
        function(Task $task, Scheduler $scheduler) use ($coroutine) {
            $task->setSendValue($scheduler->newTask($coroutine));
            $scheduler->schedule($task);
        }
    );
}



function getTaskId(){
	 return new SystemCall(function(Task $task, Scheduler $scheduler) { //回调函数
	        $task->setSendValue($task->getTaskId());
	        $scheduler->schedule($task);
	   });
}
 

function task($max) {
	 $tid = (yield getTaskId());
   // $tid = (yield getTaskId()); // <-- here's the syscall!
    for ($i = 1; $i <= $max; ++$i) {
    	sleep(1);
        echo "This is task $tid iteration $i.\n";
        yield;
    }
}

function task1($max) {
	 $tid = (yield getTaskId());
   // $tid = (yield getTaskId()); // <-- here's the syscall!
    for ($i = 1; $i <= $max; ++$i) {
        echo "This is task $tid iteration $i.\n";
        yield;
    }
}
 
 $scheduler = new Scheduler;
 $scheduler->newTask(task1(5));
  $scheduler->newTask(task(2));

// $scheduler->newTask(task(4));

 
 $scheduler->run();



