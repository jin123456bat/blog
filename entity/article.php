<?php
namespace blog\entity;

use framework\core\entity;
use framework\vendor\encryption;
use framework\core\http;
use framework\vendor\image;
use framework\core\request;

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
		$content = strip_tags($content);
		return mb_strimwidth($content, 0, 1000, '...');
	}
	
	function __preInsert()
	{
		//生成文章ID
		do{
			$id = encryption::unique_id();
			$article = $this->model('article')->where(array(
				'id'=>$id
			))->find();
		}while (!empty($article));
		$this->_data['id'] = $id;
		
		//自动同步远程图片下载到本地
		$pattern = '/<img[^>]*>/';
		$urls = array();
		if(preg_match_all($pattern, $this->_data['content'].$this->_data['summary'],$matches))
		{
			foreach ($matches[0] as $match)
			{
				$src = '/src=[\'"](?<url>[^"\']+)[\'"]/';
				if(preg_match_all($src, $match,$subject))
				{
					//$urls = array_merge($urls,$subject['url']);
					foreach ($subject['url'] as $url)
					{
						$host = parse_url($url,PHP_URL_HOST);
						if (!empty($host) && $host != $_SERVER['HTTP_HOST'])
						{
							$urls[] = $url;
						}
					}
				}
			}
		}
		
		$urls = array_unique($urls);
		
		$temp = array();
		foreach ($urls as $url)
		{
			$image = new image($url);
			$path = $image->move(APP_ROOT.'/upload/images/'.date('Y/m/d/'))->path(false);
			$temp[$url] = $path;
		}
		
		if (!empty($temp))
		{
			$this->_data['content'] = str_replace(array_keys($temp), array_values($temp), $this->_data['content']);
			$this->_data['summary'] = str_replace(array_keys($temp), array_values($temp), $this->_data['summary']);
		}
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