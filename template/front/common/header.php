<?php
use framework\core\http;
use framework\core\assets;
use framework\core\application;
?>
<link rel="stylesheet" href="<?=assets::css('front/common/header.css')?>" type="text/css" media="all" />

<?php if (!empty($user)){?>
<div class="user-toolbar">
	<div class="center">
		<div class="pull-down-group" >
			<div class="item">
				<i class="iconfont icon-plus"></i>
				<span class="label">新建</span>
			</div>
			
			<ul class="pull-down">
				<li><a href="<?=http::url('admin','article_create')?>">文章</a></li>
			</ul>
			
		</div>
		<?php if (application::$_control == 'article' && application::$_action == 'index'){?>
		<div class="item">
			<a class="label" target="_blank" href="<?=http::url('admin','article_edit',array(
				'id' => $_GET['id']
			))?>">
			<i class="iconfont icon-edit"></i>
			编辑
			</a>
		</div>
		<?php }?>
		<div class="item">
			<i class="iconfont icon-message"></i>
			<span class="label">消息</span>
		</div>
	</div>
</div>
<?php }?>

<header <?=!empty($user)?'style="top:32px;"':''?>>
	<div class="toolbar">
		<div class="navbar">
			<h1><a href="<?=http::url()?>"><?=$setting['site_title']?></a></h1>
			<p class="site_desc"><?=$setting['site_desc']?></p>
		</div>
		<div class="menu">
			<a class="item" href="<?=http::url()?>">
				首页
			</a>
			<?php foreach ($menus as $menu){?>
			<a class="item" href="<?=http::url($menu['link'])?>">
			<?=$menu['name']?>
			</a>
			<?php }?>
		</div>
	</div>
</header>

<div class="archive" style="background-image:url(<?=assets::image('background-blog.jpg')?>)">
	<div class="layer">
		<div class="content">
			<div class="content-title"><h1>太客</h1></div>
			<div class="content-desc">Coding Yourself --- techer.top</div>
		</div>
	</div>
</div>