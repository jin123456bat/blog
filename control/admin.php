<?php
namespace blog\control;

use framework\core\control;
use framework\core\http;
use framework\core\request;
use framework\core\view;
use framework\vendor\csrf;
use framework\core\response;
use framework\core\response\url;
use framework\core\response\json;
use blog\extend\webUser;

class admin extends control
{

	/**
	 * 登录
	 * @return \framework\core\view
	 */
	function login()
	{
		if (request::method() == 'get')
		{
			$view = new view('admin/login.php','backend');
			return $view;
		}
		else if (request::method() == 'post')
		{
			$username = request::post('username');
			$password = request::post('password');
			
			$remember = request::post('remember','false');
			$remember = ($remember == 'true')?true:false;
			
			$message = '';
			$result = webUser::addVerify(array(
				'username' => $username,
				'email' => $username,
				'telephone' => $username,
				'password' => $password,
			),$remember,$message);
			if($result)
			{
				return new json(array(
					'code'=>1,
					'message'=>'登录成功',
					'data' => http::url()
				));
			}
			else
			{
				return new json(array(
					'code'=>0,
					'message'=>$message
				));
			}
		}
	}
	
	function logout()
	{
		if(webUser::logout())
		{
			return new url('index','index');
		}
	}

	/**
	 * 注册
	 * @return \framework\core\view
	 */
	function register()
	{
		if (request::method() == 'post')
		{
			$username = request::post('username');
			$password = request::post('password');
			$email = request::post('email');
			
			$message = '';
			if(webUser::register(array(
				'username' => $username,
				'email' => $email,
				'password' => $password
			),$message))
			{
				return new json(array(
					'code'=>1,
					'message'=>'ok',
					'data' => http::url(),
				));
			}
			else
			{
				return new json(array(
					'code'=>0,
					'message'=>$message
				));
			}
		}
		else
		{
			$view = new view('admin/register.php','backend');
			return $view;
		}
	}

	function index()
	{
		//跳转到一个默认的页面
		return new url('admin','article_list');
	}
	
	/**
	 * 文章添加
	 * @return \framework\core\view
	 */
	function article_create()
	{
		$view = new view('admin/index.php','backend');
		return $view;
	}
	
	/**
	 * 文章管理页面
	 */
	function article_list()
	{
		$view = new view('admin/article_list.php','backend');
		return $view;
	}

	function __access()
	{
		return array(
			array(
				'deny',
				'actions' => array(
					'index'
				),
				'express' => empty(webUser::getLastVerified()),
				'location' => http::url('admin', 'login')
			),
			array(
				'deny',
				'actions' => array(
					'login',
					'register'
				),
				'express' => request::method() == 'post' && !csrf::verify(request::header(str_replace('-', '_',csrf::$_X_CSRF_TOKEN_NAME))),
				'message' => new response('请重新提交请求',403),
			)
		);
	}
}