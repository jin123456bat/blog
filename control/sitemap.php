<?php
namespace blog\control;
use framework\core\control;
use framework\core\view;
use framework\core\http;

class sitemap extends control
{
	function rss()
	{
		$view = new view('rss.php','sitemap');
		
		$article = $this->model('article')->where(array(
			'publish' => 1,
			'isdelete'=> 0,
		))->select();
		
		$view->assign('article', $article);
		
		return $view;
	}
	
	function google()
	{
		$view = new view('google.php','sitemap');
		
		$ids = $this->model('article')->where(array(
			'isdelete'=>0,
			'publish' => 1,
		))
		->order('sort','asc')
		->order('createtime','desc')
		->column('id');
		$urls = array_map(function($id){
			return 'https://www.techer.top/index.php?'.urlencode(http::url('article','index',array(
				'id' => $id,
			),false));
		}, $ids);
		
		$view->assign('urls', $urls);
		$view->setContentType('text/xml');
		
		return $view;
	}
}