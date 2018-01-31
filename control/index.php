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
		->where(array(
			'publish'=>1,
			'isdelete'=>0,
		))
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
			
			if (empty($a['summary']))
			{
				$a['summary'] = article::getSummary($a['content']);
			}
		}
		
		$view = new view('index/index.php');
		
		$view->assign('article', $article);
		return $view;
	}
	
	function __404()
	{
		$view = new view('common/404.php');
		return $view;
	}
}