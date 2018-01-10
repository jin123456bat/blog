<?php
namespace blog\entity;
use framework\core\entity;

class article extends entity
{
	/**
	 * 计算文章摘要
	 * @param unknown $content
	 * @return string
	 */
	static function getDescription($content)
	{
		return mb_strimwidth($content,0,1000,'...');
	}
}