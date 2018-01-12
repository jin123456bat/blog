<?php
use framework\core\http;
use framework\vendor\csrf;
use framework\core\assets;
?>
<link rel="stylesheet" href="<?=assets::css('front/common/sidebar.css')?>" type="text/css" media="all" />
<div class="sidebar">
	<div class="item">
		<div class="search">
			<form action="<?=http::url()?>" onsubmit="if(this.keyword.value.length==0)return false;">
				<input type="hidden" name="c" value="article">
				<input type="hidden" name="a" value="search">
				<input type="hidden" name="<?=csrf::$_X_CSRF_TOKEN_NAME?>" value="<?=csrf::token()?>">
				<input type="text" name="keyword" value="" placeholder="搜索">
				<button type="submit"><i class="iconfont icon-search"></i></button>
			</form>
		</div>
	</div>
	
	<div class="item">
		<div class="func">
			<div class="item-header">功能</div>
			<div class="item-body">
				<a href="<?=http::url('admin','register')?>">注册</a>
				<a href="<?=http::url('admin','login')?>">登录</a>
			</div>
		</div>
	</div>
	
	<div class="item">
		<div class="tags">
			<div class="item-header">标签</div>
			<div class="item-body">
			</div>
		</div>
	</div>
	
	
	<div class="item">
		<div class="friend-link">
			<div class="item-header">友情连接</div>
			<div class="item-body">
			</div>
		</div>
	</div>
	
</div>