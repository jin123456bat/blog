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
			}
			
			if (in_array($control, array('admin'),true) && !in_array($action, array('login','register')))
			{
				$menu = $this->model('menu')->where('sup_menu_id is null')->order('sort','asc')->select();
				
				$current = $this->model('menu')->where(array(
					'link' => $control.'/'.$action
				))->limit(1)->find();
				
				$response->assign('menu_current', $current);
				
				$current_sup = $this->model('menu')->where(array(
					'id' => $current['sup_menu_id']
				))->limit(1)->find();
				
				$menu1 = $this->model('menu')->where(array(
					'sup_menu_id' => $current_sup['sup_menu_id']
				))->order('sort','asc')->select();
				
				$response->assign('menu_sup', $current_sup);
				
				$menu2 = $this->model('menu')->where(array(
					'sup_menu_id' => $current['sup_menu_id']
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