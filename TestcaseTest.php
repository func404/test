<?php

/**
 * @Author: Jingxinpo
 * @Date:   2018-08-23 10:23:10
 * @Last Modified by:   Jingxinpo
 * @Last Modified time: 2018-08-27 09:49:59
 * phpunit 的一个测试用例
 */
use PHPUnit\Framework\TestCase;


class TestcaseTest extends TestCase
{
    public function testPushAndPop()
    {
        $stack = [];
        $this->assertEquals(0, count($stack));
        array_push($stack, 'foo');
        $this->assertEquals('foo', $stack[count($stack) - 1]);
        $this->assertEquals(1, count($stack));
        $this->assertEquals('foo', array_pop($stack));
        $this->assertEquals(0, count($stack));
    }

   public function testZero()
   {
   	  $this->assertTrue(true);
   }
   
   /**
    * @depends testZero //testtwo依赖testZero方法的结果
    * @return [type] [description]
    */
   public function testOne()
    {
        $this->assertTrue(true);
    }

    /**
     * 单依赖
     * @depends testOne      //testtwo依赖testone方法的结果
     * @depends testZero      //testtwo依赖testZero方法的结果
     */
    public function testTwo()
    {
    	echo 'faf';
    }

    public function data()
    {
    	yield [1,0,1];
    	yield [0,1,1];
    }
     
     /**
      * [testdataprovide description]
      * @param  [type] $a [description]
      * @param  [type] $b [description]
      * @param  [type] $c [description]
      * @return [type]    [description]
      * @depends data  
      */
    public function testdataprovide($a,$b,$c)
    {
    	$this->assertEquals($c,$a+$b);
    }

   // ----------------------------------- @expectedException 来预期 PHP 错误-------------------
   
   public function testexpec()
   {
   	  $this->expectExceptionMessage('nimeienie');
   }


   
}
