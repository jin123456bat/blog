<?php
namespace blog\extend;
use framework\core\application;
use framework\core\view;
use framework\vendor\user;
use framework\core\http;

class blog extends application
{
	function onRequestEnd($control,$action,$response = NULL)
	{
		if ($response instanceof view)
		{
			if (in_array($control, array('article','index'),true))
			{
				//加载前台分类
				$category = $this->model('category')->order('sort','asc')->select();
				$response->assign('category', $category);
				
				//加载文章标签
				$tags = $this->model('tags')->group('content')->order('num','desc')->select(array(
					'content',
					'num'=>'count(*)',
				));
				$response->assign('tags', $tags);
				
				//归档
				$archive = $this->model('article')
				->group('createtime')->order('createtime','desc')->select(array(
					'createtime'=>'DATE_FORMAT(createtime,"%Y-%m-%d")',
					'num' => 'count(*)',
				));
				$response->assign('archives', $archive);
				
				$new = $this->model('article')
				->where(array(
					'isdelete' => 0,
					'publish' => 1,
				))
				->order('createtime','desc')
				->limit(10)
				->select('id,title');
				$response->assign('new', $new);
				
				$menus = $this->model('menu')->where(array(
					'type' => 1,
					'shown' => 1,
					'sup_menu_id'=>NULL,
				))
				->order('sort','asc')
				->select('name,link');
				$response->assign('menus', $menus);
			}
			
			if (in_array($control, array('admin'),true) && !in_array($action, array('login','register')))
			{
				$menu = $this->model('menu')->where('sup_menu_id is null')->where(array(
					'shown'=>1,
					'type'=>0,
				))->order('sort','asc')->select();
				
				$current = $this->model('menu')->where(array(
					'link' => $control.'/'.$action
				))->limit(1)->find();
				
				$response->assign('menu_current', $current);
				
				$current_sup = $this->model('menu')->where(array(
					'id' => $current['sup_menu_id']
				))->limit(1)->find();
				
				$menu1 = $this->model('menu')->where(array(
					'sup_menu_id' => $current_sup['sup_menu_id'],
					'shown'=>1,
					'type'=>0,
				))->order('sort','asc')->select();
				
				$response->assign('menu_sup', $current_sup);
				
				$menu2 = $this->model('menu')->where(array(
					'sup_menu_id' => $current['sup_menu_id'],
					'shown'=>1,
					'type'=>0,
				))->order('sort','asc')->select();
				
				foreach ($menu2 as &$m)
				{
					if (!empty($m['link']))
					{
						list($c,$a) = explode('/', $m['link'],2);
						$m['link'] = http::url($c,$a);
					}
					if ($m['id'] == $current['id'])
					{
						$m['active'] = true;
					}
					else
					{
						$m['active'] = false;
					}
				}
				
				foreach ($menu1 as &$m)
				{
					//二级菜单的连接取对应三级菜单的第一个菜单的连接
					$m['link'] = $this->model('menu')->where(array(
						'sup_menu_id'=>$m['id'],
						'type' => 0,
						'shown' => 1,
					))->where('link != ""')->order('sort','asc')->scalar('link');
					
					if (!empty($m['link']))
					{
						list($c,$a) = explode('/', $m['link'],2);
						$m['link'] = http::url($c,$a);
					}
					if ($m['id'] == $current_sup['id'])
					{
						$m['active'] = true;
					}
					else
					{
						$m['active'] = false;
					}
				}
				
				foreach ($menu as &$m)
				{
					if (!empty($m['link']))
					{
						list($c,$a) = explode('/', $m['link'],2);
						$m['link'] = http::url($c,$a);
					}
					if ($m['id'] === $current_sup['sup_menu_id'])
					{
						$m['active'] = true;
					}
					else
					{
						$m['active'] = false;
					}
				}
				
				$response->assign('menu2', $menu2);
				$response->assign('menu1', $menu1);
				$response->assign('menu', $menu);
			}
			
			//加载前台需要的全局设置
			$setting = $this->model('setting')->select();
			$response->assign('setting', $setting);
			
			$user = user::getLastVerified();
			$response->assign('user', $user);
			
			return $response;
		}
	}
}