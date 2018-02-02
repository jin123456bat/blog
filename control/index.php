<?php
namespace blog\control;

use framework\core\control;
use framework\core\view;
use blog\entity\article;
use framework\core\request;

class index extends control
{

	function index()
	{
		$this->model('article')
		->where(array(
			'publish'=>1,
			'isdelete'=>0,
		));
		
		$date = request::get('date');
		if (!empty($date))
		{
			$this->model('article')->between('createtime', $date,date('Y-m-d',strtotime('+1 day',strtotime($date))));
		}
		
		$tag = request::get('tag');
		if (!empty($tag))
		{
			$this->model('article')->where('id in (select distinct aid from tags where content=?)',array($tag));
		}
		
		$category = request::get('category');
		if (!empty($category))
		{
			$this->model('article')->where('id in (select aid from category where cid=?)',array($category));
		}
		
		$keyword = request::get('keyword');
		if (!empty($keyword))
		{
			$this->model('article')->where('title like ?',array($keyword));
		}
		
		
		
		$article = $this->model('article')->order('article.sort','asc')->select();
		
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