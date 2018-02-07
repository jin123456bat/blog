<?php
namespace blog\control;
use framework\core\control;
use framework\core\view;
use framework\core\request;
use blog\extend\webUser;

class article extends control
{
	function index()
	{
		$id = request::get('id');
		
		$this->model('read_history')->insert(array(
			'uid' => !empty(webUser::getLastVerified())?webUser::getLastVerified()['id']:0,
			'aid' => $id,
			'time' => date('Y-m-d H:i:s'),
			'ip' => request::getIp(),
			'ua' => request::getUA(),
		));
		
		$article = $this->model('article')->where(array(
			'id'=>$id,
		))->find();
		
		$article['comment_num'] = $this->model('comment')->where(array(
			'aid' => $article['id']
		))->count();
		$article['read_num'] = $this->model('read_history')->where(array(
			'aid' => $article['id']
		))->count();
		
		$view = new view('article/index.php');
		$view->assign('article', $article);
		return $view;
	}
	
	function content()
	{
		$id = request::get('id');
		return $this->model('article')->where('id=?',array($id))->scalar('content');
	}
}