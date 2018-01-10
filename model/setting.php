<?php
namespace blog\model;

use framework\core\model;

class setting extends model
{

	function select($field = '*')
	{
		$result = parent::select();
		$temp = array();
		foreach ($result as $r)
		{
			$temp[$r['skey']] = $r['value'];
		}
		return $temp;
	}
}