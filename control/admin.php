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
			$data = array(
				'id' => request::post('id'),
				'title' => request::post('title'),
				'content' => request::post('content'),
				'publish' => request::post('publish',0,null,'i'),
				'summary' => request::post('summary'),
			);
			$article = new article($data);
			if ($article->validate())
			{
				if($article->save())
				{
					return new url('admin','article_edit',array(
						'id' => $article->id,
					));
				}
				else
				{
					return new message('更新失败',http::url('admin','article_edit'),3);
				}
			}
			else
			{
				return new message(current($article->getError()),http::url('admin','article_edit'),3);
			}
		}
		else
		{
			$id = request::get('id');
			
			$article = $this->model('article')
			->leftJoin('article_category', 'article_category.aid=article.id')
			->leftJoin('tags', 'tags.aid=article.id')
			->where(array(
				'article.id' => $id
			))
			->group('article.id')
			->find(array(
				'article.*',
				'article_category'=>'GROUP_CONCAT(article_category.cid)',
				'tags' => 'GROUP_CONCAT(tags.content)'
			));
			
			$view = new view('admin/article_edit.php','backend');
			
			$view->assign('article', $article);
			
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
	 * 文章状态更改
	 * @return \framework\core\response\json
	 */
	function article_update()
	{
		$id = request::post('id');
		$publish = request::post('publish',null,null,'0,1');
		
		if ($publish !== null)
		{
			if($this->model('article')->where(array(
				'id'=>$id
			))->update('publish',$publish))
			{
				return new json(array(
					'code'=>1,
					'message'=>'修改成功',
				));
			}
			else
			{
				return new json(array(
					'code'=>0,
					'message'=>'修改失败'
				));
			}
		}
		
		$delete = request::post('delete',null,null,'1,0');
		if ($delete !== null)
		{
			if($this->model('article')->where(array(
				'id'=>$id
			))->update(array(
				'isdelete'=>$delete,
				'deletetime' => date('Y-m-d H:i:s'),
			)))
			{
				return new json(array(
					'code'=>1,
					'message'=>$delete==1?'删除成功':'恢复成功',
				));
			}
			else
			{
				return new json(array(
					'code'=>0,
					'message'=>$delete==1?'删除失败':'恢复失败',
				));
			}
		}
	}
	
	/**
	 * 永久删除文章
	 */
	function article_delete()
	{
		$id = request::post('id');
		if (is_array($id))
		{
			$article = $this->model('article')->where(array(
				'id' => $id
			))->select();
			$this->model('article')->transaction();
			foreach ($article as $data)
			{
				$data['category'] = array();//删除category关联表中的数据
				$data['tags'] = '[]';//删除category关联表中的数据
				$article = new article($data);
				if(!$article->delete())
				{
					$this->model('article')->rollback();
					return new json(array(
						'code'=>0,
						'message'=>'删除失败,请重试',
					));
				}
			}
			$this->model('article')->commit();
			return new json(array(
				'code'=>1,
				'message'=>'删除成功',
			));
		}
		else
		{
			$article = $this->model('article')->where(array(
				'id' => $id
			))->find();
			$article['category'] = array();//删除category关联表中的数据
			$article['tags'] = '[]';//删除category关联表中的数据
			$article = new article($article);
			if($article->delete())
			{
				return new json(array(
					'code'=>1,
					'message'=>'删除成功',
				));
			}
			else
			{
				return new json(array(
					'code'=>0,
					'message'=>'删除失败',
				));
			}
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
					'article_update',
					'article_edit',
					'article_create',
					'article_list',
					'article_delete',
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
					'article_update',
					'article_delete'
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