<?php

/**
 * @Author: Jingxinpo
 * @Date:   2018-08-28 10:22:06
 * @Last Modified by:   Jingxinpo
 * @Last Modified time: 2018-08-28 13:29:48
 */
function curl($url, $data=null, $timeout=0, $isProxy=false){
    $curl = curl_init();
    if($isProxy){   //是否设置代理
        $proxy = "127.0.0.1";   //代理IP
        $proxyport = "8001";   //代理端口
        curl_setopt($curl, CURLOPT_PROXY, $proxy.":".$proxyport);
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($curl,CURLOPT_HTTPAUTH,CURLAUTH_BASIC);  //设置http验证方法
	curl_setopt($curl,CURLOPT_HEADER,0);  //输出头信息
    if(!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    if ($timeout > 0) { //超时时间秒
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    }
    // $output = curl_exec($curl);
    // $error = curl_errno($curl);
    // curl_close($curl);
 
    // if($error){
    //     return false;
    // }
    return $curl;
}

function asyncurl()
{   
	$cm = curl_multi_init();
	$array = [];
	for ($i=0; $i < 50; $i++) { 
		$curl = curl('http://webui.com/cmb/test',['abc'=>$i],1);
		$array[(string)$curl]=$curl;
	    curl_multi_add_handle($cm,$curl);
	}
	do {
	    while (($mrc = curl_multi_exec($cm, $active)) == CURLM_CALL_MULTI_PERFORM) ;
	       if ($mrc != CURLM_OK) { break; }
	    // a request was just completed -- find out which one
	    while ($done = curl_multi_info_read($cm)) {
	        // get the info and content returned on the request
	        $info = curl_getinfo($done['handle']);
	        $error = curl_error($done['handle']);
	        $result[$array[(string)$done['handle']]] = curl_multi_getcontent($done['handle']);
	        // $responses[$map[(string) $done['handle']]] = compact('info', 'error', 'results');
	        // remove the curl handle that just completed
	        curl_multi_remove_handle($cm, $done['handle']);
	        curl_close($done['handle']);
	    }
	    // Block for data in / output; error handling is done by curl_multi_exec
	    if ($active > 0) {
	        curl_multi_select($cm);
	    }

	} while ($active);
    
	curl_multi_close($cm);
	var_dump($result);

}
 
asyncurl();


function async_fsockopen($url,$post_data=array(),$cookie=array()){
	$url_arr = parse_url($url);
	$port = isset($url_arr['port'])?$url_arr['port']:80;
 
	if($url_arr['scheme'] == 'https'){
		$url_arr['host'] = 'ssl://'.$url_arr['host'];
	}
	$fp = fsockopen($url_arr['host'],$port,$errno,$errstr,30);
	if(!$fp) return false;
 
	$getPath = isset($url_arr['path'])?$url_arr['path']:'/index.php';
	$getPath .= isset($url_arr['query'])?'?'.$url_arr['query']:'';
 
	$method = 'GET';  //默认get方式
	if(!empty($post_data)) $method = 'POST';
 
	$header = "$method  $getPath  HTTP/1.1\r\n";
	$header .= "Host: ".$url_arr['host']."\r\n";
 
	if(!empty($cookie)){  //传递cookie信息
		$_cookie = strval(NULL);
		foreach($cookie AS $k=>$v){
			$_cookie .= $k."=".$v.";";
		}
		$cookie_str = "Cookie:".base64_encode($_cookie)."\r\n";
		$header .= $cookie_str;
	}
	if(!empty($post_data)){  //传递post数据
		$_post = array();
		foreach($post_data AS $_k=>$_v){
			$_post[] = $_k."=".urlencode($_v);
		}
		$_post = implode('&', $_post);
		$post_str = "Content-Type:application/x-www-form-urlencoded; charset=UTF-8\r\n";
		$post_str .= "Content-Length: ".strlen($_post)."\r\n";  //数据长度
		$post_str .= "Connection:Close\r\n\r\n";
		$post_str .= $_post;  //传递post数据
		$header .= $post_str;
	}else{
		$header .= "Connection:Close\r\n\r\n";
	}
	fwrite($fp, $header);
	//echo fread($fp,1024);
	usleep(1000); // 这一句也是关键，如果没有这延时，可能在nginx服务器上就无法执行成功
	fclose($fp);
	return true;
}
 
// async_fsockopen('http://localhost/index.php');



