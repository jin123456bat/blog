<?php
use framework\core\assets;
use framework\core\http;
use framework\vendor\csrf;
?>
<!DOCTYPE html>
<html lang="zh-hans">
<head>
<meta charset="UTF-8">
<title><?=$setting['site_title']?> | <?=$setting['site_desc']?></title>
<link rel="stylesheet" href="<?=assets::css('front/main.css')?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?=assets::css('front/index/index.css')?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?=assets::css('iconfont.css')?>" type="text/css" media="all" />
<link href="<?=assets::path('ckeditor/plugins/codesnippet/lib/highlight/styles/default.css')?>" rel="stylesheet"/>
<link href="<?=assets::path('ckeditor/style.css')?>" rel="stylesheet"/>
</head>
<body>

<?php include_once FRONT.'common/header.php';?>

<div class="container">
	<div class="article">
		<?php if (!empty($article)){?>
		<?php foreach ($article as $a){?>
		<div class="item">
			<div class="title"><a href="<?=http::url('article','index',array('id'=>$a['id']))?>"><?=$a['title']?></a></div>
			<div class="info">
				<div class="info-item">
					<i class="iconfont icon-riliriqi2"></i>
					<?=date('Y年m月d日',strtotime($a['createtime']))?>
				</div>
				<div class="info-item">
					<i class="iconfont icon-person-fill"></i>
					<?=$a['uname']?>
				</div>
				<div class="info-item">
					<i class="iconfont icon-chat"></i>
					<?=$a['comment_num']?>个评论
				</div>
				<div class="info-item">
					<i class="iconfont icon-read"></i>
					浏览<?=$a['read_num']?>次
				</div>
				
			</div>
			<div class="content">
				<?=$a['summary']?>
			</div>
			<div class="read-more">
				<a href="<?=http::url('article','index',array('id'=>$a['id']))?>">阅读全文</a>
			</div>
		</div>
		<?php }?>
		<?php }else{?>
		<iframe style="margin-top:30px;width: 100%;height: 700px;" scrolling='no' frameborder='0' src='http://blog.techer.top/index.php?c=index&a=__404'></iframe>
		<?php }?>
	</div>
	
	<?php include_once FRONT.'common/sidebar.php';?>
	
</div>

<?php include_once FRONT.'common/footer.php';?>
<script type="text/javascript" charset="utf-8" src="<?=assets::path('ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js')?>"></script>
<script>hljs.initHighlightingOnLoad();</script>
</body>
</html>