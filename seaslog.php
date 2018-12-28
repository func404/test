<?php
date_default_timezone_set('PRC');
 // Seaslog::setBasePath('~/Downloads/test/phplog/seaslog/');//设置seaslog的日志路径
 // $path = Seaslog::getBasePath(); //获取seaslog的日志路径
 // var_dump($path);
//设置日志模块
// SeasLog::setLogger('testModule/app1');
// SeasLog::getLastLogger();

/**
 *  日志警告级别
 *  ; SEASLOG_DEBUG      "debug"
	; SEASLOG_INFO       "info"
	; SEASLOG_NOTICE     "notice"
	; SEASLOG_WARNING    "warning"
	; SEASLOG_ERROR      "error"
	; SEASLOG_CRITICAL   "critical"
	; SEASLOG_ALERT      "alert"
	; SEASLOG_EMERGENCY  "emergency"
 */

// 写日志的常用方法
$res = SeasLog::error('this is a info log1111111');
SeasLog::debug('this debug11111'); 
SeasLog::info('this info, hello zeopean1111');
var_dump($res);
// Seaslog::info('...')
// Seaslog::notice('...')
// 读取日志
$res =  SeasLog::analyzerDetail(SEASLOG_ERROR,date('Ymd'));
$res =  SeasLog::analyzerDetail(SEASLOG_INFO,date('Ymd'));
$res =  SeasLog::analyzerDetail(SEASLOG_DEBUG,date('Ymd'));

var_dump($res);


