<?php
namespace blog\entity;

use framework\core\entity;
use framework\vendor\encryption;

class article extends entity
{

	/**
	 * 计算文章摘要
	 * 
	 * @param unknown $content        
	 * @return string
	 */
	static function getDescription($content)
	{
		return mb_strimwidth($content, 0, 1000, '...');
	}
	
	function __preInsert()
	{
		do{
			$id = encryption::unique_id();
			$article = $this->model('article')->where(array(
				'id'=>$id
			))->find();
		}while (!empty($article));
		$this->_data['id'] = $id;
	}

	function __relation($field, $primaryKey, $data)
	{
		if ($field == 'category')
		{
			$category = array();
			foreach ($data as $cid)
			{
				$category[] = array(
					'aid' => $primaryKey,
					'cid' => $cid,
				);
			}
			return array(
				'article_category' => array(
					'insert' => $category,
					'delete' => array(
						'aid' => $primaryKey
					)
				)
			);
		}
		else if ($field == 'tags')
		{
			$tags = json_decode($data);
			$data = array();
			foreach ($tags as $tag)
			{
				$data[] = array(
					'aid' => $primaryKey,
					'content' => $tag,
				);
			}
			
			return array(
				'tags' => array(
					'insert' => $data,
					'delete' => array(
						'aid' => $primaryKey,
					)
				)
			);
		}
	}
}