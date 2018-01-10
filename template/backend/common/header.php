<?php
use framework\core\assets;
use framework\core\http;
?>
<link rel="stylesheet" href="<?=assets::css('backend/common/header.css')?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?=assets::css('iconfont.css')?>" type="text/css" media="all" />
<header>
	<div class="nav">
		<div class="pull-left">
			<div class="logo">Techer</div>
			<div class="version">V1.0</div>
		</div>
		<div class="center">
			
			<?php foreach ($menu as $m){?>
			<div class="navigator <?=$m['active']?'active':''?>">
				<a href="<?=$m['link']?>"><?=$m['name']?></a>
			</div>
			<?php }?>
			
			<div class="logout">
				<a href="<?=http::url('admin','logout')?>"> <i class="iconfont icon-log-out"></i> 退出
				</a>
			</div>
			<div class="message">
				<a href="<?=http::url('admin','message')?>"> <i class="iconfont icon-message2"></i> 消息
				</a>
			</div>
			<div class="admin">
				<a href=""> <img src="<?=$user['gravatar']?>">
					<?=$user['username']?>
				</a>
			</div>
		</div>
	</div>
</header>