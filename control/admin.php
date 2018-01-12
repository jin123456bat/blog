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
use blog\entity\article;
use framework\core\response\message;

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

	/**
	 * 后台首页
	 * @return \framework\core\response\url
	 */
	function index()
	{
		//跳转到一个默认的页面
		return new url('admin','article_list');
	}
	
	/**
	 * 编辑文章
	 * @return \framework\core\view
	 */
	function article_edit()
	{
		if (request::method() == 'post')
		{
			
		}
		else
		{
			$view = new view('admin/article_create.php','backend');
			
			$category = $this->model('category')->order('sort','asc')->select();
			$view->assign('category', $category);
			
			return $view;
		}
	}
	
	/**
	 * 文章添加
	 * @return \framework\core\view
	 */
	function article_create()
	{
		if (request::method() == 'post')
		{
			$data = array(
				'title' => request::post('title','',null,'s'),
				'content' => request::post('content','',null,'s'),
				'uid' => webUser::getLastVerified()['id'],
				'uname' => webUser::getLastVerified()['username'],
				'publish' => request::post('publish',0,null,'i'),
				'tags' => request::post('tags','[]',null,'s'),
				'category' => request::post('category',array(),null,'a'),
			);
			$article = new article($data);
			if ($article->validate())
			{
				if($article->save())
				{
					return new url('admin','article_edit',array(
						'id' => $article->id
					));
				}
				else
				{
					return new message('添加失败',http::url('admin','article_create'),3);
				}
			}
			else
			{
				return new message(current($article->getError()),http::url('admin','article_create'),3);
			}
		}
		else
		{
			$view = new view('admin/article_create.php','backend');
			
			$category = $this->model('category')->order('sort','asc')->select();
			$view->assign('category', $category);
		
			return $view;
		}
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
					'article_edit',
					'article_create',
					'article_list',
					'index',
				),
				'express' => empty(webUser::getLastVerified()),
				'message' => new url('admin','login'),
			),
			array(
				'deny',
				'actions' => array(
					'login',
					'register',
				),
				'express' => request::method() == 'post' && !csrf::verify(request::header(str_replace('-', '_',csrf::$_X_CSRF_TOKEN_NAME))),
				'message' => new response('请重新提交请求',403),
			),
			array(
				'deny',
				'actions' => array(
					'article_create',
					'article_edit',
				),
				'express' => request::method() == 'post' && !csrf::verify(request::post(csrf::$_X_CSRF_TOKEN_NAME)),
				'message' => new response('请重新提交请求',403),
			)
		);
	}
}