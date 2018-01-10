<?php
namespace blog\entity;

use framework\core\entity;
use framework\core\request;

class admin extends entity
{
	function __render($data)
	{
		return array(
			'password' => '\framework\vendor\encryption::password_hash',
		);
	}
	
	function __label()
	{
		return array(
			'username' => '用户名',
			'email' => '电子邮箱',
			'telephone' => '手机号码',
			'password' => '密码',
		);
	}
	
	function __preInsert()
	{
		$this->_data['register_ip'] = request::getIp();
		$this->_data['create_ua'] = request::getUA();
	}
	
	function __rules()
	{
		return array(
			'required'=>array(
				'fields' => array(
					'username',
					'password',
				),
				'message'=>array(
					'{field}不能为空',
				)
			),
			'unique' => array(
				'fields' => array(
					'username',
					'email',
					'telephone',
				),
				'message' => '{field}已经存在',
			)
		);
	}
}