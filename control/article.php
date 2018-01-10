<?php
namespace blog\control;
use framework\core\control;
use framework\core\view;
use framework\core\request;

class article extends control
{
	function index()
	{
		$id = request::get('id',0,'intval','i');
		
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
}