<?php
namespace blog\extend;

class spider
{
	private $_site = array(
		'baidu',
	);
	
	private $_baidu_token = 'FJWTqVjxmTIDvw4u';
	
	private $_url = array(
		
	);
	
	function __construct($url)
	{
		$this->_url[] = $url;
	}
	
	function push()
	{
		$url = 'http://data.zz.baidu.com/urls?site=www.techer.top&token=%s';
		
		$ch = curl_init();
		$options =  array(
			CURLOPT_URL => sprintf($url,$this->_baidu_token),
			CURLOPT_POST => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS => implode("\n", $this->_url),
			CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
		);
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		$result = json_decode($result,true);
		return $result['success'] == 1;
	}
	
	function update()
	{
		$url = 'http://data.zz.baidu.com/update?site=www.techer.top&token=%s';
		
		$ch = curl_init();
		$options =  array(
			CURLOPT_URL => sprintf($url,$this->_baidu_token),
			CURLOPT_POST => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS => implode("\n", $this->_url),
			CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
		);
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		$result = json_decode($result,true);
		return $result['success'] == 1;
	}
	
	function delete()
	{
		$url = 'http://data.zz.baidu.com/del?site=www.techer.top&token=%s';
		
		$ch = curl_init();
		$options =  array(
			CURLOPT_URL => sprintf($url,$this->_baidu_token),
			CURLOPT_POST => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS => implode("\n", $this->_url),
			CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
		);
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		$result = json_decode($result,true);
		return $result['success'] == 1;
	}
	
}