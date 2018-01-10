<?php
namespace blog\control;

use framework\core\control;
use framework\core\view;
use blog\entity\article;

class index extends control
{

	function index()
	{
		$article = $this->model('article')
		->order('article.sort','asc')
		->select();
		
		foreach ($article as &$a)
		{
			$a['comment_num'] = $this->model('comment')->where(array(
				'aid' => $a['id']
			))->count();
			$a['read_num'] = $this->model('read_history')->where(array(
				'aid' => $a['id']
			))->count();
			
			$a['content'] = article::getDescription($a['content']);
		}
		
		$view = new view('index/index.php');
		
		$view->assign('article', $article);
		return $view;
	}
}