<?php

/**
 * -------------------------------------------------
 * 将以路径形式存储的文件，转化为浏览器可访问的url
 * -------------------------------------------------
 */
if (!function_exists('img_to_url'))
{
	function img_to_url($dir) {
		if (empty($dir)) return null;
		$pathInfo = pathinfo($dir);
		return getenv('static_iamges').'/'.$dir;
	}
}

if (!function_exists('url_to_img'))
{
	function url_to_img($url) {
		if (empty($dir)) return null;
		$pathInfo = pathinfo($dir);
		return getenv('server_images').'/'.$pathInfo['basename'];
	}
}

if (!function_exists('show_text'))
{
	function show_text($str,$strlen=10,$other=true) {
		for($i=0;$i<$strlen;$i++)
			if(ord(substr($str,$i,1))>0xa0) $i++;
			if($i%2!=0) $strlen++;
			$rstr=substr($str,0,$strlen);
			if (strlen($str)>$strlen && $other) {$rstr.='...';}
			return $rstr;
		}
}
?>