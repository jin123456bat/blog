<?php
namespace blog\entity;

use framework\core\entity;
use framework\vendor\encryption;
use framework\core\http;
use framework\vendor\image;
use blog\extend\spider;

class article extends entity
{

	/**
	 * 计算文章摘要
	 * 
	 * @param unknown $content        
	 * @return string
	 */
	static function getSummary($content)
	{
		$tags = array(
			'p',
			'pre',
			'code',
			'div',
		);
		
		$length = 500;
		$summary = '';
		
		foreach ($tags as $tag)
		{
			$pattern = '/<'.$tag.'.*>[\s\S]*<\/'.$tag.'>/iU';
			preg_match_all($pattern, $content,$match);
			
			
			foreach ($match[0] as $string)
			{
				if (mb_strlen($summary,'utf-8') < $length)
				{
					$summary .= $string;
				}
			}
		}
		return $summary;
		
		$content = strip_tags($content);
		return mb_strimwidth($content, 0, 1000, '...');
	}
	
	/**
	 * 格式化代码
	 * @param unknown $string
	 */
	static function formatCode($string)
	{
		$charset = 'utf-8';
		$pattern = '/<code(?<type>.*)>(?<content>[\s\S]*)<\/code>/iU';
		
		return preg_replace_callback($pattern, function($match) use($charset){
			$type = trim($match['type']);
			if (!empty($type))
			{
				$type = sscanf($type, 'class="language-%s"');
			}
			
			$type = !empty($type)?(' class="language-'.$type[0].'"'):'';
			
			$formatter = '\\framework\\vendor\\formatter\\'.$type;
			if (class_exists($formatter,true))
			{
				$class = new $formatter($match['content'],$charset);
				return '<code'.$type.'>'.$class->getCode().'</code>';
			}
			return $match[0];
		}, $string);
	}
	
// 	function __afterInsert()
// 	{
// 		$spider = new spider(http::url('article','index',array(
// 			'id' => $this->_data['id'],
// 		)));
// 		$spider->push();
// 	}
	
// 	function __afterRemove()
// 	{
// 		$spider = new spider(http::url('article','index',array(
// 			'id' => $this->_data['id'],
// 		)));
// 		$spider->delete();
// 	}
	
// 	function __afterUpdate()
// 	{
// 		$spider = new spider(http::url('article','index',array(
// 			'id' => $this->_data['id'],
// 		)));
// 		if ($this->_data['publish']==1 && $this->_data['isdelete']==1)
// 		{
// 			$spider->update();
// 		}
// 		else
// 		{
// 			$spider->delete();
// 		}
// 	}
	
	function __preUpdate()
	{
		$this->_data['content'] = self::formatCode($this->_data['content']);
	}
	
	function __preInsert()
	{
		$this->_data['content'] = self::formatCode($this->_data['content']);
		
		//生成文章ID
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