<?php

/**
 * @Author: Jingxinpo
 * @Date:   2018-08-22 18:08:21
 * @Last Modified by:   Jingxinpo
 * @Last Modified time: 2018-08-27 18:56:28
 */
/**
 * swoole soceket学习   协程实践
 * swoole web服务的实践
 * swoole socket 服务
 */

/**
 * 协程启用要求
   1.PHP版本要求：>= 7.0，包括7.0、7.1、7.2
   2.基于swoole_server或者swoole_http_server进行开发，目前只支持在onRequet, onReceive, onConnect等事件回调函数中使用协程。
 */
$http = new swoole_http_server("127.0.0.1", 8585);

$http->on('request',function ($request, $response)
{
	$_SERVER['REQUEST_URI'] = $request->server['request_uri'];
	$_GET = $request->get;
	$_POST = $request->post;
    require '/usr/local/var/www/gitdone/normbank/Webroot/index.php';

     $response->end($result);

	// $client = new Swoole\Coroutine\Client(SWOOLE_SOCK_TCP);
 //    $client->connect("127.0.0.1",8585,0.5);
 //    //调用connect将触发协程切换
 //    $client->send(json_encode($request->get));
 //    //调用recv将触发协程切换
 //    $ret = $client->recv();
 //    var_dump($ret);
 //    $response->header("Content-Type", "text/plain");
 //    $response->end($ret);
 //    $client->close();
});

$http->start();


class ClassName extends AnotherClass
{
	
	function __construct()
	{
		# code...
	}
}