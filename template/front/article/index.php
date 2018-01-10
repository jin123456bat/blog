<?php
use framework\core\assets;
use framework\core\http;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?=$setting['site_title']?> | <?=$setting['site_desc']?></title>
<link rel="stylesheet" href="<?=assets::css('front/main.css')?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?=assets::css('front/article/index.css')?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?=assets::css('iconfont.css')?>" type="text/css" media="all" >
</head>
<body>

<?php include_once FRONT.'common/header.php';?>

<div class="container">
	<div class="article">
		<div class="item">
			<div class="title"><a href="<?=http::url('article','index',array('id'=>$article['id']))?>"><?=$article['title']?></a></div>
			<div class="info">
				<div class="info-item">
					<i class="iconfont icon-riqifuzhi"></i>
					<?=date('Y年m月d日',strtotime($article['createtime']))?>
				</div>
				<div class="info-item">
					<i class="iconfont icon-ionc--"></i>
					<?=$article['uname']?>
				</div>
				<div class="info-item">
					<i class="iconfont icon-chat"></i>
					<?=$article['comment_num']?>个评论
				</div>
				<div class="info-item">
					<i class="iconfont icon-read"></i>
					浏览<?=$article['read_num']?>次
				</div>
				
			</div>
			<div class="content">
				<?=$article['content']?>
			</div>
		</div>
	</div>
	<?php include_once FRONT.'common/sidebar.php';?>
</div>


<?php include_once FRONT.'common/footer.php';?>

</body>
</html>