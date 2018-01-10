<?php
use framework\core\assets;
use framework\core\http;
use framework\vendor\csrf;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?=$setting['site_title']?> | <?=$setting['site_desc']?></title>
<link rel="stylesheet" href="<?=assets::css('front/main.css')?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?=assets::css('front/index/index.css')?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?=assets::css('iconfont.css')?>" type="text/css" media="all" />
</head>
<body>

<?php include_once FRONT.'common/header.php';?>

<div class="container">
	<div class="article">
		<?php foreach ($article as $a){?>
		<div class="item">
			<div class="title"><a href="<?=http::url('article','index',array('id'=>$a['id']))?>"><?=$a['title']?></a></div>
			<div class="info">
				<div class="info-item">
					<i class="iconfont icon-riqifuzhi"></i>
					<?=date('Y年m月d日',strtotime($a['createtime']))?>
				</div>
				<div class="info-item">
					<i class="iconfont icon-ionc--"></i>
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
				<?=$a['content']?>
			</div>
			<div class="read-more">
				<a href="<?=http::url('article','index',array('id'=>$a['id']))?>">阅读全文</a>
			</div>
		</div>
		<?php }?>
	</div>
	
	<?php include_once FRONT.'common/sidebar.php';?>
	
</div>

<?php include_once FRONT.'common/footer.php';?>
</body>
</html>