<?php
namespace blog\control;
use framework\core\control;
use framework\core\request;
use framework\core\response\json;

class datatables extends control
{
	function article()
	{
		$total = $this->model('article')->count();
		
		$start = request::post('start',0,null,'i');
		$length = request::post('length',10,null,'i');
		
		$columns = request::post('columns',array(),null,'a');
		$articleModel = $this->model('article');
		$select = array();
		foreach ($columns as $column)
		{
			$select[$column['data']] = $column['name'];
		}
		
		$ajaxData = request::post('ajaxData',array(),null,'a');
		$articleModel->where($ajaxData);
		
		$articleModel->keepCondition();
		$count = $articleModel->count();
		
		$sort = request::post('order',array(),null,'a');
		foreach ($sort as $k => $v)
		{
			$articleModel->order($k,$v);
		}
		
		$data = $articleModel->limit($start,$length)->select($select);
		
		return new json(array(
			'draw' => request::post('draw',0,null,'i'),
			'recordsFiltered' => $count,//过滤后的数量
			'recordsTotal' => $total,//记录总数
			'data' => $data,
		));
	}
}